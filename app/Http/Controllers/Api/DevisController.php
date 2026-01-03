<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DevisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DevisController extends Controller
{
    protected $devisService;

    public function __construct(DevisService $devisService)
    {
        $this->devisService = $devisService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $userId = $request->user()->id;
        
        if ($request->user()->role === 'client') {
            $devis = $this->devisService->getDevisByUser($userId);
        } else {
            $devis = $status ? $this->devisService->getDevisByStatus($status) : $this->devisService->devisRepository->all();
        }
        
        return response()->json($devis);
    }

    public function show($id)
    {
        $devis = $this->devisService->devisRepository->find($id);
        return response()->json($devis);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_demandeur' => 'required|in:personne,societe',
            'type_demande' => 'required|in:nouvelle_installation,extension_mise_a_niveau,entretien_reparation',
            'objectif' => 'required|in:reduction_consommation,stockage_energie,extension_future_prevue',
            'type_installation' => 'required|in:autoconsommation_injection_surplus,autoconsommation_sans_injection,installation_autonome_offgrid,pompage_solaire',
            'type_utilisation' => 'required|in:domestique,industrielle,agricole',
            'adresse_complete' => 'required|string',
            'toit_installation' => 'required|string',
            'images' => 'array',
            'type_pompe' => 'nullable|in:surface,immergee',
            'debit_estime' => 'nullable|numeric',
            'profondeur_forage' => 'nullable|integer',
            'capacite_reservoir' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $devis = $this->devisService->createDevis($validator->validated(), $request->user()->id);
        return response()->json($devis, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type_demandeur' => 'sometimes|required|in:personne,societe',
            'type_demande' => 'sometimes|required|in:nouvelle_installation,extension_mise_a_niveau,entretien_reparation',
            'objectif' => 'sometimes|required|in:reduction_consommation,stockage_energie,extension_future_prevue',
            'type_installation' => 'sometimes|required|in:autoconsommation_injection_surplus,autoconsommation_sans_injection,installation_autonome_offgrid,pompage_solaire',
            'type_utilisation' => 'sometimes|required|in:domestique,industrielle,agricole',
            'adresse_complete' => 'sometimes|required|string',
            'toit_installation' => 'sometimes|required|string',
            'images' => 'sometimes|array',
            'status' => 'sometimes|required|in:en_cours_de_traitement,repondu_par_technicien,accepte_par_client,refusé_par_client,en_attente_confirmation_technicien,termine',
            'type_pompe' => 'sometimes|nullable|in:surface,immergee',
            'debit_estime' => 'sometimes|nullable|numeric',
            'profondeur_forage' => 'sometimes|nullable|integer',
            'capacite_reservoir' => 'sometimes|nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $devis = $this->devisService->devisRepository->update($id, $validator->validated());
        return response()->json($devis);
    }

    public function destroy($id)
    {
        $this->devisService->devisRepository->delete($id);
        return response()->json(['message' => 'Devis deleted successfully']);
    }

    public function assignTechnician(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'technician_id' => 'required|exists:technicians,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $devis = $this->devisService->assignTechnician($id, $request->technician_id);
        return response()->json($devis);
    }

    public function submitResponse(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'commentaire' => 'nullable|string',
            'prix_total' => 'required|numeric',
            'composants' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $response = $this->devisService->submitResponse($id, $request->user()->technician->id, $validator->validated());
        return response()->json($response, 201);
    }

    public function acceptResponse(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'response_id' => 'required|exists:devis_responses,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = $this->devisService->acceptResponse($id, $request->response_id);
        return response()->json(['message' => 'Response accepted successfully', 'project' => $project], 201);
    }
}