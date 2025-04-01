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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                               // Nom de l'utilisateur
            $table->string('prenom');                            // Prénom de l'utilisateur
            $table->string('email')->unique();                 // Email
            $table->timestamp('email_verified_at')->nullable();  // Date de vérification de l'email
            $table->string('mot_de_passe');                      // Mot de passe (hashé)
            $table->string('telephone')->nullable();             // Téléphone (optionnel)
            $table->unsignedBigInteger('role_id');               // Référence au rôle
            $table->unsignedBigInteger('hospital_id')->nullable(); // Référence à l'hôpital d'affectation (optionnel)
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('restrict');

            $table->foreign('hospital_id')
                  ->references('id')
                  ->on('hospitals')
                  ->onDelete('set null');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};