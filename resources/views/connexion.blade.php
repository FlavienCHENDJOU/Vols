<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AéroFlight - Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/accueilstyle.css') }}" />
</head>

<body>
    <div class="split-container">
        <div class="left-side">
            <div class="overlay"></div>
            <div class="left-content">
                <div class="logo-white">
                    <i class="fas fa-plane-departure"></i> AéroFlight.
                </div>
                <div class="hero-text">
                    <h1>Bon retour parmi nous</h1>
                    <p>Connectez-vous pour accéder à vos réservations, modifier vos vols et explorer vos prochaines destinations.</p>
                </div>
                <div class="left-footer">
                    <span><i class="fas fa-shield-alt"></i> Connexion Sécurisée</span>
                    <span><i class="fas fa-ticket-alt"></i> Billets Électroniques</span>
                    <span><i class="fas fa-history"></i> Historique de Voyage</span>
                </div>
            </div>
        </div>

        <div class="right-side">
            <div class="form-wrapper">
                <h2 class="form-title">Se connecter</h2>
                <p class="form-subtitle">Entrez vos identifiants pour accéder à votre espace.</p>

                @if(session('success'))
                    <div style="background: #ecfdf5; color: #059669; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ url('/connexion') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Adresse e-mail</label>
                        <div class="input-field">
                            <i class="far fa-envelope"></i>
                            <input type="email" name="email" placeholder="votre@email.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Mot de passe</label>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                        <div style="text-align: right; margin-top: 5px;">
                            <a href="#" style="font-size: 0.8rem; color: var(--text-light); text-decoration: none;">Mot de passe oublié ?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        S'identifier <i class="fas fa-sign-in-alt"></i>
                    </button>
                </form>

                <p class="footer-link">Nouveau ici ? <a href="{{ url('/accueil') }}">Créer un compte</a></p>
                
                <div class="mini-footer">
                    <span>Aide</span> <span>Confidentialité</span> <span>Conditions</span>
                    <p>© 2026 AéroFlight Inc.</p>
                </div>              
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <p>&copy; 2026 AéroFlight. Tous droits réservés.</p>
    </footer>
</body>
</html>


