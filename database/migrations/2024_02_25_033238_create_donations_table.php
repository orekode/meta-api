<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->default('Anonymous');
            $table->string('last_name')->default('Donor');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('programe');
            $table->string('payment_type');
            $table->string('amount');
            $table->string('client_sk');
            $table->string('customer');
            $table->string('method')->nullable();
            $table->string('image')->default('logo.png');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
};
