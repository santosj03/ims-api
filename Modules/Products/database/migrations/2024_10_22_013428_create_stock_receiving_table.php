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
        Schema::create('stock_receiving', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('received_id')->nullable()->index();
            $table->string('received_type')->nullable();
            $table->integer('total_received_item')->nullable();
            $table->integer('total_pending_item')->nullable();
            $table->integer('received_by')->nullable()->unsigned();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable()->index();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('received_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_receiving');
    }
};
