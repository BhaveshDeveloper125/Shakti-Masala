<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customers_id');
            $table->integer('invoice');
            $table->string('customer_name');
            $table->string('customer_type')->nullable();
            $table->date('date');
            $table->string('payment_mode')->nullable();
            $table->string('payment_status');
            $table->float('partial_amount')->nullable();
            $table->float('extra_charges')->nullable();
            $table->float('total_price');

            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_histories');
    }
};
