<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion - Plateforme de Réservation</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('css/connexionstyle.css') }}">
</head>
<<body style="background: url('{{ asset('/img/01.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div  class="auth-container">
        <div class="row align-items-center">

            <div class="col-md-6">
                <div class="booking-form">
                    <div class="text-center">
                        <h1> SE CONNECTER</h1>
                        <p class="text-muted">Bon retour!Connecte toi et accédez à votre espace réservation</p>
                    </div>

                    @if(session('success'))
                        <div class="success-msg">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="error-msg">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ url('/connexion') }}" method="POST">
                        @csrf 
                        <div class="form-group">
                            <span class="form-label">E-mail</span>
                            <input class="form-control" type="email" name="email" placeholder="votre@email.com" required>
                        </div>

                        <div class="form-group ">
                            <span class="form-label">Mot de passe</span>
                            <input class="form-control" type="password" name="password" placeholder="********" required>
                        </div>

                        <button type="submit" class="btn">S'IDENTIFIER</button>
                        
                        <p class="link-alt">Nouveau ici ? <a href="{{ url('/accueil') }}" style="color: #ff5733; font-weight: bold;">Créer un compte</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


          