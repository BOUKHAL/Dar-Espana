<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone_etudiant');
            $table->string('telephone_parents');
            $table->string('email')->unique();
            $table->enum('type_baccalaureat', ['bac_marocain', 'bac_francais']);
            $table->foreignId('centre_id')->constrained('centres')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->enum('filiere', ['SANTÉ', 'INGÉNIERIE', 'ARCHITECTURE', 'ÉCONOMIE', 'DROIT', 'SPORT ÉTUDES']);
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};
