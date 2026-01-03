<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ComponentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComponentController extends Controller
{
    protected $componentService;

    public function __construct(ComponentService $componentService)
    {
        $this->componentService = $componentService;
    }

    public function index(Request $request)
    {
        $technicianId = $request->query('technician_id');
        $search = $request->query('search');
        
        if ($request->user()->role === 'technician') {
            $components = $this->componentService->getComponentsByTechnician($request->user()->technician->id);
        } elseif ($technicianId) {
            $components = $this->componentService->getComponentsByTechnician($technicianId);
        } else {
            $components = $search 
                ? $this->componentService->searchComponents($search)
                : $this->componentService->componentRepository->all();
        }
        
        return response()->json($components);
    }

    public function show($id)
    {
        $component = $this->componentService->componentRepository->find($id);
        return response()->json($component);
    }

    public function store(Request $request)
    {
        // Only technicians can create components
        if ($request->user()->role !== 'technician') {
            return response()->json(['message' => 'Only technicians can create components'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:composants',
            'unit_price' => 'required|numeric|min:0',
            'manufacturer' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|integer|min:0',
            'certifications' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['technician_id'] = $request->user()->technician->id;

        $component = $this->componentService->createComponent($data);
        return response()->json($component, 201);
    }

    public function update(Request $request, $id)
    {
        $component = $this->componentService->componentRepository->find($id);
        
        // Only the technician who owns the component can update it
        if ($request->user()->role !== 'technician' || 
            $component->technician_id !== $request->user()->technician->id) {
            return response()->json(['message' => 'Unauthorized to update this component'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'reference' => 'sometimes|required|string|max:255|unique:composants,reference,' . $id,
            'unit_price' => 'sometimes|required|numeric|min:0',
            'manufacturer' => 'sometimes|nullable|string|max:255',
            'warranty_period' => 'sometimes|nullable|integer|min:0',
            'certifications' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $component = $this->componentService->componentRepository->update($id, $validator->validated());
        return response()->json($component);
    }

    public function destroy($id)
    {
        $component = $this->componentService->componentRepository->find($id);
        
        // Only the technician who owns the component can delete it
        if ($request->user()->role !== 'technician' || 
            $component->technician_id !== $request->user()->technician->id) {
            return response()->json(['message' => 'Unauthorized to delete this component'], 403);
        }

        $this->componentService->componentRepository->delete($id);
        return response()->json(['message' => 'Component deleted successfully']);
    }

    public function getByTechnician(Request $request)
    {
        $components = $this->componentService->getComponentsByTechnician($request->user()->technician->id);
        return response()->json($components);
    }
}