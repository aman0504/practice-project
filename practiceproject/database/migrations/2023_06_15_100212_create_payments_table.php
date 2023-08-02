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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('user_cards_id')->references('id')->on('user_cards')->onDelete('cascade');
            $table->string('user_cards_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('balance_transaction')->nullable();
            $table->string('customer')->nullable();
            $table->string('currency')->nullable();
            $table->string('amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('admin_getpaymenttransfer_id')->nullable();
            $table->string('status')->nullable();
            $table->string('admin_pay_to_worker_id')->nullable();
            $table->string('is_refunded')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
