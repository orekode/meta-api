<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        if(!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'title'  => 'Invalid Email or Password',
                'text'   => 'please check your inputs and try again'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Login Successfull',
            'text' => 'welcome back',
            'token' => Auth::user()->createToken('auth-key')->plainTextToken,
        ], 200);
    }

    public function logout() {


        if(Auth::user()->tokens()->delete()) {

            

            return response()->json([
                'status' => 'success',
                'title' => 'Logged Out',
                'text' => 'bye for now!',
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'title' => 'System is Unavailable',
            'text' => 'please try again later',
        ], 503);

    }

    public function notLoggedIn() {
        return response()->json([
            'error' => 'user is not logged in ',
        ], 401);
    }

    public function user (Request $request) {
        return $request->user();
    }
}
