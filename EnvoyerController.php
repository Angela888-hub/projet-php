<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envoyer;
use App\Models\Voiture;
use Illuminate\Support\Facades\Mail; // 
use App\Mail\ColisRecuMail;

class EnvoyerController extends Controller
{

public function index()
    {
        
        $envois = Envoyer::all();

        
        $recetteTotal = Envoyer::sum('frais');

        
        $dateDebut = null;
        $dateFin = null;

        return view('envois.index', compact('envois', 'recetteTotal', 'dateDebut', 'dateFin'));
    }

public function create()
{   $voitures = Voiture::all();
    return view('envois.create',compact('voitures'));
}
public function store(Request $request)
{
    $request->validate([
        'idvoit' => 'required|string|max:20',
        'colis' => 'required|string|max:100',
        'nomEnvoyeur' =>'required|string|max:50',
        'emailEnvoyeur' => 'required|email|max:50',
        'date_envoi' => 'required|date',
        'frais' => 'required|numeric',
        'nomRecepteur' => 'required|string|max:50',
        'contactRecepteur' => 'required|string|max:20',
    ]);

    
    $envoi = Envoyer::create($request->all());

    
    try {
        Mail::to($envoi->emailEnvoyeur)->send(new ColisRecuMail($envoi));
    } catch (\Exception $e) {
         
        dd($e->getMessage()); 
}

    return redirect()->route('envois.index')
                     ->with('success', 'Envoi créé avec succès !');
}
public function edit($id)
{
    $envoi = Envoyer::findOrFail($id);
    return view('envois.edit', compact('envoi'));
}
public function update(Request $request, $id)
{
    $envoi = Envoyer::findOrFail($id);
    
    $request->validate([
        'idvoit' => 'required|string|max:20',
        'colis' => 'required|string|max:100',
        'nomEnvoyeur' => 'required|string|max:40',
        'emailEnvoyeur' => 'required|email|max:20',
        'date_envoi' => 'required|date',
        'frais' => 'required|numeric',
        'nomRecepteur' => 'required|string|max:40',
        'contactRecepteur' => 'required|string|max:20',
    ]);
    
    $envoi->update($request->all());
    
    return redirect()->route('envois.index')
                     ->with('success', 'Envoi mis à jour avec succès !');
}
public function destroy($id)
{
    $envoi = Envoyer::findOrFail($id);
    $envoi->delete();
    return redirect()->route('envois.index')
                     ->with('success', 'Envoi supprimé avec succès !');
}

public function rechercher(Request $request)
{
    $dateDebut = $request->input('date_debut');
    $dateFin = $request->input('date_fin');

    if (!$dateDebut || !$dateFin) {
        return redirect()->route('envois.index')->with('error', 'Veuillez saisir la date de début et la date de fin.');
    }

    $envois = Envoyer::whereBetween('date_envoi', [$dateDebut, $dateFin])->get();

    $recetteTotal = $envois->sum('frais');

    return view('envois.index', compact('envois', 'recetteTotal', 'dateDebut', 'dateFin'));
} 

}