<!DOCTYPE html>
<html lang="en">

<head>
	<title>Connection- Plateforme de Réservation</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />

</head>
    <style>
        .img {
            width: 20%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin:10px 0px 80px 100px;
        }
   </style> 
<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">

					<div class="col-md-7 col-md-offset-1">

						<div class="booking-form">
							<div id="booking-cta">
								<h1>Se connecter
								</h1>
								<p>Connectez-vous à l'aide de votre compte et accédez à nos services</p>
							</div>
							<form action="infoUtilisateur" method="GET">
								@csrf 
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">E-mail</span>
											<input class="form-control" type="text" name="mail">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Mot de passe</span>
											<input class="form-control" type="password" name="password">
										</div>
									</div>
								</div>

								<p >Retourner a la page d'acceuil et cree votre compte <span><a href='/'>ici</a></span></p>
								<div class="form-btn">
									<button name="go2" class="submit-btn">S'identifier</button>
								</div>
							</form>
						</div>
					</div>
                    <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" class="img"> 
                    <img src="{{ asset('img/volimage.jpeg') }}" alt="Avion en vol" class="img"> 
				</div>
			</div>
		</div>
	</div>
</body>

</html>