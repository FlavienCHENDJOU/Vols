
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AéroFlight - Réservez votre prochain voyage</title>
    <link type="text/css" rel="stylesheet" href="{{asset('css/homestyle.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 
        #fond{
            background:linear-gradient(rgba(199, 199, 201, 0.6), rgba(224, 222, 222, 0.6)), 
                       url("{{ asset('/img/01.jpg') }}") no-repeat center center fixed;
        
        }
        .vol-hidden {
             display: none !important;
         }
    </style> 

</head>


<body id='fond'>

    <nav class="top-nav">
        <div class="logo">AéroFlight <i class="fas fa-plane"></i></div>
        <div class="nav-links d-none-mobile">
            <a href="{{ url('connexion') }}">Vols</a>
            <a href="{{ url('connexion') }}">Hotels</a>
            <a href="{{ url('connexion') }}">Sites</a>
        </div>
        <div class="nav-auth">
            <a href="{{ url('connexion') }}" class="btn-login">Connexion</a>
            <a href="{{ url('accueil') }}" class="btn-signup">S'inscrire</a>
        </div>
    </nav>

        <header class="hero" style="background:none">
            <div class="hero-content">
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


            </div>
        </header>
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
                                <tr class="vol-item" 
                                    data-depart="{{ strtolower($vol->depart) }}" 
                                    data-destination="{{ strtolower($vol->destination) }}"
                                    data-date="{{ $vol->date_depart }}"
                                    data-classe="{{ strtolower($vol->classe) }}">
                                    
                                    <td class="px-4 text-muted fw-bold">
                                        #{{ $loop->iteration }}
                                    </td>
                                    
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
                                        <span class="fw-bold text-dark" style="font-size: 1.2rem;">
                                            {{ number_format($vol->prix, 2) }} $
                                        </span>
                                    </td>

                                    <td class="text-end px-4">
                                        <a href="{{ url('connexion')}}" class="btn-signup">Réserver </a>
                                    </td>                        
                                </tr>
                                @endforeach
                            </tbody>
                        </table>  
                        <div id="loading-sentinel" class="text-center py-4" >
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                            <p>Chargement des vols suivants...</p>
                        </div>             
                    </div>
                </div>
            </div>

            <div id="noResult" class="text-center py-5" style="display: none;">
                <i class="fas fa-plane-slash fa-4x text-muted mb-3"></i>
                <h3 class="text-white">Aucun vol trouvé</h3>
            </div>
        </div>

    <footer class="main-footer">
        <p>&copy; 2026 AéroFlight. </p>
    </footer>

<script>
let nextPageUrl  = null;
let isLoading    = false;
let searchTimer  = null;  // debounce

const volList  = document.getElementById('volList');
const sentinel = document.getElementById('loading-sentinel');
const noResult = document.getElementById('noResult');
const form     = document.getElementById('searchForm');

// ── Récupère les filtres actuels du formulaire ────────────────────────────────
function getFilters() {
    return {
        depart:      form.querySelector('[name="depart"]').value.trim(),
        destination: form.querySelector('[name="destination"]').value.trim(),
        date:        form.querySelector('[name="date"]').value,
        classe:      form.querySelector('[name="classe"]').value,
    };
}

// ── Construit l'URL avec les filtres en query string ──────────────────────────
function buildUrl(baseUrl, filters) {
    const url = new URL(baseUrl, window.location.origin);
    Object.entries(filters).forEach(([key, val]) => {
        if (val) url.searchParams.set(key, val);
        else     url.searchParams.delete(key);
    });
    return url.toString();
}

// ── Réinitialise la liste et recharge depuis la page 1 ───────────────────────
function resetAndSearch() {
    volList.innerHTML  = '';
    noResult.style.display = 'none';
    nextPageUrl = buildUrl('/vols', getFilters()); // remplace '/vols' par ta route
    sentinel.innerHTML = '';
    observer.observe(sentinel);
    loadMore();
}

// ── Chargement de la page suivante ───────────────────────────────────────────
function loadMore() {
    if (isLoading || !nextPageUrl) return;
    isLoading = true;

    sentinel.innerHTML = `
        <div class="d-flex justify-content-center align-items-center py-4 gap-2">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
            <span class="text-muted">Chargement...</span>
        </div>`;

    fetch(nextPageUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept':           'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(data => {
        data.vols.forEach(vol => {
            volList.insertAdjacentHTML('beforeend', createVolRow(vol));
        });

        // Renumérotation
        document.querySelectorAll('.vol-number').forEach((el, i) => {
            el.textContent = '#' + (i + 1);
        });

        nextPageUrl = data.next_page_url
            ? buildUrl(data.next_page_url, getFilters())
            : null;

        if (!nextPageUrl) {
            observer.unobserve(sentinel);
        } else {
            sentinel.innerHTML = '';
        }

        // Aucun résultat
        noResult.style.display = volList.children.length === 0 ? 'block' : 'none';
    })
    .catch(err => {
        console.error('Erreur :', err);
        sentinel.innerHTML = '<p class="text-danger text-center py-3">❌ Erreur de chargement.</p>';
    })
    .finally(() => {
        isLoading = false;
    });
}

// ── IntersectionObserver ──────────────────────────────────────────────────────
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
        loadMore();
    }
}, { root: null, rootMargin: '0px', threshold: 0.1 });

observer.observe(sentinel);

// ── Déclenchement de la recherche avec debounce (400ms) ──────────────────────
// Se lance à chaque frappe dans un input ou changement dans un select
function triggerSearch() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        resetAndSearch();
    }, 400);
}

// Écoute tous les champs du formulaire
form.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input',  triggerSearch);
    el.addEventListener('change', triggerSearch);
});

// Bouton recherche (déclenche immédiatement, sans debounce)
document.getElementById('btnSearch').addEventListener('click', () => {
    clearTimeout(searchTimer);
    resetAndSearch();
});

// ── Génération HTML d'une ligne ───────────────────────────────────────────────
function createVolRow(vol) {
    const date = new Date(vol.date_depart).toLocaleDateString('fr-FR');
    const prix = parseFloat(vol.prix).toFixed(2);

    return `
        <tr class="vol-item"
            data-depart="${vol.depart.toLowerCase()}"
            data-destination="${vol.destination.toLowerCase()}"
            data-date="${vol.date_depart}"
            data-classe="${vol.classe.toLowerCase()}">
            <td class="px-4 text-muted fw-bold"><span class="vol-number">#</span></td>
            <td>
                <div class="badge p-2" style="background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                    ${vol.classe.toUpperCase()}
                </div>
            </td>
            <td>
                <div class="fw-bold text-dark" style="font-size:1.1rem;">
                    ${vol.depart}
                    <i class="fas fa-arrow-right mx-2 text-primary" style="font-size:.8rem;"></i>
                    ${vol.destination}
                </div>
            </td>
            <td>
                <div class="text-dark fw-semibold">📅 ${date}</div>
                <div class="small text-muted">🕒 ${vol.heure_depart}</div>
            </td>
            <td class="text-center">
                <span class="fw-bold text-dark" style="font-size:1.2rem;">${prix} $</span>
            </td>
            <td class="text-end px-4">
                <a href="/connexion" class="btn-signup">Réserver</a>
            </td>
        </tr>`;
}

nextPageUrl = @json($vols->nextPageUrl());
if (!nextPageUrl) {
    observer.unobserve(sentinel);
}
</script>
</body>
</html>