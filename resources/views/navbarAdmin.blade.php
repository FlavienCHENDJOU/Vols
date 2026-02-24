<nav class="admin-sidebar bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
    <h4 class="text-center">Dashboard Admin</h4>
    <ul class="nav flex-column mt-4">
            <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/vols_disponible') }}">🌐Vols disponibles</a> </li>
            <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/mes_reservations') }}">👤Mes réservations</a></li>         
        <hr class="bg-secondary"> <h3 class="px-3">Fonctions Admins</h5><hr  class="bg-secondary">
       
        @canany(['voir-vols', 'creer-vols', 'modifier-vols', 'supprimer-vols'])
            <li class="nav-item"><a class="nav-link px-3" href="{{ url('/admin/vols') }}">✈️ Gestion des Vols</a> </li>
        @endcanany

        @canany(['voir-reservations', 'annuler-reservations'])   
            <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/admin/reservations') }}" >Gestion Réservations</a></li>
        @endcanany
        @canany(['voir-utilisateurs','supprimer-utilisateurs'])
                <li class="nav-item"> <a class="nav-link" href="/admin/users">Gestion des Utilisateurs</a></li>
        @endcanany
        @can('gerer-roles-permissions')
            <li class="nav-item">  <a class="nav-link px-3" href="{{ route('roles.index') }}">Gestion des Rôles</a></li>
        @endcan   
        <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/admin') }}"> ⬅️ retour </a></li>
        <li class="nav-item">  <a class="nav-link px-3" href="{{ url('/exit') }}">🏠quitter</a></li>
    </ul>
</nav>



