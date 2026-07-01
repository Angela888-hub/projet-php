<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recevoir;
use App\Notifications\ColisRecuNotification; 
use Illuminate\Support\Facades\Notification; 
use App\Mail\ColisRecuMail;

class RecevoirController extends Controller
{
    public function index()
    {
        $recus = Recevoir::all();
        return view('recevoirs.index', compact('recus'));
    }

    public function create()
    {
       
        $envois = \App\Models\Envoyer::all(); 
        return view('recevoirs.create', compact('envois'));
    }
  
public function store(Request $request)
{
    
    $request->validate([
        'idenvoi' => 'required|integer',
        'date_recept' => 'required|date'
    ]);

    
    $recu = Recevoir::create([
        'idenvoi' => $request->idenvoi,
        'date_recept' => $request->date_recept,
    ]);

    try {

        $envoi = \App\Models\Envoyer::find($request->idenvoi); 

        if ($envoi && !empty($envoi->emailEnvoyeur)) {
            \Illuminate\Support\Facades\Mail::to($envoi->emailEnvoyeur)->send(new ColisRecuMail($envoi));
        }
    } catch (\Exception $e) {

    }

    return redirect()->route('recevoirs.index')
                     ->with('success', 'Réception enregistrée avec succès !');
}
    public function edit($id)
    {
        $recu = Recevoir::findOrFail($id);
        return view('recevoirs.edit', compact('recu'));
    }
}