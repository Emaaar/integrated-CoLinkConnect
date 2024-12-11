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
        Schema::create('blog', function (Blueprint $table) {
            $table->bigIncrements('blog_id'); //---------------primary key
            $table->string('blog_title')->nullable();
            $table->date('date');
            $table->longText('caption')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();  // Foreign key (from admin table)
            $table->longText('comment')->nullable();
            $table->integer('rate')->nullable();
            $table->string('image')->nullable(); // Image path
            $table->unsignedBigInteger('client_id')->nullable(); // Foreign key (from user table)

            // Add the foreign key constraints
            $table->foreign('client_id')->references('client_id')->on('users')->onDelete('set null');
            $table->foreign('admin_id')->references('admin_id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
