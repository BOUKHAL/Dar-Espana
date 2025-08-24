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
        Schema::create('planifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centre_id')->constrained('centres')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->string('titre');
            $table->string('fichier_path');
            $table->string('type_fichier'); // pdf ou excel
            $table->date('semaine_debut');
            $table->date('semaine_fin');
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planifications');
    }
};
