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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();

            // Clés étrangères
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('medecin_id');

            // Champs du rendez-vous
            $table->dateTime('date_heure');            // Date et heure du rendez-vous
            $table->string('sujet');                   // Sujet ou motif du rendez-vous
            $table->boolean('is_validated')->default(false); // Validation du rendez-vous (par défaut non validé)

            $table->timestamps();

            // Contraintes de clé étrangère
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');

            $table->foreign('medecin_id')
                  ->references('id')
                  ->on('medecins')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
