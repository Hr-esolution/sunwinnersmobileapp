<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subsidy;

class SubsidyController extends Controller
{
    public function index()
    {
        $subsidies = Subsidy::all();
        return view('subsidies.index', compact('subsidies'));
    }

    public function create()
    {
        return view('subsidies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'provider' => 'required|string|max:255',
        ]);

        Subsidy::create([
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'provider' => $request->provider,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('subsidies.index')->with('success', 'Subvention créée avec succès.');
    }

    public function show($id)
    {
        $subsidy = Subsidy::findOrFail($id);
        return view('subsidies.show', compact('subsidy'));
    }

    public function edit($id)
    {
        $subsidy = Subsidy::findOrFail($id);
        return view('subsidies.edit', compact('subsidy'));
    }

    public function update(Request $request, $id)
    {
        $subsidy = Subsidy::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'provider' => 'required|string|max:255',
        ]);

        $subsidy->update([
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'provider' => $request->provider,
        ]);

        return redirect()->route('subsidies.index')->with('success', 'Subvention mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $subsidy = Subsidy::findOrFail($id);
        $subsidy->delete();
        
        return redirect()->route('subsidies.index')->with('success', 'Subvention supprimée avec succès.');
    }
}