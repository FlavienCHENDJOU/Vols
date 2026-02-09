<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
</head>
<body>
    <h1>Tableau de Bord Administrateur</h1>

    <h2>Ajouter un Vol</h2>
    <form method="POST" action="{{ route('admin.storeVol') }}">
        @csrf
        <input type="text" name="vdepart" placeholder="Départ" required>
        <input type="text" name="varrivee" placeholder="Arrivée" required>
        <input type="date" name="date_depart" required>
        <input type="number" name="npalace" placeholder="Nombre de places" required>
        <input type="number" name="prix" placeholder="Prix" required>
        <input type="text" name="statut" placeholder="Statut" required>
        <button type="submit">Ajouter Vol</button>
    </form>

    <h2>Ajouter un Utilisateur</h2>
    <form method="POST" action="{{ route('admin.storeUser') }}">
        @csrf
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="mail" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Ajouter Utilisateur</button>
    </form>

    <h2>Ajouter une Réservation</h2>
    <form method="POST" action="{{ route('admin.storeReservation') }}">
        @csrf
        <input type="number" name="user_id" placeholder="ID Utilisateur" required>
        <input type="number" name="vol_id" placeholder="ID Vol" required>
        <button type="submit">Ajouter Réservation</button>
    </form>

</body>
</html>