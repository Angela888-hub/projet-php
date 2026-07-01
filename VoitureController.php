<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Itineraire; 
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    /**
     * Afficher la liste des voitures.
     */
    public function index()
    {
        $voitures = Voiture::with('itineraire')->get();

        return view('voitures.index', compact('voitures'));
    }

   
    public function create()
    {
       
        $itineraires = Itineraire::all();

        return view('voitures.create', compact('itineraires'));
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'idvoit' => 'required|unique:voiture,idvoit|max:255',
            'design' => 'required|string|max:255',
            'codeit' => 'required|exists:itineraire,codeit',
            'frais' => 'required|numeric|min:0',
        ]);

        
        Voiture::create([
        'idvoit' => $request->idvoit,
        'design' => $request->design,
        'codeit' => $request->codeit,
        'frais'  => $request->frais,
    ]);

        return redirect()->route('voitures.index')
                         ->with('success', 'Voiture enregistrée avec succès !');
    }

    public function edit($id)
    {

        $voiture = Voiture::findOrFail($id);

        
        $itineraires = Itineraire::all();

        
        return view('voitures.edit', compact('voiture', 'itineraires'));
    }

    public function update(Request $request, $id)
    {
        $voiture = Voiture::findOrFail($id);

        
        $request->validate([
            'Design' => 'required|string|max:255',
            'codeit' => 'required|exists:itineraire,codeit',
            'frais' => 'required|numeric|min:0',
        ]);

        
        $voiture->update($request->all());

        return redirect()->route('voitures.index')
                         ->with('success', 'Voiture mise à jour avec succès !');
    }

    public function destroy($id)
    {
        $voiture = Voiture::findOrFail($id);
        $voiture->delete();

        return redirect()->route('voitures.index')
                         ->with('success', 'Voiture supprimée avec succès !');
    }
}