<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->string('name');
            $table->string('brand');
            $table->float('mrp');
            $table->integer('total_packet');
            $table->float('price_per_carot');
            $table->string('packaging_type');
            $table->float('net_weight');
            $table->float('net_per_unit');
            $table->integer('units_per_carton');
            $table->string('batch');
            $table->date('mfg_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->float('payable_amount');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
