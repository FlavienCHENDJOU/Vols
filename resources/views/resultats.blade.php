<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
     <h1>Résultats de la recherche</h1>
    </header>

    <section>
        @if (vols->isEmpty())
            <p>Aucun vol trouvé pour les critères spécifiés.</p>
        @else
            <ul>
                @foreach (vols as vol)
                    <li>
                        <p>vol->destination }} - {{ vol->date </p>
                        <a href=" route('vols.details',vol->id) }}">Voir les détails</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</body>
</html>
