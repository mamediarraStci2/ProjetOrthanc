<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // Identifiant auto-incrémenté (clé primaire)
            
            // Optionnel : Si un lien vers la table 'utilisateurs' est nécessaire
            $table->unsignedBigInteger('utilisateur_id')->nullable();
            $table->foreign('utilisateur_id')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('cascade');

            // Le NNS (Numéro National de Santé) sera unique pour chaque patient
            $table->string('nss')->unique();

            // Informations personnelles essentielles
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');

            // Optionnel : Autres informations complémentaires
            $table->text('informations')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
