<nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top shadow-sm py-3">
    <div class="container">
        <div class="logo" style="margin-right:10%">AéroFlight <i class="fas fa-plane"></i></div>
        
        <input type="checkbox" id="menu-cb" class="menu-cb">
        <label for="menu-cb" class="menu-icon">
            <span></span><span></span><span></span>
        </label>

        <div class="nav-content-wrapper" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                 <li class="nav-item"> <a class="nav-link px-3" href="{{ url('/infoUtilisateur') }}"> profil utilisateur</a> </li>
                <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/vols_disponible') }}">Vols disponibles</a></li>
                <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/mes_reservations') }}">Mes réservations</a></li>
            </ul>
             
            <div class="auth-buttons gap-2">
                <button onclick="window.history.back()" class="btn-custom-blue">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </button>
                <a class="btn-signup" href="{{ url('/exit') }}"> 
                    <i class="fas fa-sign-out-alt me-2"></i>Quitter
                </a>
            </div>
        </div>
    </div>
</nav>