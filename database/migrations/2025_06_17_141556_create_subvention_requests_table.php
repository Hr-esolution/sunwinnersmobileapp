<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubventionRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('subvention_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nom_projet')->nullable();
            $table->string('type_projet')->nullable(); // Solaire, Eolien
            $table->string('nom')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('representant')->nullable();
            $table->string('email')->nullable();
            $table->string('secteur')->nullable();
            $table->string('type_entreprise')->nullable();
            $table->string('taille_entreprise')->nullable();
            $table->text('description_projet')->nullable();
            $table->string('adresse_projet')->nullable();
            $table->date('date_debut')->nullable();
            $table->json('eligibilite')->nullable();
            $table->string('signataire_nom')->nullable();
            $table->string('signataire_fonction')->nullable();
            $table->string('signataire_signature')->nullable();
            $table->string('signataire_lieu_date')->nullable();
            $table->enum('statut', ['en_attente', 'confirmee', 'refusee'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subvention_requests');
    }
}