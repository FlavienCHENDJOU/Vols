

 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #34495e;
            padding: 20px 0;
            text-align: center;
        }

        header .logo {
            width: 100px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 2.5em;
            margin: 0;
        }

        .reservation-details {
            background-color: #34495e;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        footer {
            background-color: #34495e;
            text-align: center;
            padding: 20px 0;
        }

        footer .btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
        }
        footer .btn:hover {
            background-color: #c0392b;
        }

    </style>
</head>
<<body>
    <header>
        <div class="container">
            <img src="{{ asset('image/volimage.jpeg') }}" alt="Logo de l'entreprise" class="logo">
            <h1>Félicitations, {{ $reservation->prenom }} ! <br> Votre réservation a ete effectue avec succes</h1>
        </div>
    </header>

    <section class="reservation-details">
        <div class="container">
            <p>Réservation de {{ $reservation->nombre_places }} place(s) en classe {{ $reservation->classe }}  par {{ $reservation->nom }} {{ $reservation->prenom }} payer via {{ $reservation->paiement }}.</p>
            <p>Pour le vol numero {{ $reservation->vol_id }}, de {{ $vol->depart }} à {{ $vol->destination }}, de {{ $vol->pays_depart }} à {{ $vol->pays_arrivee }}.</p>
            <p>Départ prévu le {{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y') }} à {{ $vol->heure_depart }}.</p>
            <p>Nous contacterons en cas de changement via votre email : {{ $reservation->email }} ou votre  via numéro : {{ $reservation->telephone }}.</p>
            <p>Nous vous remercions pour cette reservation</p>
            <h2> bon voyage</h2>
        </div>
    </section>

    <footer>
        <div class="container">
            <a href="/infoUtilisateur" class="btn">Retour à l'accueil</a>
        </div>
    </footer>
</body>
</html>


