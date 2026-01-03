<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $role = $request->query('role');
        $status = $request->query('status');
        
        $users = $this->userService->userRepository->all();
        
        if ($role) {
            $users = $this->userService->userRepository->findByRole($role);
        }
        
        if ($status !== null) {
            $users = $this->userService->userRepository->findByStatus($status === 'approved');
        }
        
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userService->userRepository->find($id);
        return response()->json($user);
    }

    public function approve($id)
    {
        $user = $this->userService->approveUser($id);
        return response()->json(['message' => 'User approved successfully', 'user' => $user]);
    }

    public function suspend($id)
    {
        $user = $this->userService->suspendUser($id);
        return response()->json(['message' => 'User suspended successfully', 'user' => $user]);
    }
}