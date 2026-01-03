<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($data)
    {
        // Hasher le mot de passe
        $data['password'] = bcrypt($data['password']);
        
        // Définir le statut d'approbation selon le rôle
        if ($data['role'] === 'technician') {
            $data['approved'] = false; // Technicien doit être approuvé par l'admin
        } else {
            $data['approved'] = true; // Client est auto-approuvé
        }
        
        return $this->userRepository->create($data);
    }

    public function approveUser($id)
    {
        $user = $this->userRepository->find($id);
        $user->approved = true;
        $user->save();
        return $user;
    }

    public function suspendUser($id)
    {
        $user = $this->userRepository->find($id);
        $user->approved = false;
        $user->save();
        return $user;
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }
}