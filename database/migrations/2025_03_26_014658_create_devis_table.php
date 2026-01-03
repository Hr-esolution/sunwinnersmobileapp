<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();
            $table->enum('type_demandeur', ['personne', 'societe']);
            $table->date('date')->default(now());
            $table->string('reference')->unique()->index();
            $table->enum('status', [
                'en_cours_de_traitement',       // Avant la réponse du technicien
                'repondu_par_technicien',       // Après la réponse du technicien
                'accepte_par_client',
                'refusé_par_client',           // Après validation du client
                'en_attente_confirmation_technicien', // Attente de confirmation du technicien
                'termine'                       // Devis terminé (si nécessaire)
            ])->default('en_cours_de_traitement');

            // Détails de la demande
            $table->enum('type_demande', [
                'nouvelle_installation',
                'extension_mise_a_niveau',
                'entretien_reparation'
            ]);
            $table->enum('objectif', [
                'reduction_consommation',
                'stockage_energie',
                'extension_future_prevue'
            ]);
            $table->enum('type_installation', [
                'autoconsommation_injection_surplus',
                'autoconsommation_sans_injection',
                'installation_autonome_offgrid',
                'pompage_solaire'
            ]);

            // Type d'utilisation
            $table->enum('type_utilisation', ['domestique', 'industrielle', 'agricole']);

            // Champs spécifiques à Pompage Solaire (si applicable)
            $table->enum('type_pompe', ['surface', 'immergee'])->nullable();
            $table->decimal('debit_estime', 8, 2)->nullable();
            $table->integer('profondeur_forage')->nullable();
            $table->integer('capacite_reservoir')->nullable();

            // Localisation et fichiers
            $table->text('adresse_complete')->nullable();
            $table->string('toit_installation')->nullable();
            $table->json('images')->nullable();

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
}