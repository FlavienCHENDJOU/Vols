
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Accueil - Plateforme de Réservation</title>
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
    </head>

    <style>
        header {
            background-color: #007bff;
            color: black;
            padding: 10px 0;
            text-align: center;
        }
        .img {
            width: 20%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin:10px 0px 5px 100px;
        }
     </style>        

    <body>
        <header> 
            <h1>Compagnie Aérienne - Gestion des Réservations</h1>
            <p style="font-size: 18px">Bienvenue sur notre plateforme .Ici, vous pouvez rechercher un vol, consulter les détails sur ce vol et effectuer facilement vos réservations. Vous pouvez egalement interagire avec nos administrateur et nous laissez vos avis sur la qualite de nos service. <br> Nous faisons de votre satifaction notre priorite </p>
        </header>
        <div id="booking" class="section"> 
            <div class="section-center">
                <div class="container">
                    
                    <div class="row">
                        <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" class="img"> 
                        <div class="col-md-7 col-md-offset-1">
                            <div class="booking-form">
                                <div id="booking-cta">
                                    <h1>Créez un compte</h1>
                                    <p>Créez un compte afin de profiter des services de notre compagnie en toute simplicité.</p>
                                </div>
                                <form action="enregistrement" method="GET">
                                  @csrf  
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">Nom</span>
                                                <input class="form-control" type="text" name="nom" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">Prénom</span>
                                                <input class="form-control" type="text" name="prenom" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">E-mail</span>
                                                <input class="form-control" type="email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">Mot de passe</span>
                                                <input class="form-control" type="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <p>Vous avez déjà un compte ? Connectez-vous <span><a href='connexion'>ici</a></span></p>
                                    <div class="form-btn">
                                        <button type="submit" name="go" class="submit-btn">Creer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" class="img"> 
                        <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" class="img"> 
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </body>
</html>