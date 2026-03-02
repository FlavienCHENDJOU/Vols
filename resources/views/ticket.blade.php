<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement - AeroFlight #{{ $reservation->id }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #333; 
            margin: 0; 
            padding: 0;
            background-color: #f9f9f9;
        }
        .ticket-container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #eee;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        /* Logo en fond (Watermark) */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            opacity: 0.5;
            width: 500px;
            z-index: 0;
        }
        .header {
            background: #1a237e;
            color: white;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { margin: 0; font-size: 28px; letter-spacing: 2px; }
        .content { padding: 40px; position: relative; z-index: 1; }
        
        .section-title {
            border-bottom: 2px solid #1a237e;
            color: #1a237e;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 5px;
            font-size: 14px;
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        .info-item { width: 50%; margin-bottom: 15px; }
        .info-label { display: block; font-size: 11px; color: #777; text-transform: uppercase; }
        .info-value { font-size: 15px; font-weight: bold; }

        .flight-badge {
            background: #e8eaf6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 5px solid #1a237e;
        }

        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .price-table th { background: #f5f5f5; text-align: left; padding: 10px; font-size: 12px; }
        .price-table td { padding: 15px 10px; border-bottom: 1px solid #eee; }
        .total-row { font-size: 20px; color: #1a237e; font-weight: bold; }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 11px;
            color: #999;
            border-top: 1px dashed #ddd;
        }
        .status-stamp {
            position: absolute;
            right: 40px;
            top: 150px;
            border: 3px solid #4CAF50;
            color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            transform: rotate(15deg);
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="ticket-container">
    <img src="{{ public_path('img/vol.png') }}" class="watermark">

    <div class="header">
        <div>
            <h1>AEROFLIGHT</h1>
            <small>Confirmation de Réservation de Vol</small>
        </div>
        <div style="text-align: right">
            <div style="font-size: 12px">Reçu N° :{{ $reservation->id }}-{{ date('Y') }}</div>
            <div style="font-size: 12px">Date : {{ date('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="content">
        <div class="status-stamp">PAYÉ</div>

        <div class="section-title">Informations du Compte Client</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Réservé par :{{ auth()->user()->nom }} {{ auth()->user()->prenom }} </span>
                <span class="info-value">{{ auth()->user()->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Statut du Compte :</span>
                <span class="info-value" style="color: #4caf50">Membre Vérifié</span>
            </div>
        </div>

        <div class="section-title">Détails du Passager principal</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nom complet :</span>
                <span class="info-value">{{ strtoupper($reservation->nom) }} {{ $reservation->prenom }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contact :</span>
                <span class="info-value">{{ $reservation->telephone }}</span>
            </div>
        </div>

        <div class="section-title">Itinéraire & Vol</div>
        <div class="flight-badge">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="font-size: 24px; font-weight: bold;">{{ $reservation->vol->depart }}</div>
                <div style="color: #1a237e; font-size: 20px;">a </div>
                <div style="font-size: 24px; font-weight: bold;">{{ $reservation->vol->destination }}</div>
            </div>
            <div style="margin-top: 10px; font-size: 13px;">
                <strong>Date du vol :</strong> {{ \Carbon\Carbon::parse($reservation->vol->date_depart)->format('d F Y') }} à {{ $reservation->vol->heure_depart }}
            </div>
        </div>

        <div class="section-title">Détails Financiers</div>
        <table class="price-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Classe</th>
                    <th>Qté</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Réservation de vol #{{ $reservation->vol->id }}</td>
                    <td>{{ $reservation->classe }}</td>
                    <td>{{ $reservation->nombre_places }}</td>
                    <td>{{ number_format($reservation->vol->prix, 2) }} $</td>
                    <td>{{ number_format($reservation->vol->prix * $reservation->nombre_places, 2) }} $</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right">TOTAL PAYÉ :</td>
                    <td>{{ number_format($reservation->vol->prix * $reservation->nombre_places, 2) }} $</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 30px;">
            <div class="info-label">Méthode de Paiement utilisée :</div>
            <div class="info-value">
                 {{ $reservation->paiement }} 
            </div>
        </div>
    </div>

    <div class="footer">
        AEROFLIGHT Services - Document officiel généré électroniquement.<br>
        Merci d'avoir choisi notre compagnie pour votre voyage. Bon vol !
    </div>
</div>

<script type="text/javascript">
    window.onload = function() {
        if (!window.isDompdf) {
            window.print();
        }
    }
</script>
</body>
</html>