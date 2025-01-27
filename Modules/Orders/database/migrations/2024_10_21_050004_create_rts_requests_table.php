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
        Schema::create('rts_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable()->unsigned()->index();
            $table->boolean('is_per_item')->default(false);
            $table->text('description')->nullable();
            $table->string('status')->index();
            $table->integer('encoded_by')->nullable()->unsigned()->index();
            $table->integer('validated_by')->nullable()->unsigned()->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL');
            $table->foreign('encoded_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rts_requests');
    }
};
