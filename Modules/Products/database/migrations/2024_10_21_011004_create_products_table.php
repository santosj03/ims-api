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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('itemcode')->unique()->index();
            $table->integer('category_id')->nullable()->unsigned()->index();
            $table->integer('brand_id')->nullable()->unsigned()->index();
            $table->integer('supplier_id')->nullable()->unsigned()->index();
            $table->integer('uom_id')->nullable()->unsigned()->index();
            $table->integer('created_by')->nullable()->unsigned()->index();
            $table->integer('updated_by')->nullable()->unsigned()->index();
            $table->string('sku')->unique()->index();
            $table->string('name')->index();
            $table->text('description')->nullable()->index();
            $table->float('price', 8, 2)->nullable();
            $table->boolean('is_per_single_unit')->default(false);
            $table->integer('psu_inv_deduction')->default(1);
            $table->float('avg_cost_per_item', 8, 2)->nullable();
            $table->integer('maintaining_bal')->nullable();
            $table->string('warranty_terms')->nullable();
            $table->string('image_src')->nullable();
            $table->boolean('is_active')->default(false);
            $table->dateTime('date_expiry')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('SET NULL');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('SET NULL');
            $table->foreign('uom_id')->references('id')->on('unit_of_measures')->onDelete('SET NULL');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
