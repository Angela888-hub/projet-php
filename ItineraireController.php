<?php

namespace App\Http\Controllers;

use App\Models\Itineraire; 
use Illuminate\Http\Request;

class ItineraireController extends Controller
{

    public function index()
    {
        
        $itineraires = Itineraire::all();
        return view('itineraires.index', compact('itineraires'));
    }

    public function create()
    {
        return view('itineraires.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codeit' => 'required|unique:itineraire,codeit|max:255',
            'villedep' => 'required|string|max:255',
            'villearr' => 'required|string|max:255',
        ]);

        Itineraire::create($request->all());

        return redirect()->route('itineraires.index')
                         ->with('success', 'Itinéraire créé avec succès !');
    }

    public function edit($id)
    {
        $itineraire = Itineraire::findOrFail($id);

        return view('itineraires.edit', compact('itineraire'));
    }

    public function update(Request $request, $id)
    {
        $itineraire = Itineraire::findOrFail($id);

        $request->validate([
            'villedep' => 'required|string|max:255',
            'villearr' => 'required|string|max:255',
        ]);

        $itineraire->update($request->all());

        return redirect()->route('itineraires.index')
                         ->with('success', 'Itinéraire mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $itineraire = Itineraire::findOrFail($id);
        
        $itineraire->delete();

        return redirect()->route('itineraires.index')
                         ->with('success', 'Itinéraire supprimé avec succès !');
    }
    
}