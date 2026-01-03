<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubventionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubventionController extends Controller
{
    protected $subventionService;

    public function __construct(SubventionService $subventionService)
    {
        $this->subventionService = $subventionService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $projectId = $request->query('project_id');
        
        if ($projectId) {
            $subventions = $this->subventionService->getSubventionByProject($projectId);
        } else {
            $subventions = $status ? $this->subventionService->getSubventionsByStatus($status) : $this->subventionService->subventionRepository->all();
        }
        
        return response()->json($subventions);
    }

    public function show($id)
    {
        $subvention = $this->subventionService->subventionRepository->find($id);
        return response()->json($subvention);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'nom_projet' => 'required|string',
            'type_projet' => 'required|string',
            'nom' => 'required|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'representant' => 'required|string',
            'email' => 'required|email',
            'secteur' => 'required|string',
            'type_entreprise' => 'required|string',
            'taille_entreprise' => 'required|string',
            'description_projet' => 'required|string',
            'adresse_projet' => 'required|string',
            'date_debut' => 'required|date',
            'eligibilite' => 'required|array',
            'signataire_nom' => 'required|string',
            'signataire_fonction' => 'required|string',
            'signataire_signature' => 'required|string',
            'signataire_lieu_date' => 'required|string',
            'statut' => 'required|in:en_attente,confirmee,refusee'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subvention = $this->subventionService->createForProject($request->project_id, $validator->validated());
        return response()->json($subvention, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_projet' => 'sometimes|required|string',
            'type_projet' => 'sometimes|required|string',
            'nom' => 'sometimes|required|string',
            'adresse' => 'sometimes|required|string',
            'telephone' => 'sometimes|required|string',
            'representant' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'secteur' => 'sometimes|required|string',
            'type_entreprise' => 'sometimes|required|string',
            'taille_entreprise' => 'sometimes|required|string',
            'description_projet' => 'sometimes|required|string',
            'adresse_projet' => 'sometimes|required|string',
            'date_debut' => 'sometimes|required|date',
            'eligibilite' => 'sometimes|required|array',
            'signataire_nom' => 'sometimes|required|string',
            'signataire_fonction' => 'sometimes|required|string',
            'signataire_signature' => 'sometimes|required|string',
            'signataire_lieu_date' => 'sometimes|required|string',
            'statut' => 'sometimes|required|in:en_attente,confirmee,refusee'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subvention = $this->subventionService->subventionRepository->update($id, $validator->validated());
        return response()->json($subvention);
    }

    public function destroy($id)
    {
        $this->subventionService->subventionRepository->delete($id);
        return response()->json(['message' => 'Subvention request deleted successfully']);
    }
}