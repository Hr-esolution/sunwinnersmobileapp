<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function findByStatus($status)
    {
        return $this->model->where('status', $status)->get();
    }

    public function findByUserId($userId)
    {
        return $this->model->whereHas('devis', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    public function findByTechnicianId($technicianId)
    {
        return $this->model->where('technician_id', $technicianId)->get();
    }

    public function findByDevisId($devisId)
    {
        return $this->model->where('devis_id', $devisId)->get();
    }

    public function createFromDevis($devisId, $technicianId)
    {
        return $this->model->create([
            'devis_id' => $devisId,
            'technician_id' => $technicianId,
            'status' => 'd_accord'
        ]);
    }
}