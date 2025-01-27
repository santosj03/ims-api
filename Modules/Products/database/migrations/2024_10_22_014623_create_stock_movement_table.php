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
        Schema::create('stock_movement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->index();
            $table->string('reference_no')->index();
            $table->integer('product_id')->nullable()->unsigned()->index();
            $table->integer('product_item_id')->nullable()->unsigned()->index();
            $table->string('serial')->nullable();
            $table->integer('beg_bal')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('end_bal')->nullable();
            $table->string('status')->index();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
            $table->foreign('product_item_id')->references('id')->on('product_items')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movement');
    }
};
