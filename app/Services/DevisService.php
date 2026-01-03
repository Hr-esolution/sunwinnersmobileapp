<?php

namespace App\Services;

use App\Repositories\DevisRepository;

class DevisService
{
    protected $devisRepository;

    public function __construct(DevisRepository $devisRepository)
    {
        $this->devisRepository = $devisRepository;
    }

    public function createDevis($data, $userId)
    {
        $data['user_id'] = $userId;
        $data['status'] = 'en_cours_de_traitement';
        
        return $this->devisRepository->create($data);
    }

    public function assignTechnician($devisId, $technicianId)
    {
        return $this->devisRepository->assignTechnician($devisId, $technicianId);
    }

    public function submitResponse($devisId, $technicianId, $data)
    {
        return $this->devisRepository->submitResponse($devisId, $technicianId, $data);
    }

    public function acceptResponse($devisId, $responseId)
    {
        return $this->devisRepository->acceptResponse($devisId, $responseId);
    }

    public function getDevisByUser($userId)
    {
        return $this->devisRepository->findByUserId($userId);
    }

    public function getDevisByStatus($status)
    {
        return $this->devisRepository->findByStatus($status);
    }
}