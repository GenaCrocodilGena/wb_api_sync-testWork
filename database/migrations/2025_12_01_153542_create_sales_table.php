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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_id')->unique();
            $table->string('g_number')->nullable();

            $table->date('date')->nullable()->index();
            $table->date('last_change_date')->nullable();

            $table->string('supplier_article')->nullable()->index();
            $table->string('tech_size')->nullable();

            $table->bigInteger('barcode')->nullable();

            $table->decimal('total_price', 15, 2)->nullable();
            $table->unsignedTinyInteger('discount_percent')->nullable();

            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);

            $table->decimal('promo_code_discount', 15, 2)->nullable();

            $table->string('warehouse_name')->nullable()->index();
            $table->string('country_name')->nullable();
            $table->string('oblast_okrug_name')->nullable();
            $table->string('region_name')->nullable();

            $table->unsignedBigInteger('income_id')->nullable();
            $table->string('odid')->nullable();
            $table->bigInteger('nm_id')->nullable()->index();

            $table->unsignedTinyInteger('spp')->nullable();

            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();

            $table->decimal('for_pay', 15, 2)->nullable();
            $table->decimal('finished_price', 15, 2)->nullable();
            $table->decimal('price_with_disc', 15, 2)->nullable();

            $table->boolean('is_storno')->nullable();

            $table->json('payload');

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
