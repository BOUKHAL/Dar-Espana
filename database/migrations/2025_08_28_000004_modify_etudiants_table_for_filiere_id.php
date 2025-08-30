<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Ajouter la colonne filiere_id
            $table->foreignId('filiere_id')->nullable()->constrained('filieres')->onDelete('set null');
            
            // Supprimer l'ancienne colonne filiere (string)
            $table->dropColumn('filiere');
        });
    }

    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Remettre l'ancienne colonne filiere
            $table->enum('filiere', ['SANTÉ', 'INGÉNIERIE', 'ARCHITECTURE', 'ÉCONOMIE', 'DROIT', 'SPORT ÉTUDES']);
            
            // Supprimer la clé étrangère et la colonne filiere_id
            $table->dropForeign(['filiere_id']);
            $table->dropColumn('filiere_id');
        });
    }
};
