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
        Schema::table('dossiers_medicaux', function (Blueprint $table) {
            $table->string('dicom_instance_id')->nullable();
            $table->json('dicom_metadata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers_medicaux', function (Blueprint $table) {
            $table->dropColumn('dicom_instance_id');
            $table->dropColumn('dicom_metadata');
        });
    }
};
