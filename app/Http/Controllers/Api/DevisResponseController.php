<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DevisResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DevisResponseController extends Controller
{
    protected $devisResponseService;

    public function __construct(DevisResponseService $devisResponseService)
    {
        $this->devisResponseService = $devisResponseService;
    }

    public function index(Request $request)
    {
        $devisId = $request->query('devis_id');
        $technicianId = $request->query('technician_id');
        
        if ($devisId) {
            $responses = $this->devisResponseService->getResponsesByDevis($devisId);
        } elseif ($technicianId) {
            $responses = $this->devisResponseService->getResponsesByTechnician($technicianId);
        } else {
            $responses = $this->devisResponseService->devisResponseRepository->all();
        }
        
        return response()->json($responses);
    }

    public function show($id)
    {
        $response = $this->devisResponseService->devisResponseRepository->find($id);
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devis_id' => 'required|exists:devis,id',
            'commentaire' => 'nullable|string',
            'prix_total' => 'required|numeric',
            'statut' => 'required|in:pending,accepted,rejected',
            'composants' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $response = $this->devisResponseService->createResponse($validator->validated(), $request->user()->id);
        return response()->json($response, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'commentaire' => 'sometimes|nullable|string',
            'prix_total' => 'sometimes|required|numeric',
            'statut' => 'sometimes|required|in:pending,accepted,rejected',
            'composants' => 'sometimes|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $response = $this->devisResponseService->devisResponseRepository->update($id, $validator->validated());
        return response()->json($response);
    }

    public function destroy($id)
    {
        $this->devisResponseService->devisResponseRepository->delete($id);
        return response()->json(['message' => 'Devis response deleted successfully']);
    }

    public function accept($id)
    {
        $response = $this->devisResponseService->acceptResponse($id);
        return response()->json([
            'message' => 'Response accepted successfully', 
            'response' => $response
        ]);
    }

    public function reject($id)
    {
        $response = $this->devisResponseService->rejectResponse($id);
        return response()->json([
            'message' => 'Response rejected successfully', 
            'response' => $response
        ]);
    }
}