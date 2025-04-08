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
        Schema::create('dossiers_medicaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');  // Clé étrangère vers patients

            $table->dateTime('date_derniere_prise');
            $table->text('donnees_suivis'); // Ex: historique des visites, traitements, analyses, etc.
            // Autres champs selon votre diagramme (antécédents, allergies...)

            $table->timestamps();

            // Relation
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers_medicaux');
    }
};
