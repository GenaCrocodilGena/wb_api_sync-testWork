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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('g_number')->nullable();
            $table->datetime('date')->nullable()->index();
            $table->date('last_change_date')->nullable()->index();

            $table->string('supplier_article')->nullable()->index();
            $table->string('tech_size')->nullable();
            $table->bigInteger('barcode')->nullable();

            $table->decimal('total_price', 15, 2)->nullable();
            $table->unsignedTinyInteger('discount_percent')->nullable();

            $table->string('warehouse_name')->nullable()->index();
            $table->string('oblast')->nullable();

            $table->unsignedBigInteger('income_id')->nullable();
            $table->string('odid')->nullable()->nullable();
            $table->bigInteger('nm_id')->nullable();

            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();

            $table->boolean('is_cancel')->default(false);
            $table->date('cancel_dt')->nullable();

            $table->json('payload'); // и я надеюсь, вы не будете против сохранять сырой объект с api (пытаюсь делать качественно)

            $table->timestamps();
            
            $table->unique(['g_number','nm_id','barcode'], 'orders_unique_key'); // Столкунлся с дублированием в бд при перегонке данных поэтому решил уникальный индекс добавить по красоте
            
            $table->index('is_cancel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
