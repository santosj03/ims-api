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
        Schema::create('stock_transfer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_branch_id')->nullable()->unsigned()->index();
            $table->integer('to_branch_id')->nullable()->unsigned()->index();
            $table->integer('total_item')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable()->index();
            $table->integer('prepared_by')->nullable()->unsigned();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('from_branch_id')->references('id')->on('branches')->onDelete('SET NULL');
            $table->foreign('to_branch_id')->references('id')->on('branches')->onDelete('SET NULL');
            $table->foreign('prepared_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer');
    }
};
