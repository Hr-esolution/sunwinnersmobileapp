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
        Schema::create('subvention_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('nom_projet');
            $table->string('type_projet');
            $table->string('nom');
            $table->text('adresse');
            $table->string('telephone');
            $table->string('representant')->nullable();
            $table->string('email');
            $table->string('secteur')->nullable();
            $table->string('type_entreprise')->nullable();
            $table->string('taille_entreprise')->nullable();
            $table->text('description_projet');
            $table->text('adresse_projet');
            $table->date('date_debut');
            $table->json('eligibilite')->nullable();
            $table->string('signataire_nom');
            $table->string('signataire_fonction');
            $table->string('signataire_signature')->nullable();
            $table->string('signataire_lieu_date');
            $table->enum('statut', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subvention_requests');
    }
};