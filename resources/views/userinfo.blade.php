

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profil Utilisateur - Compagnie aérienne</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
</head>
   <style>
     .carousel-inner{
            width: 600px;
            height: 400px ;
            border: 5px solid black;
            border-radius: 10px;
            margin:-280px 0px 0px 600px;
        }

        .carousel-inner img {
            width: 100%;
            height:100% ;
            object-fit: cover;
            
        }
   </style>
<body>
     @include('navbar')
    <div id="booking" class="section"> 
       

            <div style="height:100vh">
                <div class="container">
                    <div class="row">
                        <div style="margin: 13%;" class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Profil Utilisateur</h4>
                                    <hr>
                                    <form method="POST" action="infoUtilisateur.update">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="username" class="col-4 col-form-label">NOM</label>
                                            <div class="col-8">
                                                <input name="id" value="id_user" type="hidden">
                                                <input id="username" name="nom" value="nom"
                                                       class="form-control" required type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-4 col-form-label">PRENOM</label>
                                            <div class="col-8">
                                                <input id="name" name="prenom" value="prenom "
                                                       class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastname" class="col-4 col-form-label">EMAIL</label>
                                            <div class="col-8">
                                                <input id="lastname" name="mail" value="email "
                                                       class="form-control" type="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-4 col-form-label">PASSWORD</label>
                                            <div class="col-8">
                                                <input id="password" name="password" class="form-control" type="password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="feedback" class="col-4 col-form-label">Laissez un avis</label>
                                            <div class="col-8">
                                                <textarea id="feedback" name="feedback" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-4 col-8">
                                                <button name="update_user_info" type="submit"
                                                        class="btn btn-info">Modifier mon Profil</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Informations Utilisateur</h5>
                                    <p><strong>Nom:</strong> nom</p> 
                                    <p><strong>Prénom:</strong> prenom</p>
                                    <p><strong>Email:</strong>email</p>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('img/image1.jpeg')}}" class="d-block w-100" alt="Image 1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('img/image2.jpeg')}}" class="d-block w-100" alt="Image 2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('img/image3.jpeg')}}" class="d-block w-100" alt="Image 3">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('img/PNG-images-Plane-4png.png')}}" class="d-block w-100" alt="Image 4">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('img/image4.jpeg')}}" class="d-block w-100" alt="Image 5">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('img/airplane-wing-towards-clouds-731217aaaaa.jpg')}}" class="d-block w-100" alt="Image 6">
                                        </div>
                                         <div class="carousel-item">
                                            <img src="{{ asset('img/airplane-wing-towards-clouds-731217.jpg')}}" class="d-block w-100" alt="Image 7">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Précédent</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Suivant</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
       
        @include('script')
    </div>

</body>
</html>        

