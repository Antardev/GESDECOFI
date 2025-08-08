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
        Schema::create('end_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id');

            $table->string('mention')->nullable();
            $table->string('commentaire')->nullable();
            $table->string('attest_ident')->nullable();

            $table->boolean('cert_issued')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('end_stages');
    }
};
