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
            $table->unsignedBigInteger('patient_id');  // Foreign Key vers patients
            $table->unsignedBigInteger('medecin_id');  // Foreign Key vers medecins

            $table->dateTime('date_heure');
            $table->string('sujet');  // Objet du rendez-vous ou motif
            // Tout autre champ nécessaire

            $table->timestamps();

            // Clés étrangères
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
