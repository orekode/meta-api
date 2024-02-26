<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\PaymentIntent;

use App\Models\Donation;

class PaymentController extends Controller
{
    public function oneTimePayment(Request $request) {

        Stripe::setApiKey('sk_test_51OnZlkByxm3zJLOqbBC3dAR3cZVOmQ9wJr7vmOlGO7DG3OZh6hv5jDbjb7byoHmWQvLMX34KybMgDuNzeMa4s0Vi00qlGzzCuh');
        $stripeClient = new StripeClient('sk_test_51OnZlkByxm3zJLOqbBC3dAR3cZVOmQ9wJr7vmOlGO7DG3OZh6hv5jDbjb7byoHmWQvLMX34KybMgDuNzeMa4s0Vi00qlGzzCuh');

        try {
            $customer = $stripeClient->customers->create([
                'email' => $request->email
            ]);


            $paymentIntent = PaymentIntent::create([
                'customer' => $customer->id,
                'amount' => $request->amount * 100,
                'currency' => 'ngn',
                'description' => $request->payment_type,
                'setup_future_usage' => 'off_session',
                'automatic_payment_methods' => [
                    'enabled' => 'true',
                ],
            ]);

            $image = $request->file('image')?->store('donations') ?? 'logo.png';

            Donation::create([
                'secret' => $paymentIntent->client_secret,
                'first_name' => $request->first_name ?? 'Anonymous',
                'last_name' => $request->last_name ?? 'Donor',
                'email' => $request->email,
                'contact' => $request->contact,
                'programe' => $request->program,
                'payment_type' => $request->payment_type ?? 'oneTime',
                'amount' => $request->amount,
                'client_sk' => $paymentIntent->client_secret,
                'customer' => $customer->id,
                'image' => $image,
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret
            ]);
        }
        catch (Exception $e) {

        }
    }

    public function confirmPayment(Request $request) {
        $request->validate([
            'client_sk' => ['required'],
            'payment_method' => ['required'],
        ]);

        Donation::where('client_sk', $request->client_sk)->first()->update([
            'status' => 'confirmed',
            'method' => $request->payment_method
        ]);

        return response()->json([
            'status' => 'success',
            'title' => 'Payment Confirmed'
        ]);
    }

    public function recurringPayment($client, $customer) {
        Stripe::setApiKey('sk_test_51OnZlkByxm3zJLOqbBC3dAR3cZVOmQ9wJr7vmOlGO7DG3OZh6hv5jDbjb7byoHmWQvLMX34KybMgDuNzeMa4s0Vi00qlGzzCuh');
        $stripeClient = new StripeClient('sk_test_51OnZlkByxm3zJLOqbBC3dAR3cZVOmQ9wJr7vmOlGO7DG3OZh6hv5jDbjb7byoHmWQvLMX34KybMgDuNzeMa4s0Vi00qlGzzCuh');

        $donation = Donation::where('client_sk', $client)->first();

        if(!$donation) return response()->json(['status' => 'error'], 403);


        $paymentIntent = PaymentIntent::create([
            'customer' => $customer,
            'amount' => ($donation->amount ?? 0) * 100,
            'currency' => 'ngn',
            'description' => "monthly payment",
            'payment_method' => $donation->method,
            'off_session' => true,
            'confirm' => true,
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret
        ]);

    }
}
