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
        Schema::create('product_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->nullable()->unsigned()->index();
            $table->integer('branch_id')->nullable()->unsigned()->index();
            $table->string('serial')->unique()->index();
            $table->boolean('is_sold')->default(false);
            $table->dateTime('date_sold')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
