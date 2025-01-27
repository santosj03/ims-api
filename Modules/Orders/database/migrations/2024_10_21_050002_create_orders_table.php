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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->nullable()->unsigned()->index();
            $table->integer('encoder_id')->nullable()->unsigned()->index();
            $table->integer('branch_id')->nullable()->unsigned()->index();
            $table->integer('payment_type_id')->nullable()->unsigned()->index();
            $table->string('payment_status')->index();
            $table->integer('item_count')->nullable();
            $table->float('downpayment', 8, 2)->nullable();
            $table->float('ship_cost', 8, 2)->nullable();
            $table->float('other_cost', 8, 2)->nullable();
            $table->float('amount', 8, 2)->nullable();
            $table->float('discount', 8, 2)->nullable();
            $table->string('status')->index();
            $table->boolean('is_with_rts')->default(false);
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('pickup_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('SET NULL');
            $table->foreign('encoder_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
