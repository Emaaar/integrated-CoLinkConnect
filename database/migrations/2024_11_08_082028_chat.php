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

        // Schema::create('chat', function (Blueprint $table) {
        //     $table->bigIncrements('chat_id'); // Primary key
        //     $table->timestamp('timestamp');
        //     $table->string('sender_email');
        //     $table->string('receiver_email');

        //     // Foreign key (nullable)
        //     $table->unsignedBigInteger('client_id')->nullable();

        //     // Foreign key constraint
        //     $table->foreign('client_id')->references('client_id')->on('users')->onDelete('set null');
        // });
        Schema::create('chat', function (Blueprint $table) {
            $table->bigIncrements('chat_id');
            $table->boolean('deleted_by_user')->default(false); //added for deletion
            $table->timestamp('timestamp');
            $table->string('sender_email');
            $table->string('receiver_email');
            $table->text('message');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('client_id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
