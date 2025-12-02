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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable()->index();
            $table->date('last_change_date')->nullable();;
            $table->string('supplier_article')->nullable()->index();
            $table->string('tech_size')->nullable();
            $table->bigInteger('barcode')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);
            $table->unsignedInteger('quantity_full')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->unsignedInteger('in_way_to_client')->nullable();
            $table->unsignedInteger('in_way_from_client')->nullable();
            $table->bigInteger('nm_id')->nullable()->index();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->unsignedBigInteger('sc_code')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->unsignedTinyInteger('discount')->nullable();
            $table->json('payload');
            $table->timestamps();
            $table->unique(['barcode', 'nm_id', 'warehouse_name'], 'stocks_unique_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
