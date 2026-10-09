<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category');                       // desayuno, almuerzo, cena, postre, bebida
            $table->unsignedInteger('minutes')->nullable();
            $table->string('difficulty')->nullable();         // facil, medio, dificil
            $table->text('ingredients')->nullable();          // uno por línea
            $table->text('steps')->nullable();                // uno por línea
            $table->text('personal_note')->nullable();        // nota personal opcional
            $table->timestamps();

            $table->index(['user_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
