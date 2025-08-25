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
        Schema::create('candidat_admis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stagiaire_id');
            $table->string('matricule')->unique();
            $table->string('firstname');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('birthday');
            $table->string('country');

            $table->date('end_stage')->nullable();
            $table->string('year');
            $table->string('year_admition');
            $table->date('admis_le')->nullable();
            $table->boolean('admis')->default(false)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidat_admis');
    }
};
