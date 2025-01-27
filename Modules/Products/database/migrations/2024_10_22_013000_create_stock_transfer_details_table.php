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
        Schema::create('stock_transfer_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stock_transfer_id')->nullable()->unsigned()->index();
            $table->integer('product_id')->nullable()->unsigned()->index();
            $table->integer('product_item_id')->nullable()->unsigned()->index();
            $table->integer('qty')->nullable();
            $table->integer('qty_received')->nullable();
            $table->boolean('is_received')->default(false);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stock_transfer_id')->references('id')->on('stock_transfer')->onDelete('SET NULL');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
            $table->foreign('product_item_id')->references('id')->on('product_items')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer_details');
    }
};
