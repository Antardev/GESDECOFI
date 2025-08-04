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
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id');
            $table->string('rapport_name');
            $table->text('rapport_comment')->nullable();
            $table->integer('year');
            $table->integer('semester');
            $table->string('rapport_file');

            $table->boolean('is_delayed')->default(false);
            $table->boolean('validated')->default(false);
            $table->date('validated_at')->nullable();
            $table->string('validated_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapports');
    }
};
