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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->boolean('is_company')->default(false);
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('addr_street')->nullable();
            $table->string('addr_brgy')->nullable();
            $table->string('addr_city')->nullable();
            $table->string('addr_province')->nullable();
            $table->string('addr_zip')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
