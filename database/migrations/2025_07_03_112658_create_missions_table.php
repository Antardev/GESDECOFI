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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id');
            $table->foreignId('categorie_id');
            $table->string('mission_name');
            $table->string('mission_description');
            $table->date('mission_begin_date');
            $table->date('mission_end_date');
            $table->string('mission_location');
            $table->string('mission_year');
            $table->string('nb_hour')->nullable();
            $table->string('rapport_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
