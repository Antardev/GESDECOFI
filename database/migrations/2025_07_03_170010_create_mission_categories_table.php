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
        Schema::create('mission_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id');
            $table->foreignId('mission_id');
            $table->foreignId('categorie_id');
            //$table->string('categorie_name');
            $table->string('hours');
            $table->string('semester');
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_categories');
    }
};
