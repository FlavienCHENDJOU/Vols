
@extends($layout)

@section('title', 'Vols Disponibles - AeroFlight')

@section('content')
   
<link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />


    
<div class="sticky-search shadow-sm">
    <div class="container">
        <div class="search-container bg-white p-2 rounded-4 border">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-primary"></i></span>
                <input type="text" id="searchInput" class="form-control border-0 shadow-none" placeholder="Chercher une ville, un pays..." onkeyup="filterVols()">
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <ul class="vol-list p-0" id="volList">
        @foreach ($vols as $vol)
        <li class="vol-item vol-card" data-search="{{ strtolower($vol->depart) }} {{ strtolower($vol->destination) }}">
            <div class="info-vol">
                <div class="route">
                    <span class="vol-number">#{{ $loop->iteration }}</span>
                    {{ $vol->depart }} <i class="fas fa-plane"></i> {{ $vol->destination }}
                </div>
                
                <div class="details-time">
                    <div><i class="far fa-calendar-alt"></i> {{ $vol->date_depart }}</div>
                    <div><i class="far fa-clock"></i> {{ $vol->heure_depart }}</div>
                </div>

                <div class="actions d-flex gap-2">
                    <a href="{{ url('/reserver/' . $vol->id) }}" class="btn btn-reserve">
                        <i class="fas fa-ticket-alt"></i> Réserver
                    </a>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalVol{{ $vol->id }}">
                        <i class="fas fa-info-circle"></i> Détails
                    </button>
                </div>
            </div>
          
            <div class="img-container d-none d-md-block">
                <img src="{{ asset('img/volimage.jpeg') }}" alt="Aperçu vol">
            </div>

            <div class="modal fade" id="modalVol{{ $vol->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header border-0 bg-light">
                            <h5 class="modal-title fw-bold">Vol #{{ $loop->iteration }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-md-7">
                                    <h4 class="fw-bold text-primary">{{ $vol->depart }} ➔ {{ $vol->destination }}</h4>
                                    <p><strong>Prix:</strong> {{ $vol->prix }} €</p>
                                    <p><strong>Places:</strong> {{ $vol->places_disponibles }}</p>
                                    <p><strong>Date:</strong> {{ $vol->date_depart }}</p>
                                    <p><strong>heure:</strong>  {{ $vol->heure_depart }}</p>
                                </div>
                                <div class="col-md-5 text-center">
                                    <img src="{{ asset('img/volimage.jpeg') }}" class="img-fluid rounded shadow">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    
    <div id="noResult" class="text-center py-5">
        <i class="fas fa-plane-slash fa-5x mb-4 text-danger"></i>
        <h2 class="fw-bold text-white">VOLS INEXISTANTS</h2>
        <p class="text-white">Aucun vol ne correspond à votre recherche pour le moment.</p>
    </div>
</div>

<script>
function filterVols() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let cards = document.getElementsByClassName('vol-card');
    let noResult = document.getElementById('noResult');
    let volList = document.getElementById('volList');
    let hasMatch = false;

    for (let i = 0; i < cards.length; i++) {
        let content = cards[i].getAttribute('data-search');
        if (content.includes(input)) {
            cards[i].style.display = ""; 
            hasMatch = true;
        } else {
            cards[i].style.display = "none";
        }
    }

    if (hasMatch) {
        noResult.style.display = "none";
        volList.style.display = "block";
    } else {
        noResult.style.display = "flex";
        volList.style.display = "none";
    }
}
</script>

@endsection


