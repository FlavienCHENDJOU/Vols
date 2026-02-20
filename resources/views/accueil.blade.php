
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Accueil - Plateforme de Réservation</title>
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="css/accueilstyle.css" />
    </head>

    <<body style="background: url('{{ asset('/img/01.jpg') }}') no-repeat center center fixed; background-size: cover;">
        <header> 
            <h1>Compagnie Aérienne - Gestion des Réservations</h1>
            <p>Votre voyage commence ici. Sécurité, Confort et Rapidité.</p>
            <p style="font-size: 18px">Bienvenue sur notre plateforme .Ici, vous pouvez rechercher un vol, consulter les détails sur ce vol et effectuer facilement vos réservations. Vous pouvez egalement interagire avec nos administrateur et nous laissez vos avis sur la qualite de nos service. <br> Nous faisons de votre satifaction notre priorite </p>
        </header>
        <div id="booking" class="section"> 
            <div class="section-center">
                <div class="container">
                    
                    <div class="row">
                        <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" class="img" style="margin-top: 30px !important;">
                        <div class="col-md-7 col-md-offset-1">

                            <div class="booking-form">
                                <div id="booking-cta">
                                    <h1>Créez un compte</h1> 
                                    <p class="text-muted">Rejoignez-nous pour gérer vos vols en un clic.</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ url('/enregistrement') }}" method="POST">
                                  @csrf  
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">Nom</span>
                                                <input class="form-control" type="text" name="nom" required value="{{old('nom')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">Prénom</span>
                                                <input class="form-control" type="text" name="prenom" required value="{{old('prenom')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">E-mail</span>
                                                <input class="form-control" type="email" name="email" placeholder="votre@email.com" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span class="form-label">Mot de passe</span>
                                                <input class="form-control" type="password" name="password"  placeholder="********" required>
                                            </div>
                                        </div>
                                    </div>
                                   <p style="text-align: center;">Déjà inscrit ?  <a href="{{ url('connexion') }}" style="color: #007bff; font-weight: bold;">Connectez-vous</a></p>
                                    <div class="form-btn">
                                        <button type="submit" name="go" class="btn">Creer</button>
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
