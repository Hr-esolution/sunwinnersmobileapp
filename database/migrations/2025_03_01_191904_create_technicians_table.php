<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechniciansTable extends Migration
{
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('certificates')->nullable();
            $table->text('experience')->nullable();
            $table->string('company_name')->nullable(); // Nom de l'entreprise
            $table->string('address')->nullable();      // Adresse de l'entreprise
            $table->string('phone')->nullable();        // Numéro de téléphone
            $table->string('logo')->nullable();         // Logo de l'entreprise
            $table->timestamps();

            // Clé étrangère liée à la table users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('technicians');
    }
}