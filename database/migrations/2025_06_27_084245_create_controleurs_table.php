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
        Schema::create('controleurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name'); 
            $table->string('firstname'); 
            $table->date('date');
            $table->string('country'); 
            $table->string('country_contr'); 
            $table->string('email'); 
            $table->string('phone');
            $table->string('phone_code');
            $table->string('type');
            $table->string('affiliation')->nullable();
            $table->boolean('validated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controleurs');
    }
};
