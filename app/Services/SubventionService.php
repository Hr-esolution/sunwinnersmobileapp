<?php

namespace App\Services;

use App\Repositories\SubventionRepository;

class SubventionService
{
    protected $subventionRepository;

    public function __construct(SubventionRepository $subventionRepository)
    {
        $this->subventionRepository = $subventionRepository;
    }

    public function createForProject($projectId, $data)
    {
        return $this->subventionRepository->createForProject($projectId, $data);
    }

    public function getSubventionsByStatus($status)
    {
        return $this->subventionRepository->findByStatus($status);
    }

    public function getSubventionByProject($projectId)
    {
        return $this->subventionRepository->findByProjectId($projectId);
    }
}