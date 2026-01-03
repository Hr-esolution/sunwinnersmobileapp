<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function findByStatus($status);
    public function findByUserId($userId);
    public function findByTechnicianId($technicianId);
    public function findByDevisId($devisId);
    public function createFromDevis($devisId, $technicianId);
}