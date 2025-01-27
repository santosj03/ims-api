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
        Schema::create('stock_adjustment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->nullable()->unsigned()->index();
            $table->string('description')->nullable();
            $table->integer('total_qty')->nullable();
            $table->integer('adjusted_by')->nullable()->unsigned();
            $table->string('status')->nullable()->index();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL');
            $table->foreign('adjusted_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment');
    }
};
