@extends($layout)

@section('title', 'Vols Disponibles - AeroFlight')

@section('content')

<div class="search-container">
    <form id="searchForm" onsubmit="return false;" autocomplete="off">
        <div class="trip-type">
            <label><input type="radio" name="trip" checked> <span>Aller-retour</span></label>
            <label><input type="radio" name="trip"> <span>Aller simple</span></label>
        </div>

        <div class="search-bar">
            <div class="input-group">
                <input type="text" name="depart" placeholder="De (Ex: Paris)">
            </div>
            <div class="input-group">
                <input type="text" name="destination" placeholder="À (Ex: Douala)">
            </div>
            <div class="input-group">
                <input type="text" onfocus="(this.type='date')" name="date" placeholder="Date de départ">
            </div>
            <div class="input-group">
                <select name="classe">
                    <option value="">Toutes les classes</option>
                    <option value="economique">Économique</option>
                    <option value="business">Business</option>
                    <option value="premiere">Première</option>
                </select>
            </div>
            <button type="button" class="btn-search-main" id="btnSearch">
                <i class="fas fa-search"></i> Rechercher les vols
            </button>
        </div>
    </form>
</div>

<div class="container mt-5">
    <div class="card main-card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white"> <tr>
                            <th class="px-4 py-3"># </th>
                            <th class="py-3">Classe</th>
                            <th class="py-3">Itinéraire</th>
                            <th class="py-3">Date & Heure</th>
                            <th class="py-3 text-center">Prix</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="volList">
                    @foreach($vols as $vol) 
                    <tr class="vol-item">
                        <td class="px-4 text-muted fw-bold vol-number">#{{ $loop->iteration }}</td>
                        <td>
                            <div class="badge p-2" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                                {{ strtoupper($vol->classe) }}
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                                {{ $vol->depart }} <i class="fas fa-arrow-right mx-2 text-primary" style="font-size: 0.8rem;"></i> {{ $vol->destination }}
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-semibold">📅 {{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y') }}</div>
                            <div class="small text-muted">🕒 {{ $vol->heure_depart }}</div>
                        </td>
                        <td class="text-center">
                            <span class="fw-bold text-dark" style="font-size: 1.2rem;">{{ number_format($vol->prix, 2) }} $</span>
                        </td>
                        <td class="text-end px-4">
                            <a href="{{ route('reservations.create', ['vol_id' => $vol->id]) }}" class="btn-signup">
                                <i class="fas fa-ticket-alt me-2"></i>Réserver
                            </a>
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
                </table> 

                <div id="loading-sentinel" style="min-height: 50px;"></div>

                <div id="noResult" class="text-center py-5">
                    <i class="fas fa-plane-slash fa-4x text-muted mb-3"></i>
                    <h3 class="text-white">Aucun vol trouvé</h3>
                </div>             
            </div>
        </div>
    </div>
</div>

<script>
// On initialise nextPageUrl avec la valeur fournie par Laravel au chargement
let nextPageUrl  = "{{ $vols->nextPageUrl() }}";
let isLoading    = false;
let searchTimer  = null;

const volList  = document.getElementById('volList');
const sentinel = document.getElementById('loading-sentinel');
const noResult = document.getElementById('noResult');
const form     = document.getElementById('searchForm');

// 1. Création du HTML pour une nouvelle ligne (AJAX)
function createVolRow(vol) {
    // Formatage de la date simple
    let dateParts = vol.date_depart.split('-');
    let dateFormatee = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0];

    return `
        <tr class="vol-item">
            <td class="px-4 text-muted fw-bold vol-number">#</td>
            <td>
                <div class="badge p-2" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                    ${vol.classe.toUpperCase()}
                </div>
            </td>
            <td>
                <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                    ${vol.depart} <i class="fas fa-arrow-right mx-2 text-primary" style="font-size: 0.8rem;"></i> ${vol.destination}
                </div>
            </td>
            <td>
                <div class="text-dark fw-semibold">📅 ${dateFormatee}</div>
                <div class="small text-muted">🕒 ${vol.heure_depart || ''}</div>
            </td>
            <td class="text-center">
                <span class="fw-bold text-dark" style="font-size: 1.2rem;">${parseFloat(vol.prix).toFixed(2)} $</span>
            </td>
            <td class="text-end px-4">
                <a href="/reservations/create?vol_id=${vol.id}" class="btn-signup">
                    <i class="fas fa-ticket-alt me-2"></i>Réserver
                </a>
            </td>                        
        </tr>`;
}

function getFilters() {
    return {
        depart:      form.querySelector('[name="depart"]').value.trim(),
        destination: form.querySelector('[name="destination"]').value.trim(),
        date:        form.querySelector('[name="date"]').value,
        classe:      form.querySelector('[name="classe"]').value,
    };
}

function resetAndSearch() {
    volList.innerHTML  = '';
    noResult.style.display = 'none';
    isLoading = false;
    
    // On construit l'URL de départ pour la recherche filtrée
    // Utilise l'URL actuelle de la page sans les anciens params
    const baseUrl = window.location.pathname; 
    nextPageUrl = buildUrl(baseUrl, getFilters());
    
    sentinel.innerHTML = '';
    loadMore(); 
}

function buildUrl(baseUrl, filters) {
    const url = new URL(baseUrl, window.location.origin);
    Object.entries(filters).forEach(([key, val]) => {
        if (val) url.searchParams.set(key, val);
    });
    return url.toString();
}

function loadMore() {
    if (isLoading || !nextPageUrl) return;
    isLoading = true;

    sentinel.innerHTML = `
        <div class="d-flex justify-content-center align-items-center py-4 gap-2">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
            <span class="text-muted">Chargement des vols...</span>
        </div>`;

    fetch(nextPageUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.vols.length > 0) {
            data.vols.forEach(vol => {
                volList.insertAdjacentHTML('beforeend', createVolRow(vol));
            });
            noResult.style.display = 'none';
        }

        // Renumérotation des lignes
        document.querySelectorAll('.vol-number').forEach((el, i) => {
            el.textContent = '#' + (i + 1);
        });

        nextPageUrl = data.next_page_url;
        sentinel.innerHTML = '';

        if (!nextPageUrl && volList.children.length === 0) {
            noResult.style.display = 'block';
        }
    })
    .catch(err => {
        console.error('Erreur :', err);
        sentinel.innerHTML = '<p class="text-danger text-center py-3">Erreur de connexion.</p>';
    })
    .finally(() => {
        isLoading = false;
    });
}

// ── ÉCOUTEURS D'ÉVÉNEMENTS ──────────────────────────────────────────────────

// Détection du scroll
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
        loadMore();
    }
}, { threshold: 0.1 });
observer.observe(sentinel);

// Détection de la saisie (avec délai de 500ms pour économiser le serveur)
form.addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(resetAndSearch, 500);
});

// Bouton recherche
document.getElementById('btnSearch').addEventListener('click', resetAndSearch);

</script>
@endsection