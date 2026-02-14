 <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div>
       
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>   
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <a href="#">Compagnie aerienne </a>
         <hr>
    <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="accueil">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vols_disponible">vols dispognible</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="test_reservations">liste des réservations</a>
            </li>
           <li class="nav-item">
                <a class="nav-link" href="{{ url('/mes_reservations') }}">Mes réservations</a>
            </li>
        </ul>
        <a class="nav-link" href="admin">administrateur</a>
        
       @if (session('nom') && session('prenom') && session('statut'))
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ session('nom') }} {{ session('prenom') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Statut : <samp>{{ session('statut') }}</samp></a>
                        <a class="dropdown-item" href="{{ route('logout') }}">Je me déconnecte</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
            </ul>
        @else
            <a class="nav-link" href="connexion">connexion</a>
        @endif 
    </div>
</nav> 