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
        // Schema::create('donation', function (Blueprint $table) {
        //     $table->bigIncrements('donation_num'); // Primary key
        //     $table->string('donor_name');
        //     $table->longText('prefer')->nullable();
        //     $table->integer('amount');

        //     // Foreign keys
        //     $table->unsignedBigInteger('client_id')->nullable(); // Foreign key (from users table)
        //     $table->string('user_email')->nullable(); // Foreign key (from users table)

        //     // Add the foreign key constraints
        //     $table->foreign('client_id')->references('client_id')->on('users')->onDelete('set null');
        //     $table->foreign('user_email')->references('user_email')->on('users')->onDelete('set null');
        // });
        Schema::create('donation', function (Blueprint $table) {
            $table->bigIncrements('donation_num'); // Primary key
            $table->string('donor_name');
            $table->longText('prefer')->nullable();
            $table->integer('amount');

            // Foreign keys
            $table->unsignedBigInteger('client_id')->nullable(); // Foreign key (from users table)
            $table->string('user_email', 255)->nullable(); // Foreign key (from users table, ensure the length matches)

            // Add the foreign key constraints
            $table->foreign('client_id')->references('client_id')->on('users')->onDelete('set null');
            $table->foreign('user_email')->references('user_email')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['user_email']);
        });

        Schema::dropIfExists('donation');
    }
};
