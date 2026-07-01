@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 800px;">
<div class="mb-3">
    <a href="{{ route('envois.index') }}" class="btn btn-sm btn-outline-secondary">
        &larr; Retour à la liste
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow border-0">
...
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0">📦 Enregistrer un nouvel envoi de colis</h5>
        </div>
        <div class="card-body p-4">
            
            <form method="POST" action="{{ route('envois.store') }}" id="createEnvoiForm" novalidate>
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">ID Voiture</label>
                        <select name="idvoit" class="form-select" required>
                            <option value="" selected disabled>-- Choisir une voiture disponible --</option>
                            @foreach($voitures as $voiture)
                                <option value="{{ $voiture->idvoit }}">{{ $voiture->idvoit }} ({{ $voiture->design }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Description du Colis</label>
                        <input type="text" name="colis" class="form-control" placeholder="Ex: Habits, pièces..." required>
                    </div>

                    <div class="col-12"><hr class="text-muted my-2"></div>
                    <h6 class="text-primary fw-bold mb-0">👨‍💼 Expéditeur (Envoyeur)</h6>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Noms de l'envoyeur</label>
                        <input type="text" name="nomEnvoyeur" class="form-control" placeholder="Ex: Jean Dupont" required>
                    </div>
                   <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Email de l'envoyeur</label>
                    <input type="email" name="emailEnvoyeur" id="emailEnvoyeur" class="form-control" placeholder="Ex: jean.dupont@mail.com" required>
                    <span id="emailError" class="text-danger small fw-bold d-block mt-1"></span>
                   </div>

                    <div class="col-12"><hr class="text-muted my-2"></div>
                    <h6 class="text-success fw-bold mb-0">👤 Destinataire (Récepteur)</h6>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Noms du récepteur</label>
                        <input type="text" name="nomRecepteur" class="form-control" placeholder="Ex: Rasoanirina Marie" required>
                    </div>
                  <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Contact du récepteur</label>
                        <input type="text" name="contactRecepteur" id="contactRecepteur" class="form-control" placeholder="Ex: 0341234567" required>
                        <span id="contactError" class="text-danger small fw-bold d-block mt-1"></span>
                  </div>
                    <div class="col-12"><hr class="text-muted my-2"></div>
                    <h6 class="text-warning fw-bold mb-0">📅 Paramètres financiers & Date</h6>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Date d'envoi</label>
                        <input type="date" name="date_envoi" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Frais d'envoi (Ar)</label>
                            <input type="number" name="frais" id="frais" class="form-control" placeholder="Ex: 30000" required>
                            <span id="fraisError" class="text-danger small fw-bold d-block mt-1"></span>
                    </div>

                    <div class="col-12 d-flex justify-content-end mt-4">
                        <a href="{{ route('envois.index') }}" class="btn btn-light border me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                    </div>

                </div>
            </form>

           <script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById("createEnvoiForm");
    if (!form) return;

    // Récupération des éléments
    var emailInput = document.getElementById('emailEnvoyeur');
    var emailError = document.getElementById('emailError');
    
    var fraisInput = document.getElementById('frais');
    var fraisError = document.getElementById('fraisError');

    var contactInput = document.getElementById('contactRecepteur');
    var contactError = document.getElementById('contactError');

    // 1. Validation dynamique de l'Email
    if (emailInput && emailError) {
        emailInput.addEventListener('input', function () {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value === '') {
                emailError.textContent = '';
                this.classList.remove('is-invalid');
            } else if (!emailRegex.test(this.value)) {
                emailError.textContent = '❌ Veuillez saisir une adresse email valide (ex: exemple@gmail.com).';
                this.classList.add('is-invalid');
            } else {
                emailError.textContent = '';
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }

    // 2. 🚫 Blocage de la lettre 'e', 'E' et des signes dans le champ Frais
    if (fraisInput && fraisError) {
        fraisInput.addEventListener('keydown', function (e) {
            if (['e', 'E', '+', '-', ',', '.'].includes(e.key)) {
                e.preventDefault();
            }
        });

        fraisInput.addEventListener('input', function () {
            if (this.value === '') {
                fraisError.textContent = '';
                this.classList.remove('is-invalid');
            } else if (isNaN(this.value) || parseFloat(this.value) < 0) {
                fraisError.textContent = '❌ Le montant des frais doit être un nombre positif.';
                this.classList.add('is-invalid');
            } else {
                fraisError.textContent = '';
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }

    // 3. 📞 Blocage des lettres dans le champ Contact (uniquement chiffres, espaces et +)
    if (contactInput && contactError) {
        contactInput.addEventListener('input', function () {
            // Supprime instantanément tout caractère qui n'est pas un chiffre, un espace ou un +
            this.value = this.value.replace(/[^0-9+\s]/g, '');

            if (this.value === '') {
                contactError.textContent = '';
                this.classList.remove('is-invalid');
            } else if (this.value.length < 8) {
                contactError.textContent = '❌ Le numéro de contact doit contenir au moins 8 chiffres.';
                this.classList.add('is-invalid');
            } else {
                contactError.textContent = '';
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }
});
</script>

        </div>
    </div>
</div>
@endsection