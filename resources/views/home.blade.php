<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil - Réservations</title>
    <link type="text/css" rel="stylesheet" href="{{asset('css/homestyle.css')}}" />
    
</head>
<body>
    
    <div class="container">
        <h1>🚨 ☄️🛫  <br> Compagnie aérienne de réservation <br> ✈️ ☄️🚨</h1>
        <h4>Vous avez la possibilité d'effectuer des réservations partout dans le monde en un seul clic. <br> Votre confort et votre sécurité sont notre priorité.</h4>
        <h2>Qui n'a jamais rêvé de faire des réservations sans se déplacer ?</h2>
        
        <div class="image-section">
            <img src="img/satif.jpg" alt="Satisfaction">
        </div>
        
        <h2>De parcourir tous les continants , meme les coins les plus caches ?</h2>
        <div class="image-container">
            <div class="image-section" id="image1">
                <img src="img/amerique.jpeg" alt="Réservation pour l'Amérique">
                <div class="moving-text">Réservation pour l'Amérique</div>
            </div>

            <div class="image-section" id="image2">
                <img src="img/afrique.jpeg" alt="Réservation pour l'Afrique">
                <div class="moving-text">Réservation pour l'Afrique</div>
            </div>

            <div class="image-section" id="image3">
                <img src="img/europe.jpg" alt="Réservation pour l'Europe">
                <div class="moving-text">Réservation pour l'Europe</div>
            </div>
        </div>

        <h2>Plus de stress pour la localisation d'un hotel après réservation</h2>
        <p>Nous offrons aussi la possibilité de localiser un autel à votre convenance dans cette ville.</p>
        
        <div class="image-section">
            <img src="img/image3.jpeg" alt="Réservation d'hôtel">
            <div class="moving-text">Réservation d'hôtel</div>
        </div>

        <h2>Un séjour trop ennuyeux ? Pas grave !</h2>
        <p>Nous offrons la possibilité de localiser des sites touristiques de votre choix, avec des lieux de détente.</p>
        <div class="image-container">
            <div class="image-section">
                <img src="img/touriste1.jpeg" alt="Site touristique">
                <div class="moving-text">Site touristique</div>
            </div>
            <div class="image-section">
                <img src="img/touriste2.jpeg" alt="Site touristique">
                <div class="moving-text">Site touristique</div>
            </div>
            <div class="image-section">
                <img src="img/touriste3.jpg" alt="Site touristique">
                <div class="moving-text">Site touristique</div>
            </div>
        </div>

        <a href="{{ url('accueil')}}" class="button">Commencer l'Essai</a>
        <a href="{{ url('connexion') }}" class="button">Connectez-vous</a></p>
                                    
    </div>

</body>
</html>