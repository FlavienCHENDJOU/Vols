<!DOCTYPE html>
<html>
<head>
    <title>Liste des réservations</title>
</head>
<body>
    <h1>Liste des réservations enregistrées</h1>
    <ul>
        @foreach ($reservations as $reservation)
            <li>
                {{ $loop->iteration}}  - Réservation de <strong>
                {{ $reservation->nom }} {{ $reservation->prenom}} </strong>pour le vol 
                n°{{ $reservation->vol_id }} - Email : {{ $reservation->email }} , 
                Téléphone : {{ $reservation->telephone }},
                Nombre de places : {{ $reservation->nombre_places }} <hr>
            </li>
        @endforeach
    </ul>
</body>
</html>