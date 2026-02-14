<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réservations | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            color: #2d3748;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            font-weight: 600;
            font-size: 1.8rem;
            color: #1a202c;
            margin: 0;
        }

        .card-table {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            padding: 25px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            padding: 15px;
            color: #a0aec0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            border-bottom: 1px solid #edf2f7;
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid #edf2f7;
            font-size: 0.9rem;
        }

        tr:last-child td { border-bottom: none; }

        .user-info { display: flex; align-items: center; }
        .avatar {
            width: 40px;
            height: 40px;
            background: #edf2f7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: #4a5568;
            font-weight: bold;
        }

        .flight-id {
            background: #ebf8ff;
            color: #3182ce;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-places {
            background: #f0fff4;
            color: #38a169;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }


        .btn-action {
            padding: 8px;
            border-radius: 8px;
            color: #e53e3e;
            transition: 0.2s;
            text-decoration: none;
        }
        .btn-action:hover { background: #fff5f5; }

        .contact-info { font-size: 0.8rem; color: #718096; }
        .contact-info i { margin-right: 5px; color: #cbd5e0; }

    </style>
</head>
<body>

    <div class="container">
        <div class="header-flex">
            <h1><i class="fas fa-list-ul text-primary mr-2"></i> Réservations Enregistrées</h1>
            <a href="{{ url('/vols_disponible') }}" class="btn-action" style="color: #4a5568;">
                <i class="fas fa-plus"></i> Nouveau vol
            </a>
        </div>
        <div class="header-section">
            <a href="{{ url('/infoUtilisateur') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> 
                 Retour au profil
            </a>
            <h1>Vols disponibles</h1>
        </div>
        <div class="card-table">
            <table>
                <thead>
                    <tr>
                        <th>Passager</th>
                        <th>Détails Contact</th>
                        <th>Vol</th>
                        <th>Places</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="avatar">{{ substr($reservation->nom, 0, 1) }}</div>
                                <div>
                                    <div style="font-weight: 600;">{{ $reservation->nom }} {{ $reservation->prenom }}</div>
                                    <div class="contact-info">Classe: {{ $reservation->classe ?? 'Eco' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info"><i class="fas fa-envelope"></i> {{ $reservation->email }}</div>
                            <div class="contact-info"><i class="fas fa-phone"></i> {{ $reservation->telephone }}</div>
                        </td>
                        <td>
                            <span class="flight-id">#FL-{{ $reservation->vol_id }}</span>
                        </td>
                        <td>
                            <span class="badge-places">{{ $reservation->nombre_places }} siège(s)</span>
                        </td>
                        <td>
                            <form action="{{ url('/reservation/supprimer/' . $reservation->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette réservation ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" style="border:none; background:none; cursor:pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>