<?php

namespace App\Interfaces;

interface DevisRepositoryInterface extends RepositoryInterface
{
    public function findByStatus($status);
    public function findByUserId($userId);
    public function findByTechnicianId($technicianId);
    public function assignTechnician($devisId, $technicianId);
    public function submitResponse($devisId, $technicianId, $data);
    public function acceptResponse($devisId, $responseId);
}