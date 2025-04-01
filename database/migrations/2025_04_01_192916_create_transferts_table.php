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
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');           // Patient concerné
            $table->unsignedBigInteger('hopital_source_id');      // Hôpital d'où provient le dossier
            $table->unsignedBigInteger('hopital_destination_id'); // Hôpital de destination
            $table->string('statut')->default('en attente');      // Statut : en attente, validé, refusé
            $table->dateTime('date_demande')->nullable();         // Date de la demande de transfert
            $table->dateTime('date_transfert')->nullable();       // Date effective du transfert
            $table->timestamps();

            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');

            $table->foreign('hopital_source_id')
                  ->references('id')
                  ->on('hospitals')
                  ->onDelete('restrict');

            $table->foreign('hopital_destination_id')
                  ->references('id')
                  ->on('hospitals')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
