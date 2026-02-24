@extends('layouts/app')

@section('title', 'Confirmation de Réservation | AeroFlight')

@section('content')

<div class="confirmation-wrapper">
    <div class="ticket-card animate__animated animate__zoomIn">
        <div class="ticket-header">
            <i class="fas fa-check-circle"></i>
            <h1>Réservation Confirmée !</h1>
            <p class="mb-0">Bon voyage, {{ $reservation->prenom }}</p>
        </div>

        <div class="ticket-body">
            <div class="status-badge">Billet Électronique #{{ $reservation->id }}</div>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Passager</label>
                    <span>{{ $reservation->nom }} {{ $reservation->prenom }}</span>
                </div>
                <div class="info-item">
                    <label>Vol</label>
                    <span>{{ $vol->depart }} <i class="fas fa-arrow-right mx-1" style="font-size: 0.7rem;"></i> {{ $vol->destination }}</span>
                </div>
                <div class="info-item">
                    <label>Date & Heure</label>
                    <span>{{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y') }} à {{ $vol->heure_depart }}</span>
                </div>
                <div class="info-item">
                    <label>Classe & Places</label>
                    <span>{{ $reservation->classe }} ({{ $reservation->nombre_places }} siège(s))</span>
                </div>
                <div class="info-item">
                    <label>Paiement</label>
                    <span>Via {{ $reservation->paiement }}</span>
                </div>
                <div class="info-item">
                    <label>Contact</label>
                    <span>{{ $reservation->email }}</span>
                </div>
            </div>
        </div>

        <div class="redirect-section">
            <p id="timer-text" class="text-muted">Redirection vers votre profil dans <strong>10</strong> secondes...</p>
            <div class="progress-container">
                <div id="progress-bar"></div>
            </div>
            
            <form id="cancelForm" action="{{ url('/reservation/supprimer/' . $reservation->id) }}" method="POST">
                @csrf
                @method('DELETE') 
                <button type="button" class="btn btn-cancel" onclick="confirmCancel()">
                    <i class="fas fa-times me-2"></i> Annuler la réservation
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let timeLeft = 10;
    let isCancelled = false;
    const progressBar = document.getElementById('progress-bar');
    const timerText = document.querySelector('#timer-text strong');
    const redirectUrl = "{{ Auth::user()->hasAnyRole(['admin_vols', 'admin_users', 'super_admin']) ? url('/admin') : url('/infoUtilisateur') }}";

    const countdown = setInterval(() => {
        if (!isCancelled) {
            timeLeft--;
            if (timeLeft >= 0) {
                if(timerText) timerText.innerText = timeLeft;
                let width = (timeLeft / 10) * 100;
                progressBar.style.width = width + '%';
            }

            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.location.href = redirectUrl; 
            }
        }
    }, 1000);

    function confirmCancel() {
        const choice = confirm("Voulez-vous vraiment annuler votre réservation ?");
        if (choice) {
            isCancelled = true;
            clearInterval(countdown);
            document.getElementById('cancelForm').submit();
        }
    }
</script>
@endpush