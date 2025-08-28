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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('fichier_path');
            $table->string('fichier_nom');
            $table->string('type_fichier');
            $table->bigInteger('taille_fichier')->nullable();
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('niveau_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('ordre')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
