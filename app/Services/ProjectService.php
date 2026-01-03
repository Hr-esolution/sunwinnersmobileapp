<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function createFromDevis($devisId, $technicianId)
    {
        return $this->projectRepository->createFromDevis($devisId, $technicianId);
    }

    public function getProjectsByUser($userId)
    {
        return $this->projectRepository->findByUserId($userId);
    }

    public function getProjectsByTechnician($technicianId)
    {
        return $this->projectRepository->findByTechnicianId($technicianId);
    }

    public function getProjectsByStatus($status)
    {
        return $this->projectRepository->findByStatus($status);
    }

    public function getProjectByDevis($devisId)
    {
        return $this->projectRepository->findByDevisId($devisId);
    }

    public function updateProjectStatus($id, $status)
    {
        return $this->projectRepository->update($id, ['status' => $status]);
    }
}