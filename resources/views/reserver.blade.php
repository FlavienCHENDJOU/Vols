<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation de Vol - Premium</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef1f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px border-radius: 5px;
            border: 1px solid #ccc;
        }

        .radio-group, .payment-methods {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .radio-group label, .payment-methods label {
            margin-right: 20px;
        }

        .payment-methods img {
            width: 50px;
            height: auto;
            margin-left: 10px;
            vertical-align: middle;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            margin-top: 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Formulaire de Réservation</h2>
    <form action="{{ route('form.reserver') }}" method="GET">
    <input type="hidden" name="vol_id" value="{{ $vol->id }}">
        @csrf
        <h3 >
          Réservation du vol n°{{ $vol->id}}  de {{$vol->depart }} à {{ $vol->destination}}  le {{$vol->date_depart }} à {{ $vol->heure_depart}} 
        </h3>
        <P> pour finaliser votre reservation nous avons besion que vous remplissez se formulair. <br> <em>chaque champs est obliguatoire</em></p>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
       <input type="email" id="email" name="email" required>

        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required>

        <label for="classe">Classe de vol :</label>
        <div class="radio-group">
            <label><input type="radio" name="classe" value="Économique" required> Économique</label>
            <label><input type="radio" name="classe" value="Business"> Business</label>
            <label><input type="radio" name="classe" value="Première Classe"> Première Classe</label>
        </div>

        <label for="nombre_places">Nombre de places :</label>
        <input type="number" id="nombre_places" name="nombre_places" min="1" required>

        <label for="motif">Motif du voyage :</label>
        <textarea id="motif" name="motif" rows="4" placeholder="Expliquez brièvement pourquoi vous effectuez ce voyage..."></textarea>
        <label>Moyen de paiement :</label>
        <div class="payment-methods">
            <label><input type="radio" name="paiement" value="Orange Money" required> Orange Money
                <img src="{{ asset('img/orange.png') }}" alt="Orange Money">
            </label>
            <label><input type="radio" name="paiement" value="Mobile Money"> MTN Mobile Money
                <img src="{{ asset('img/mobile.png') }}" alt="MTN Mobile Money">
            </label>
            <label><input type="radio" name="paiement" value="Carte Bancaire"> Carte Bancaire
                <img src="{{ asset('img/carte.jpeg') }}" alt="Carte Bancaire">
            </label>
        </div>

        <button type="submit">Valider la réservation</button>
    </form>
</div>

</body>
</html>