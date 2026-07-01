@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 800px;">
    <div class="mb-3">
        <a href="{{ route('envois.index') }}" class="btn btn-sm btn-outline-secondary">
            &larr; Annuler et retourner à la liste
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h5 class="mb-0">✏️ Modifier l'envoi #{{ $envoi->idenvoi }}</h5>
        </div>
        <div class="card-body p-4">
            
            <form method="POST" action="{{ route('envois.update', $envoi->idenvoi) }}">
                @csrf
                @method('PUT') <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">ID Voiture</label>
                        <input type="text" name="idvoit" class="form-control" value="{{ $envoi->idvoit }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Description du Colis</label>
                        <input type="text" name="colis" class="form-control" value="{{ $envoi->colis }}" required>
                    </div>

                    <div class="col-12"><hr class="text-muted my-2"></div>
                    <h6 class="text-primary fw-bold mb-0">👨‍💼 Expéditeur (Envoyeur)</h6>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Noms de l'envoyeur</label>
                        <input type="text" name="nomEnvoyeur" class="form-control" value="{{ $envoi->nomEnvoyeur }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Email de l'envoyeur</label>
                        <input type="email" name="emailEnvoyeur" class="form-control" value="{{ $envoi->emailEnvoyeur }}" required>
                    </div>

                    <div class="col-12"><hr class="text-muted my-2"></div>
                    <h6 class="text-success fw-bold mb-0">👤 Destinataire (Récepteur)</h6>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Noms du récepteur</label>
                        <input type="text" name="nomRecepteur" class="form-control" value="{{ $envoi->nomRecepteur }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Contact du récepteur</label>
                        <input type="text" name="contactRecepteur" class="form-control" value="{{ $envoi->contactRecepteur }}" required>
                    </div>

                    <div class="col-12"><hr class="text-muted my-2"></div>
                    <h6 class="text-danger fw-bold mb-0">📅 Paramètres financiers & Date</h6>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Date d'envoi</label>
                        <input type="date" name="date_envoi" class="form-control" value="{{ \Carbon\Carbon::parse($envoi->date_envoi)->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Frais d'envoi (Ar)</label>
                        <input type="number" name="frais" class="form-control" value="{{ $envoi->frais }}" required>
                    </div>

                    <div class="col-12 d-flex justify-content-end mt-4">
                        <a href="{{ route('envois.index') }}" class="btn btn-light border me-2">Abandonner</a>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold text-dark">Enregistrer les modifications</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection