<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rapport des Réservations - AeroFlight</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1a237e; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #1a237e; }
        .report-title { font-size: 18px; margin-top: 10px; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f2f2f2; color: #1a237e; padding: 10px; border: 1px solid #ddd; text-align: left; font-size: 10px; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background-color: #fafafa; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; padding: 10px 0; }
        .summary { margin-top: 20px; text-align: right; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">AEROFLIGHT</div>
        <div class="report-title">Rapport Global des Réservations</div>
        <p>Généré le : {{ date('d/m/Y H:i') }} | Administrateur : {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Réf.</th>
                <th>Client / Passager</th>
                <th>Vol (Itinéraire)</th>
                <th>Date du Vol</th>
                <th>Classe</th>
                <th>Places</th>
                <th>Paiement</th>
                <th>Total (€)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($reservations as $res)
                @php $totalLigne = $res->vol->prix * $res->nombre_places; @endphp
                <tr>
                    <td>#{{ str_pad($res->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ strtoupper($res->nom) }} {{ $res->prenom }}<br><small>{{ $res->email }}</small></td>
                    <td>{{ $res->vol->depart }} → {{ $res->vol->destination }}</td>
                    <td>{{ \Carbon\Carbon::parse($res->vol->date_depart)->format('d/m/Y') }}</td>
                    <td>{{ $res->classe }}</td>
                    <td>{{ $res->nombre_places }}</td>
                    <td>{{ $res->paiement }}</td>
                    <td>{{ number_format($totalLigne, 2) }}</td>
                </tr>
                @php $grandTotal += $totalLigne; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Chiffre d'affaires total : {{ number_format($grandTotal, 2) }} €
    </div>

    <div class="footer">
        AeroFlight Management System - Page <script type="text/php">echo $PAGE_NUM . " / " . $PAGE_COUNT;</script>
    </div>

</body>
</html>