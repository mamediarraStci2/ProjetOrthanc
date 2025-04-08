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
        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id');           // Clé étrangère vers 'utilisateurs'
            $table->unsignedBigInteger('specialite_medicale_id');   // Clé étrangère vers 'specialite_medicales'
            
            $table->string('hopital');   // Établissement d’exercice
            // Autres champs si nécessaire

            $table->timestamps();

            // Clés étrangères
            $table->foreign('utilisateur_id')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('cascade');

            $table->foreign('specialite_medicale_id')
                  ->references('id')
                  ->on('specialite_medicales')
                  ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medecins');
    }
};
