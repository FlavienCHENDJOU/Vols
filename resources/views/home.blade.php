<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil - Réservations</title>
    <style>

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
       .container {
            max-width: 900px;
            width: 90%;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.1);                 /* Effet de verre (Glassmorphism) */
            backdrop-filter: blur(15px); 
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 2.5rem;
            font-style: italic;
            font-weight: bold;
            margin: 0px 100px 0px 120px;
            text-decoration: underline;
            text-align: center;
            text-transform: uppercase; 
            letter-spacing: 0,5cm;
            word-spacing: 0,5cm;
            border:10px dashed rgba(255, 255, 255, 0.42);
            margin: 0px 100px 0px 120px
        }
        

        h2 {
            font-weight: 300;
            opacity: 0.9;
            font-size: 1.2rem;
        }
        
        .moving-text {
            position: absolute;
            bottom: 10px;
            left: 100%;
            background: rgba(255, 255, 255, 0.7);
            color: black;
            padding: 10px;
            border-radius: 5px;
            white-space: nowrap;
        }
        .button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 15px;
            text-align: center;
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #c70039;
        }

        .image-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .image-section {
            position: relative;
            flex: 1; 
            margin: 0 10px;
        }

        .image-section img {
            width: 100%;
            border-radius: 8px;
            transition: transform 0.5s;
        }

        .image-section img:hover {
            transform: scale(1.05);
        }

        .moving-text {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.7);
            color: black;
            padding: 10px;
            border-radius: 5px;
            white-space: nowrap;
        }
    </style>
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

        <a href="accueil" class="button">Commencer l'Essai</a>
    </div>

</body>
</html>