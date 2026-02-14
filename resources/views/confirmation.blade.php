<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation | AeroFlight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .ticket-card {
            background: white;
            color: #1e293b;
            width: 100%;
            max-width: 700px;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        .ticket-header {
            background: #ff5733;
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .ticket-header i { font-size: 3rem; margin-bottom: 10px; }
        .ticket-header h1 { margin: 0; font-size: 1.8rem; }

        .ticket-body { padding: 40px; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .info-item label { color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; display: block; }
        .info-item span { font-weight: 600; font-size: 1.1rem; }

        /* Style de la barre de progression */
        .redirect-section {
            background: #f1f5f9;
            padding: 30px;
            text-align: center;
            border-top: 2px dashed #cbd5e1;
        }

        .progress-container {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 10px;
            margin: 20px 0;
            overflow: hidden;
        }

        #progress-bar {
            width: 100%;
            height: 100%;
            background: #ff5733;
            transition: width 1s linear;
        }

        .btn-cancel {
            background: #64748b;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-cancel:hover { background: #1e293b; }

        .status-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="ticket-card">
        <div class="ticket-header">
            <i class="fas fa-check-circle"></i>
            <h1>Réservation Confirmée !</h1>
            <p>Bon voyage, {{ $reservation->prenom }}</p>
        </div>

        <div class="ticket-body">
            <div class="status-badge">Billet Electronique #{{ $reservation->id }}</div>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Passager</label>
                    <span>{{ $reservation->nom }} {{ $reservation->prenom }}</span>
                </div>
                <div class="info-item">
                    <label>Vol</label>
                    <span>{{ $vol->depart }} <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i> {{ $vol->destination }}</span>
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
            <p id="timer-text">Redirection vers votre profil dans <strong>10</strong> secondes...</p>
            <div class="progress-container">
                <div id="progress-bar"></div>
            </div>
            
           <form id="cancelForm" action="{{ url('/reservation/supprimer/' . $reservation->id) }}" method="POST">
    @csrf
    @method('DELETE') <button type="button" class="btn-cancel" onclick="confirmCancel()">
        <i class="fas fa-times"></i> Annuler la réservation
    </button>
</form>

<script>
    let timeLeft = 10;
    let isCancelled = false;
    const progressBar = document.getElementById('progress-bar');
    const timerText = document.querySelector('#timer-text strong');

    const countdown = setInterval(() => {
        if (!isCancelled) { // Le chrono continue sauf si on a validé la suppression
            timeLeft--;
            if (timeLeft >= 0) {
                timerText.innerText = timeLeft;
                let width = (timeLeft / 10) * 100;
                progressBar.style.width = width + '%';
            }

            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.location.href = "{{ url('/infoUtilisateur') }}";
            }
        }
    }, 1000);

    function confirmCancel() {
        // Affiche la boîte de dialogue Oui/Non
        const choice = confirm("Voulez-vous vraiment annuler votre réservation ? Cette action est irréversible.");
        
        if (choice) {
            isCancelled = true; // Arrête visuellement le chrono
            clearInterval(countdown);
            document.getElementById('cancelForm').submit(); // Envoie le formulaire au contrôleur
        }
        // Si 'Non', le chrono continue simplement sa course là où il en était
    }
</script>
</body>
</html>