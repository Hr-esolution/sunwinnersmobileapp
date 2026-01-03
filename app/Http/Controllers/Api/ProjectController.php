<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $userId = $request->user()->id;
        
        if ($request->user()->role === 'client') {
            $projects = $this->projectService->getProjectsByUser($userId);
        } elseif ($request->user()->role === 'technician') {
            $projects = $this->projectService->getProjectsByTechnician($request->user()->technician->id);
        } else {
            $projects = $status ? $this->projectService->getProjectsByStatus($status) : $this->projectService->projectRepository->all();
        }
        
        return response()->json($projects);
    }

    public function show($id)
    {
        $project = $this->projectService->projectRepository->find($id);
        return response()->json($project);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devis_id' => 'required|exists:devis,id',
            'technician_id' => 'required|exists:technicians,id',
            'status' => 'required|in:d_accord,en_cours,termine',
            'is_active' => 'boolean',
            'contrat_signed_file' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = $this->projectService->projectRepository->create($validator->validated());
        return response()->json($project, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|required|in:d_accord,en_cours,termine',
            'is_active' => 'sometimes|boolean',
            'contrat_signed_file' => 'sometimes|nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = $this->projectService->projectRepository->update($id, $validator->validated());
        return response()->json($project);
    }

    public function destroy($id)
    {
        $this->projectService->projectRepository->delete($id);
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:d_accord,en_cours,termine'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = $this->projectService->updateProjectStatus($id, $request->status);
        return response()->json($project);
    }
}