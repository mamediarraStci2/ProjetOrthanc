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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('numero_identification')->unique(); // Numéro de dossier ou d'identification
            $table->string('nom');                               // Nom du patient
            $table->string('prenom');                            // Prénom du patient
            $table->date('date_de_naissance');                   // Date de naissance
            $table->string('groupe_sanguin')->nullable();        // Groupe sanguin
            $table->text('allergies')->nullable();               // Allergies éventuelles
            $table->string('adresse')->nullable();               // Adresse personnelle
            $table->string('telephone')->nullable();             // Téléphone
            $table->string('email')->nullable();                 // Email
            $table->unsignedBigInteger('hospital_id');           // Hôpital rattaché
            $table->timestamps();

            $table->foreign('hospital_id')
                  ->references('id')
                  ->on('hospitals')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
