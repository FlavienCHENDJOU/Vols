<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Billets | AeroFlight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .ticket {
            background: white;
            border-radius: 15px;
            display: flex;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            border-left: 5px solid #ff5733;
        }
        .ticket-left { padding: 20px; flex: 3; }
        .ticket-right { 
            background: #1e293b; 
            color: white; 
            padding: 20px; 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center;
            border-left: 2px dashed #ccc;
        }
        .route { font-size: 1.2rem; font-weight: bold; color: #1e293b; }
        .details { font-size: 0.9rem; color: #64748b; margin-top: 5px; }
        .btn-view {
            background: #ff5733;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.8rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-plane-departure"></i> Mes Voyages</h1>
        
        @if($reservations->isEmpty())
            <p>Vous n'avez pas encore de réservation.</p>
            <a href="{{ url('/vols_disponible') }}">Voir les vols disponibles</a>
        @else
            @foreach($reservations as $res)
            <div class="ticket">
                <div class="ticket-left">
                    <div class="route">Vol #{{ $res->vol_id }} - {{ $res->classe }}</div>
                    <div class="details">
                        <i class="fas fa-user"></i> {{ $res->nom }} {{ $res->prenom }} <br>
                        <i class="fas fa-chair"></i> {{ $res->nombre_places }} place(s) réservée(s)
                    </div>
                </div>
                <div class="ticket-right">
                    <div style="font-size: 0.7rem; opacity: 0.7;">STATUT</div>
                    <div style="font-weight: bold;">CONFIRMÉ</div>
                    <a href="{{ url('/confirmation/' . $res->id) }}" class="btn-view">Détails</a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</body>
</html>