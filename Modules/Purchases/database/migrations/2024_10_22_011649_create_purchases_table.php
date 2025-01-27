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
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('po_no')->unique()->index();
            $table->text('description')->nullable();
            $table->integer('supplier_id')->nullable()->unsigned()->index();
            $table->float('amount', 8, 2)->nullable();
            $table->string('ship_via')->nullable();
            $table->dateTime('target_delivery')->nullable();
            $table->integer('payment_type_id')->nullable()->unsigned();
            $table->string('payment_status')->nullable()->index();
            $table->string('status')->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('SET NULL');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
