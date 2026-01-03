<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TechnicianService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    protected $technicianService;

    public function __construct(TechnicianService $technicianService)
    {
        $this->technicianService = $technicianService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $technicians = $search 
            ? $this->technicianService->searchTechnicians($search)
            : $this->technicianService->technicianRepository->all();
        
        return response()->json($technicians);
    }

    public function show($id)
    {
        $technician = $this->technicianService->technicianRepository->find($id);
        return response()->json($technician);
    }

    public function store(Request $request)
    {
        // Only authenticated users can create technician profiles
        if (!$request->user()) {
            return response()->json(['message' => 'Authentication required'], 401);
        }

        $validator = Validator::make($request->all(), [
            'certificates' => 'nullable|string',
            'experience' => 'nullable|string',
            'logo' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = $request->user()->id;

        $technician = $this->technicianService->createTechnician($data);
        return response()->json($technician, 201);
    }

    public function update(Request $request, $id)
    {
        $technician = $this->technicianService->technicianRepository->find($id);
        
        // Only the user who owns the technician profile can update it
        if ($request->user()->id !== $technician->user_id) {
            return response()->json(['message' => 'Unauthorized to update this technician profile'], 403);
        }

        $validator = Validator::make($request->all(), [
            'certificates' => 'sometimes|nullable|string',
            'experience' => 'sometimes|nullable|string',
            'logo' => 'sometimes|nullable|string',
            'company_name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $technician = $this->technicianService->technicianRepository->update($id, $validator->validated());
        return response()->json($technician);
    }

    public function destroy($id)
    {
        $technician = $this->technicianService->technicianRepository->find($id);
        
        // Only the user who owns the technician profile can delete it
        if ($request->user()->id !== $technician->user_id) {
            return response()->json(['message' => 'Unauthorized to delete this technician profile'], 403);
        }

        $this->technicianService->technicianRepository->delete($id);
        return response()->json(['message' => 'Technician profile deleted successfully']);
    }

    public function getMyProfile(Request $request)
    {
        $technician = $this->technicianService->getTechnicianByUser($request->user()->id);
        return response()->json($technician);
    }

    public function updateProfile(Request $request)
    {
        $technician = $this->technicianService->getTechnicianByUser($request->user()->id);
        
        $validator = Validator::make($request->all(), [
            'certificates' => 'sometimes|nullable|string',
            'experience' => 'sometimes|nullable|string',
            'logo' => 'sometimes|nullable|string',
            'company_name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $technician = $this->technicianService->technicianRepository->update($technician->id, $validator->validated());
        return response()->json($technician);
    }

    public function getAssignedDevis(Request $request)
    {
        $technician = $this->technicianService->getTechnicianByUser($request->user()->id);
        $devis = $this->technicianService->getAssignedDevis($technician->id);
        return response()->json($devis);
    }

    public function getMyResponses(Request $request)
    {
        $technician = $this->technicianService->getTechnicianByUser($request->user()->id);
        $responses = $this->technicianService->getTechnicianResponses($technician->id);
        return response()->json($responses);
    }
}