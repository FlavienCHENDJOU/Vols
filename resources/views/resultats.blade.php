@extends($layout)

@section('title', 'Vols Disponibles - AeroFlight')

@section('content')
<div class="container">
    <div class="search-bar-container mb-5 p-4 shadow-sm bg-white" style="border-radius: 15px;">
        <form action="{{ url('/rechercher') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-bold small"><i class="fas fa-map-marker-alt text-primary"></i> Destination</label>
                <input type="text" name="destination" class="form-control" placeholder="Où voulez-vous aller ?" value="{{ request('destination') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small"><i class="fas fa-calendar-alt text-primary"></i> Date de départ</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="fas fa-search me-2"></i> RECHERCHER
                </button>
            </div>
        </form>
    </div>

    @if($vols->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-plane-slash fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">Aucun vol trouvé pour ces critères.</h3>
            <a href="{{ url('/accueil') }}" class="btn btn-outline-primary mt-3">Voir tous les vols</a>
        </div>
    @else
        <p class="text-muted mb-4 small">Il y a <strong>{{ $vols->total() }}</strong> vols correspondants à votre recherche.</p>
        
        <ul class="vol-list p-0">
            @foreach ($vols as $vol)
            <li class="vol-item mb-3 shadow-sm bg-white p-3" style="list-style: none; border-radius: 12px; border-left: 5px solid #007bff;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    
                    <div class="info-vol flex-grow-1">
                        <div class="route h5 fw-bold mb-2">
                            {{ $vol->depart }} 
                            <i class="fas fa-plane mx-3 text-primary"></i> 
                            {{ $vol->destination }}
                        </div>
                        
                        <div class="details-time d-flex gap-4 text-muted small">
                            <span><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y') }}</span>
                            <span><i class="far fa-clock me-1"></i> {{ $vol->heure_depart }}</span>
                            <span class="fw-bold text-success">{{ number_format($vol->prix, 2) }} €</span>
                        </div>
                    </div>

                    <div class="actions d-flex gap-2">
                        <a href="{{ url('/reserver/' . $vol->id) }}" class="btn btn-primary btn-sm px-3">
                            <i class="fas fa-ticket-alt me-1"></i> Réserver
                        </a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVol{{ $vol->id }}">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>

                @include('partials.vol_modal', ['vol' => $vol]) 
            </li>
            @endforeach
        </ul>

        <div class="d-flex justify-content-center mt-5">
            {{ $vols->links() }}
        </div>
    @endif
</div>
@endsection