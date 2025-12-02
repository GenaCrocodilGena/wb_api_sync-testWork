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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_id')->nullable()->index();
            $table->string('number')->nullable();

            $table->date('date')->nullable()->index();
            $table->date('last_change_date')->nullable();;

            $table->string('supplier_article')->nullable()->index();
            $table->string('tech_size')->nullable();

            $table->bigInteger('barcode')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->decimal('total_price', 15, 2)->default(0);
            $table->date('date_close')->nullable();
            $table->string('warehouse_name')->nullable()->index();
            $table->bigInteger('nm_id')->nullable()->index();
            $table->json('payload');
            $table->timestamps();
            $table->unique(['income_id', 'nm_id', 'barcode'], 'incomes_unique_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
