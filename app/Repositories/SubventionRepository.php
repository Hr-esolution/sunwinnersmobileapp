<?php

namespace App\Repositories;

use App\Interfaces\SubventionRepositoryInterface;
use App\Models\SubventionRequest;

class SubventionRepository extends BaseRepository implements SubventionRepositoryInterface
{
    public function __construct(SubventionRequest $subvention)
    {
        parent::__construct($subvention);
    }

    public function findByStatus($status)
    {
        return $this->model->where('statut', $status)->get();
    }

    public function findByProjectId($projectId)
    {
        return $this->model->where('project_id', $projectId)->get();
    }

    public function createForProject($projectId, $data)
    {
        $data['project_id'] = $projectId;
        return $this->model->create($data);
    }
}