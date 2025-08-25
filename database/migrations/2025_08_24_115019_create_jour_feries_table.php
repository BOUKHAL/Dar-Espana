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
        Schema::create('jour_feries', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->date('date');
            $table->text('description')->nullable();
            $table->enum('type', ['fixe', 'mobile'])->default('fixe'); // Fixe (même date chaque année) ou Mobile (date variable)
            $table->boolean('recurrent')->default(true); // Se répète chaque année
            $table->integer('annee')->nullable(); // Pour les jours fériés spécifiques à une année
            $table->string('couleur', 7)->default('#dc2626'); // Couleur pour l'affichage (format hex)
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['date', 'actif']);
            $table->unique(['nom', 'date']); // Un seul jour férié avec ce nom à cette date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jour_feries');
    }
};
