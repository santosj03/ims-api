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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username', 32)->index();
            $table->string('password');
            $table->string('email');
            $table->dateTime('email_verified_at')->nullable();
            $table->string('mobile')->nullable()->index();
            $table->integer('department_id')->nullable()->unsigned()->index();
            $table->integer('status_id')->nullable()->unsigned()->index();
            $table->boolean('is_admin')->default(false)->index();
            $table->dateTime('locked_at')->nullable();
            $table->dateTime('blocked_at')->nullable();
            $table->dateTime('password_expires_at')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->integer('failed_login')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('SET NULL');
            $table->foreign('status_id')->references('id')->on('user_status')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
