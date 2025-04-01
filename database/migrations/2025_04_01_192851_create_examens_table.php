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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id');     // Référence à la consultation
            $table->string('type_examen');                      // Type d'examen (radiographie, analyse, etc.)
            $table->text('resultats')->nullable();              // Résultats de l'examen
            $table->date('date_examen')->nullable();            // Date de l'examen
            $table->string('fichier_examen')->nullable();       // Chemin vers le fichier d'examen, si applicable
            $table->timestamps();

            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examens');
    }
};
