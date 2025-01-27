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
        Schema::create('parameter_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category', 50);
            $table->string('code', 100);
            $table->string('description')->nullable();
            $table->string('data_type', 50);
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_configs');
    }
};
