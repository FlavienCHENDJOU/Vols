<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AéroFlight. - Créer un compte</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link type="text/css" rel="stylesheet" href="{{ asset('css/accueilstyle.css') }}" >
    </head>

    <body>
      
    <div>
        <div class="split-container">
            <div class="left-side">
                <div class="overlay"></div>
                <div class="left-content">
                    <div class="logo-white">
                        <i class="fas fa-plane-departure"></i> AéroFlight.
                    </div>
                    <div class="hero-text">
                        <h1>Voyagez avec Excellence</h1>
                        <p>Rejoignez  AéroFlight aujourd'hui. Créez un compte pour gérer vos réservations et découvrez le futur du voyage premium.</p>
                    </div>
                    <div class="left-footer">
                        <span><i class="fas fa-check-circle"></i> Embarquement Prioritaire</span>
                        <span><i class="fas fa-gift"></i> Programme Fidélité</span>
                        <span><i class="fas fa-headset"></i> Conciergerie 24/7</span>
                    </div>
            </div>
        </div>

        <div class="right-side">
            <div class="form-wrapper">
                <h2 class="form-title">Créer un compte</h2>
                <p class="form-subtitle">Rejoignez le cercle fermé des voyageurs du monde.</p>

                @if ($errors->any())
                    <div class="alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('/enregistrement') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Nom</label>
                        <div class="input-field">
                            <i class="far fa-user"></i>
                            <input type="text" name="nom" placeholder="Entrer votre nom" required value="{{ old('nom') }}">
                        </div>
                        <label>Prenom</label>
                        <div class="input-field">
                            <i class="far fa-user"></i>
                            <input type="text" name="prenom" placeholder="Entrer votre prenom" required value="{{ old('prenom') }}">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Adresse e-mail</label>
                        <div class="input-field">
                            <i class="far fa-envelope"></i>
                            <input type="email" name="email" placeholder="nom@gmail.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Mot de passe</label>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                        <small>Au moins 8 caractères.</small>
                    </div>

                    <button type="submit" class="btn-submit">
                        S'inscrire <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <p class="footer-link">Vous avez déjà un compte ? <a href="{{ url('connexion') }}">Connexion</a></p>
                
                <div class="mini-footer">
                    <span>Support</span> <span>Confidentialité</span> <span>Conditions</span>
                    <p>© 2026 AéroFlight.</p>
                </div>              
            </div>
        </div>
    </div>
     <footer class="main-footer">
        <p>&copy; 2026 AéroFlight. </p>
    </footer>
    </body>


</html> -


