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
        Schema::create('journee_techniques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id');
            $table->string('jt_name');
            $table->string('jt_description');
            $table->date('jt_date');
            $table->string('jt_location')->nullable();
            $table->string('jt_year')->nullable();
            $table->string('rapport_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journee_techniques');
    }
};
