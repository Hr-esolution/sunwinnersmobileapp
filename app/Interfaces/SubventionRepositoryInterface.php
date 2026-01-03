<?php

namespace App\Interfaces;

interface SubventionRepositoryInterface extends RepositoryInterface
{
    public function findByStatus($status);
    public function findByProjectId($projectId);
    public function createForProject($projectId, $data);
}