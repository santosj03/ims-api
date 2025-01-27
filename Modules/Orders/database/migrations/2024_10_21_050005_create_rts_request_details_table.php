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
        Schema::create('rts_request_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rts_request_id')->nullable()->unsigned()->index();
            $table->integer('order_detail_id')->nullable()->unsigned()->index();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rts_request_id')->references('id')->on('rts_requests')->onDelete('SET NULL');
            $table->foreign('order_detail_id')->references('id')->on('order_details')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rts_request_details');
    }
};
