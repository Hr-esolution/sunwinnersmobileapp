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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type_demandeur'); // 'personne' ou 'societe'
            $table->date('date');
            $table->string('reference')->unique();
            $table->string('type_demande'); // 'nouvelle installation', 'extension et mise à niveau', 'entretien et réparation'
            $table->string('objectif'); // 'réduction de consommation', 'stockage d'énergie', 'extension future prévue'
            $table->string('type_installation');
            $table->string('type_pompe')->nullable(); // 'surface' ou 'immergée' (si applicable)
            $table->decimal('debit_estime', 8, 2)->nullable(); // m3/ha (si applicable)
            $table->integer('profondeur_forage')->nullable(); // (si applicable)
            $table->integer('capacite_reservoir')->nullable(); // (si applicable)
            $table->text('adresse_complete');
            $table->text('toit_installation');
            $table->json('images')->nullable(); // JSON pour stocker plusieurs fichiers
            $table->string('type_utilisation'); // 'domestique', 'industrielle', 'agricole'
            $table->enum('status', ['draft', 'submitted', 'assigned', 'answered', 'accepted', 'rejected', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};