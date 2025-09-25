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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 33)->unique()->default(DB::raw("(
                CONCAT(
                    DATE_FORMAT(NOW(6), '%Y%m%d%H%i%s%f'),
                    SUBSTRING(MD5(CONCAT(NOW(6), RAND(), CONNECTION_ID())), 1, 8)
                )
            )"));
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('brand_name');
            $table->integer('total_packet');
            $table->float('price_per_carot');
            $table->float('mrp');
            $table->string('packaging_type');
            $table->string('net_weight');
            $table->float('net_per_unit');
            $table->integer('units_per_carton');
            $table->string('batch')->nullable();
            $table->date('mfg_date');
            $table->date('exp_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
