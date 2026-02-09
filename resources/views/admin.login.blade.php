<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
</head>
<body>
    <h1>Connexion Administrateur</h1>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Connexion</button>
    </form>
    @if ($errors->any())
        <div>{{ $errors->first() }}</div>
    @endif
</body>
</html>