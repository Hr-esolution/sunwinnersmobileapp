<?php

namespace App\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail($email);
    public function findByRole($role);
    public function findByStatus($status);
}