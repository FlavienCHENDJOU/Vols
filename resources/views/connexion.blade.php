<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion - Plateforme de Réservation</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <style>
        body {
			 background: #f4f7f6;
			 font-family: 'Poppins', 
			sans-serif; padding: 5%; 
		}
        .booking-form { 
			 border-radius: 15px; 
			 }
        .img { 
			width: 85%; 
			max-height: 250px; 
			object-fit: cover; 
			border-radius: 20%; 
			margin-bottom: 20px; 
			box-shadow: 0 5px 15px rgba(0,0,0,0.2);
		 }

		  .btn {
            display: inline-block;
            width: auto;
            min-width: 200px;
            margin: 30px auto;
            padding: 15px 30px;
            background-color: #ff5733;
			border: none;
            color: white;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 87, 51, 0.4);
            
        }

        .btn:hover  {
            background-color: #c70039;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(199, 0, 57, 0.6);
        }
		 .col-md-6 {
            text-align: center;
             justify-content: center;
        }
        .error-msg { 
			color: #721c24;
		    background-color: #f8d7da; 
			border: 1px solid #f5c6cb; 
			padding: 10px; 
			border-radius: 5px; 
			margin-bottom: 20px; 
		}
        .success-msg {
			 color: #155724; 
			 background-color: #d4edda; 
			 border: 1px solid #c3e6cb; 
			 padding: 10px; 
			 border-radius: 5px; 
			 margin-bottom: 20px; 
		}
 

		@media (max-width: 768px) {
            .img {
                display: none; 
                }
        }
   </style>
</head>

<body id="booking">
    <div  class="section">
        <div class="row align-items-center">
            
            <div class="col-md-4 d-none d-md-block">
                <img src="{{ asset('img/volimage.jpeg') }}" class="img">
                <img src="{{ asset('img/volimage.jpeg') }}" class="img">
            </div>

            <div class="col-md-6">
                <div class="booking-form">
                    <div class="text-center mb-4">
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
                        <div class="form-group mb-3">
                            <span class="form-label">E-mail</span>
                            <input class="form-control" type="email" name="email" placeholder="votre@email.com" required>
                        </div>

                        <div class="form-group mb-4">
                            <span class="form-label">Mot de passe</span>
                            <input class="form-control" type="password" name="password" placeholder="********" required>
                        </div>

                        <button type="submit" class="btn">S'IDENTIFIER</button>
                        
                        <p class="text-center mt-3">Nouveau ici ? <a href="{{ url('enregistrement') }}" style="color: #ff5733; font-weight: bold;">Créer un compte</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>