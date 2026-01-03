<?php

namespace App\Repositories;

use App\Interfaces\ComposantRepositoryInterface;
use App\Models\Composant;

class ComposantRepository extends BaseRepository implements ComposantRepositoryInterface
{
    public function __construct(Composant $composant)
    {
        parent::__construct($composant);
    }

    public function findByTechnicianId($technicianId)
    {
        return $this->model->where('technician_id', $technicianId)->get();
    }

    public function findByDevisId($devisId)
    {
        return $this->model->whereHas('devis', function($query) use ($devisId) {
            $query->where('devis_id', $devisId);
        })->get();
    }
}