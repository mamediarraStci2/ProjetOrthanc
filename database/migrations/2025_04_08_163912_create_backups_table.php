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
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dossier_medical_id')->nullable(); 
                // Si chaque backup est lié à un dossier médical précis

            $table->dateTime('date_sauvegarde');
            $table->text('donnees_sauvegardees');
            // Autres champs si besoin

            $table->timestamps();

            // Relation
            $table->foreign('dossier_medical_id')
                  ->references('id')
                  ->on('dossiers_medicaux')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
