<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devis;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Devis::all();
        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        return view('quotes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_demandeur' => 'required|string|max:255',
            'type_demande' => 'required|string|max:255',
            'adresse_complete' => 'required|string',
        ]);

        Devis::create([
            'type_demandeur' => $request->type_demandeur,
            'type_demande' => $request->type_demande,
            'adresse_complete' => $request->adresse_complete,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('quotes.index')->with('success', 'Devis créé avec succès.');
    }

    public function show($id)
    {
        $quote = Devis::findOrFail($id);
        return view('quotes.show', compact('quote'));
    }

    public function edit($id)
    {
        $quote = Devis::findOrFail($id);
        return view('quotes.edit', compact('quote'));
    }

    public function update(Request $request, $id)
    {
        $quote = Devis::findOrFail($id);
        
        $request->validate([
            'type_demandeur' => 'required|string|max:255',
            'type_demande' => 'required|string|max:255',
            'adresse_complete' => 'required|string',
        ]);

        $quote->update([
            'type_demandeur' => $request->type_demandeur,
            'type_demande' => $request->type_demande,
            'adresse_complete' => $request->adresse_complete,
        ]);

        return redirect()->route('quotes.index')->with('success', 'Devis mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $quote = Devis::findOrFail($id);
        $quote->delete();
        
        return redirect()->route('quotes.index')->with('success', 'Devis supprimé avec succès.');
    }

    public function generatePdf($id)
    {
        $quote = Devis::findOrFail($id);
        
        // Logique pour générer un PDF - ici on retourne juste une vue pour démonstration
        return view('quotes.pdf', compact('quote'));
    }
}