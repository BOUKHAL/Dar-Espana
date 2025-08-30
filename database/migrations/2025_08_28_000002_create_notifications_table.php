<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('message');
            $table->enum('type_destinataire', ['tous', 'etudiant_specifique', 'centre', 'option', 'filiere']);
            $table->string('destinataire_specifique')->nullable(); // Email de l'étudiant spécifique
            $table->foreignId('centre_id')->nullable()->constrained('centres')->onDelete('set null');
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('set null');
            $table->enum('filiere', ['SANTÉ', 'INGÉNIERIE', 'ARCHITECTURE', 'ÉCONOMIE', 'DROIT', 'SPORT ÉTUDES'])->nullable();
            $table->integer('nombre_destinataires')->default(0);
            $table->enum('statut', ['brouillon', 'envoye', 'echec'])->default('brouillon');
            $table->foreignId('envoye_par')->constrained('users')->onDelete('cascade');
            $table->timestamp('envoye_le')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
