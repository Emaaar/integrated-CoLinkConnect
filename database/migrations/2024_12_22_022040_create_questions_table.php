<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('needs_assessment_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->string('type'); // Multiple choice, short answer, etc.
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
