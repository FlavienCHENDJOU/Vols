@extends('layouts/admin')

@section('title', 'Gestion des Réservations')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i> Gestion des Réservations</h2>
        <p class="text-muted">Consultez et gérez l'ensemble des billets réservés.</p>
    </div>
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('reservations.export.csv') }}" class="btn btn-success">
            <i class="fas fa-file-excel me-2"></i> Exporter en CSV (Excel)
        </a>
        <a href="{{ route('reservations.export.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf me-2"></i> Rapport PDF Global
        </a>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-plane me-2 text-primary"></i> Gestion des Vols</h2>
        @can('voir-reservations')
          <a href="{{ url('/admin/vols/historique') }}" class="btn btn-update-premium">
            <i class="fas fa-history me-1"></i> VOIR L'HISTORIQUE DES VOLS
          </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card main-card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Passager</th>
                            <th class="py-3">Vol</th>
                            <th class="py-3">Date Réservation</th>
                            <th class="py-3">Statut</th>
                            @can('annuler-reservation')
                                <th class="py-3 text-end px-4">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                   <tbody id="reservationList">
                        @foreach($reservations as $res) 
                        <tr>
                            <td class="px-4 text-muted reservation-number">
                                #{{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="fw-bold">{{ $res->prenom }} {{ $res->nom }}</div>
                                <small class="text-muted">{{ $res->email ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="badge bg-soft-info text-info p-2" style="background: #e0f2fe;">
                                    ✈️ {{ $res->vol->depart ?? '???' }} → {{ $res->vol->destination ?? '???' }}
                                </div>
                                <div class="small mt-1 text-dark">
                                    Le {{ $res->vol ? \Carbon\Carbon::parse($res->vol->date_depart)->format('d/m/Y') : '-' }}
                                </div>
                            </td>
                            <td>{{ $res->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge bg-success">Confirmé</span></td>
                            @can('annuler-reservation')  
                                <td class="text-end px-4">
                                    <a href="{{ url('/admin/reservations/supprimer/'.$res->id) }}" onclick="return confirm('Annuler ?')">
                                        <img src="{{ asset('img/delete.png') }}" style="width: 22px;">
                                    </a>
                                </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table> 
                
            </div>
            <div class="d-flex justify-content-center mt-4">
            </div>
            <div id="loading-sentinel" style="min-height: 50px;"></div>               
        </div>
    </div>
</div>

<script>
let nextPageUrl  = "{{ $reservations->nextPageUrl() }}";
let isLoading    = false;

const reservationList = document.getElementById('reservationList');
const sentinel        = document.getElementById('loading-sentinel');

function createReservationRow(res) {
    let createdAt = new Date(res.created_at).toLocaleString('fr-FR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'});
    let volDate = res.vol ? new Date(res.vol.date_depart).toLocaleDateString('fr-FR') : '-';
    let itineraire = res.vol ? `${res.vol.depart} → ${res.vol.destination}` : 'Vol inconnu';

    return `
        <tr>
            <td class="px-4 text-muted reservation-number">#</td>
            <td>
                <div class="fw-bold">${res.prenom} ${res.nom}</div>
                <small class="text-muted">${res.email || '-'}</small>
            </td>
            <td>
                <div class="badge bg-soft-info text-info p-2" style="background: #e0f2fe;">✈️ ${itineraire}</div>
                <div class="small mt-1 text-dark">Le ${volDate}</div>
            </td>
            <td>${createdAt}</td>
            <td><span class="badge bg-success">Confirmé</span></td>
            <td class="text-end px-4">
                <a href="/admin/reservations/supprimer/${res.id}" onclick="return confirm('Annuler ?')">
                    <img src="/img/delete.png" style="width: 22px;">
                </a>
            </td>
        </tr>`;
}

function loadMore() {
    if (isLoading || !nextPageUrl) return;
    isLoading = true;

    sentinel.innerHTML = `
        <div class="d-flex justify-content-center align-items-center py-4 gap-2">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
            <span class="text-muted">Chargement des réservations...</span>
        </div>`;

    fetch(nextPageUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if(data.reservations && data.reservations.length > 0) {
            data.reservations.forEach(res => {
                reservationList.insertAdjacentHTML('beforeend', createReservationRow(res));
            });
        }

        document.querySelectorAll('.reservation-number').forEach((el, i) => {
            el.textContent = '#' + (i + 1);
        });

        nextPageUrl = data.next_page_url;
        sentinel.innerHTML = '';
    })
    .catch(err => {
        console.error('Erreur :', err);
        sentinel.innerHTML = '<p class="text-danger text-center py-3">Erreur de connexion.</p>';
    })
    .finally(() => { isLoading = false; });
}

const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
        loadMore();
    }
}, { threshold: 0.1 });

if(sentinel) observer.observe(sentinel);
</script>

@endsection
