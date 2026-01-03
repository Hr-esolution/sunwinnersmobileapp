<?php

namespace App\Repositories;

use App\Interfaces\DevisRepositoryInterface;
use App\Models\Devis;
use App\Models\DevisResponse;
use App\Models\Project;

class DevisRepository extends BaseRepository implements DevisRepositoryInterface
{
    public function __construct(Devis $devis)
    {
        parent::__construct($devis);
    }

    public function findByStatus($status)
    {
        return $this->model->where('status', $status)->get();
    }

    public function findByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function findByTechnicianId($technicianId)
    {
        return $this->model->where('technician_id', $technicianId)->get();
    }

    public function assignTechnician($devisId, $technicianId)
    {
        $devis = $this->find($devisId);
        $devis->technician_id = $technicianId;
        $devis->status = 'en_attente_confirmation_technicien';
        $devis->save();
        
        // Ajouter le technicien à la table pivot
        $devis->technicians()->attach($technicianId);
        
        return $devis;
    }

    public function submitResponse($devisId, $technicianId, $data)
    {
        $response = DevisResponse::create([
            'devis_id' => $devisId,
            'technician_id' => $technicianId,
            'commentaire' => $data['commentaire'] ?? null,
            'prix_total' => $data['prix_total'] ?? 0,
            'statut' => 'repondu'
        ]);

        // Attacher les composants à la réponse
        if (isset($data['composants']) && is_array($data['composants'])) {
            foreach ($data['composants'] as $composantData) {
                $response->composants()->attach($composantData['composant_id'], [
                    'quantity' => $composantData['quantity']
                ]);
            }
        }

        // Mettre à jour le statut du devis
        $devis = $this->find($devisId);
        $devis->status = 'repondu_par_technicien';
        $devis->save();

        return $response;
    }

    public function acceptResponse($devisId, $responseId)
    {
        $response = DevisResponse::findOrFail($responseId);
        
        // Mettre à jour le statut de la réponse
        $response->update(['statut' => 'accepte']);
        
        // Mettre à jour le statut du devis
        $devis = $this->find($devisId);
        $devis->status = 'accepte_par_client';
        $devis->save();
        
        // Créer le projet associé
        $project = Project::create([
            'devis_id' => $devisId,
            'technician_id' => $response->technician_id,
            'status' => 'd_accord'
        ]);

        return $project;
    }
}