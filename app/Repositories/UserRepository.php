<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByRole($role)
    {
        return $this->model->where('role', $role)->get();
    }

    public function findByStatus($status)
    {
        return $this->model->where('approved', $status)->get();
    }
}