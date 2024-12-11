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
            $table->bigIncrements('client_id'); // Primary key
            $table->string('user_email')->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('organization');
            $table->string('password');
            $table->integer('otp')->nullable();
            $table->timestamp('otp_created_at')->nullable();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('admin_id'); // Primary key
            $table->string('aduser_email');
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('admin');
    }
};
