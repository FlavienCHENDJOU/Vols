@extends('layouts/admin')

@section('title', 'Gestion des Vols')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-plane me-2 text-primary"></i> Gestion des Vols</h2>
        @can('creer-vols')
            <button type="button" class="btn btn-update-premium" data-bs-toggle="modal" data-bs-target="#addVolModal">
                <i class="fas fa-plus-circle me-2"></i> AJOUTER UN NOUVEAU VOL
            </button>
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
                            <th class="px-4 py-3">N° Vol</th>
                            <th class="py-3">Départ</th>
                            <th class="py-3">Arrivée</th>
                            <th class="py-3">Date & Heure</th>
                            <th class="py-3">Places</th>
                            <th class="py-3">Prix</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                     
                    <tbody id="vols-container">
                        @foreach($vols as $vol) 
                            <tr class="vol-item">
                                <td class="px-4 text-muted vol-number">
                                    #{{ ($vols->currentPage() - 1) * $vols->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $vol->depart }}</td>
                                <td>{{ $vol->destination }}</td>
                                <td>{{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge {{ $vol->places_disponibles > 10 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $vol->places_disponibles }}
                                    </span>
                                </td>
                                <td class="fw-bold text-nowrap">{{ number_format($vol->prix, 2) }} €</td>
                                <td class="text-end px-4">
                                    @can('modifier-vols')
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editVolModal{{ $vol->id }}" class="me-2 text-decoration-none">
                                            <img src="{{ asset('img/edit.png') }}" alt="Modifier" style="width: 22px;"> 
                                        </a>
                                    @endcan
                                    @can('supprimer-vols')
                                        <a href="{{ url('/admin/vols/supprimer/'.$vol->id) }}" onclick="return confirm('⚠️ Supprimer ce vol ?')">
                                            <img src="{{ asset('img/delete.png') }}" alt="Supprimer" style="width: 22px;">
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                    </table> 
                    <div id="loading-sentinel" style="min-height: 50px;"></div>             
            </div>
        </div>
    </div>


<div class="modal fade" id="addVolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Nouveau Vol</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/vols/ajouter') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        @php
                            $prochainID = \App\Models\Vol::max('id') + 1;
                        @endphp

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Numéro de vol (Auto)</label>
                            <input type="text" name="numero_vol" class="form-control bg-light" value="{{ $prochainID }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Prix (€)</label>
                            <input type="number" name="prix" class="form-control" placeholder="150" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Ville de départ</label>
                            <input type="text" name="ville_depart" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Ville d'arrivée</label>
                            <input type="text" name="ville_arrivee" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Date de départ</label>
                            <input type="datetime-local" name="date_depart" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Places totales</label>
                            <input type="number" name="places_disponibles" class="form-control" value="100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-update-premium" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-update-premium">Enregistrer le vol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- GESTION DES MODAUX ET ALERTES ---
    const myModal = document.getElementById('addVolModal');
    if(myModal) {
        myModal.addEventListener('shown.bs.modal', function () {
            const firstInput = myModal.querySelector('input[name="prix"]'); // Focus sur le prix car numero_vol est readonly
            if(firstInput) firstInput.focus();
        });
    }

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });

    // --- SCROLL INFINI (INTERSECTION OBSERVER) ---
    let nextPageUrl = "{{ $vols->nextPageUrl() }}";
    let isLoading = false;
    const volsContainer = document.getElementById('vols-container');
    const sentinel = document.getElementById('loading-sentinel');

    function createVolRow(vol) {
        let dateObj = new Date(vol.date_depart);
        let dateStr = dateObj.toLocaleDateString('fr-FR') + ' ' + (vol.heure_depart ? vol.heure_depart.substring(0,5) : '');
        let badgeClass = vol.places_disponibles > 10 ? 'bg-success' : 'bg-danger';
        let prix = new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(vol.prix);

        return `
            <tr class="vol-item">
                <td class="px-4 text-muted vol-number">#</td>
                <td>${vol.depart}</td>
                <td>${vol.destination}</td>
                <td>${dateStr}</td>
                <td><span class="badge ${badgeClass}">${vol.places_disponibles}</span></td>
                <td class="fw-bold text-nowrap">${prix} €</td>
                <td class="text-end px-4">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editVolModal${vol.id}" class="me-2 text-decoration-none">
                        <img src="/img/edit.png" style="width: 22px;"> 
                    </a>
                    <a href="/admin/vols/supprimer/${vol.id}" onclick="return confirm('⚠️ Supprimer ce vol ?')">
                        <img src="/img/delete.png" style="width: 22px;">
                    </a>
                </td>
            </tr>`;
    }

    function loadMore() {
        if (isLoading || !nextPageUrl) return;
        isLoading = true;

        sentinel.innerHTML = `
            <div class="d-flex justify-content-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span class="ms-2 text-muted">Chargement...</span>
            </div>`;

        fetch(nextPageUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.vols) {
                data.vols.forEach(vol => {
                    volsContainer.insertAdjacentHTML('beforeend', createVolRow(vol));
                });
            }

            // Mise à jour de la numérotation automatique
            document.querySelectorAll('.vol-number').forEach((el, i) => {
                el.textContent = '#' + (i + 1);
            });

            nextPageUrl = data.next_page_url;
            sentinel.innerHTML = '';
        })
        .catch(err => {
            console.error('Erreur:', err);
            sentinel.innerHTML = '';
        })
        .finally(() => { isLoading = false; });
    }

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
            loadMore();
        }
    }, { threshold: 0.1 });

    if(sentinel) observer.observe(sentinel);
});
</script>
@endsection

