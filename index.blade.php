@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-secondary">📦 Liste des Envois</h2>
        <div>
            <span class="badge bg-success p-2 fs-6 me-2 shadow-sm">
                Recette totale : {{ number_format($recetteTotal, 0, ',', ' ') }} Ar
            </span>
            <a href="{{ route('envois.create') }}" class="btn btn-primary shadow-sm">
                + Nouvel envoi
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            ⚠️ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4 shadow-sm border-0 bg-light rounded">
        <div class="card-body">
            <h5 class="card-title text-secondary mb-3">🔍 Rechercher des colis par période</h5>
            
            <form action="{{ route('envois.recherche') }}" method="GET" id="searchForm" class="row g-3 align-items-end">
               <div class="col-md-4">
    <label class="form-label fw-bold small text-muted">Date de début</label>
    <input type="date" 
           name="date_debut" 
           id="date_debut"
           class="form-control" 
           value="{{ $dateDebut ?? '' }}" 
           required>
</div>
                
<div class="col-md-4">
    <label class="form-label fw-bold small text-muted">Date de fin</label>
    <input type="date" 
           name="date_fin" 
           id="date_fin"
           class="form-control" 
           value="{{ $dateFin ?? '' }}" 
           required>
</div>
                
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 flex-grow-1">Recherche des colis</button>
                        @if(isset($dateDebut) && $dateDebut)
                            <a href="{{ route('envois.index') }}" class="btn btn-outline-danger">❌ Annuler</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <p class="text-muted fw-semibold">📊 {{ count($envois) }} envois enregistrés</p>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Envoi</th>
                            <th>Code Voiture</th>
                            <th>Description Colis</th>
                            <th>Expéditeur (Envoyeur)</th>
                            <th>Destinataire (Récepteur)</th>
                            <th>Date d'envoi</th>
                            <th>Frais</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($envois as $envoi)
                            <tr>
                                <td class="fw-bold text-primary"><strong>E00{{ ( $envoi->idenvoi) }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary px-2 py-1">{{ $envoi->idvoit }}</span>
                                </td>
                                <td>{{ $envoi->colis }}</td>
                                <td>
                                    <div class="fw-bold">{{ $envoi->nomEnvoyeur }}</div>
                                    <small class="text-muted">{{ $envoi->emailEnvoyeur }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $envoi->nomRecepteur }}</div>
                                    <small class="text-muted">{{ $envoi->contactRecepteur }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($envoi->date_envoi)->format('d/m/Y') }}</td>
                                <td class="fw-bold text-success">{{ number_format($envoi->frais, 0, ',', ' ') }} Ar</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('envois.edit', $envoi->idenvoi) }}" class="btn btn-outline-warning">Modifier</a>
                                        <form action="{{ route('envois.destroy', $envoi->idenvoi) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet envoi ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-danger fw-bold bg-white">
                                    ⚠️ Aucun résultat trouvé pour cette période.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function(){
        // Configuration stricte d'Inputmask au format datetime français
        $('.date-mask').inputmask({
            alias: "datetime",
            inputFormat: "dd/mm/yyyy",
            placeholder: "JJ/MM/AAAA",
            insertMode: false,
            clearIncomplete: true
        });

        // Interception avant envoi si l'utilisateur clique sans écrire de date
        $('#searchForm').on('submit', function(e){
            var debut = $('#date_debut').val();
            var fin = $('#date_fin').val();

            // Si un champ est vide, contient toujours des underscores (_) ou le placeholder par défaut
            if(!debut || !fin || debut.includes('_') || fin.includes('_') || debut === "JJ/MM/AAAA" || fin === "JJ/MM/AAAA") {
                e.preventDefault(); // Annule la soumission du formulaire
                alert('Veuillez saisir la date de début et la date de fin avant de lancer la recherche.');
            }
        });
    });
</script>
@endsection