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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');         // Patient concerné
            $table->unsignedBigInteger('user_id');            // Médecin ou soignant qui consulte
            $table->dateTime('date_consultation');              // Date et heure de la consultation
            $table->string('diagnostic')->nullable();         // Diagnostic posé
            $table->text('traitement')->nullable();           // Traitement prescrit
            $table->text('observations')->nullable();         // Observations complémentaires
            $table->timestamps();

            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
