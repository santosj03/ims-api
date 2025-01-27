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
        Schema::create('stock_receiving_details', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_receiving_id')->nullable()->index();
            $table->string('serial')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stock_receiving_id')->references('id')->on('stock_receiving')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_receiving_details');
    }
};
