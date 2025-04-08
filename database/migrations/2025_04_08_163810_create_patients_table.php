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
            $table->unsignedBigInteger('utilisateur_id'); // Clé étrangère vers 'utilisateurs'
            
            $table->string('nss');           // Numéro de sécu, par exemple
            $table->text('informations');    // Infos supplémentaires du patient
            // Ou d’autres champs selon vos besoins métier

            $table->timestamps();

            // Définition de la clé étrangère
            $table->foreign('utilisateur_id')
                  ->references('id')
                  ->on('utilisateurs')
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
