<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase tracking-wider" href="#">
            <i class="fas fa-plane me-2 text-warning"></i>Compagnie Aérienne
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                 <li class="nav-item"> <a class="nav-link px-3" href="{{ url('/infoUtilisateur') }}"> profil utilisateur</a> </li>
                <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/vols_disponible') }}">Vols disponibles</a></li>
                <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/mes_reservations') }}">Mes réservations</a></li>
            </ul>
             
        </div>
            <div class="d-flex align-items-center" style="margin-right: 1%;">
                <button onclick="window.history.back()"class="btn btn-warning fw-bold px-4 rounded-pill shadow-sm" ><i class="fas fa-sign-in-alt me-2"></i>retour  </a>
            </div>
            
    </button>
            <div class="d-flex align-items-center">
                 <a class="btn btn-warning fw-bold px-4 rounded-pill shadow-sm" href="{{ url('/exit') }}"> <i class="fas fa-sign-in-alt me-2"></i>Quitter  </a>
            </div>
        </div>
    </div>
</nav>

