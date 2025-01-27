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
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->nullable()->unsigned()->index();
            $table->integer('product_item_id')->nullable()->unsigned()->index();
            $table->integer('order_id')->nullable()->unsigned()->index();
            $table->float('price', 8, 2)->nullable();
            $table->dateTime('rts_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
            $table->foreign('product_item_id')->references('id')->on('product_items')->onDelete('SET NULL');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
