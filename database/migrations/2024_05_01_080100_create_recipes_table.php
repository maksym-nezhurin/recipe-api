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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('creator_id')->constrained('users');
            $table->string('name');
            $table->text('description');
            $table->string('image')->default('/test.jpg');
            $table->integer('prep_time')->default(1000);
//            $table->('ingredients'); we need reference to another table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
