<?php

namespace App\Interfaces;

interface ComposantRepositoryInterface extends RepositoryInterface
{
    public function findByTechnicianId($technicianId);
    public function findByDevisId($devisId);
}