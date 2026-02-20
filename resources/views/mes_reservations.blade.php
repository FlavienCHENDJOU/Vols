@extends($layout)

@section('title', 'Mes Billets | AeroFlight')

@section('content')

<link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />

<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <h1 class="page-title m-0">
            <i class="fas fa-plane-departure me-3 text-primary"></i>Mes Voyages
        </h1>
    </div>

    @if($reservations->isEmpty())
        <div class="empty-state">
            <i class="fas fa-ticket-alt fa-4x text-muted mb-4"></i>
            <h3 class="fw-bold">Aucun voyage prévu</h3>
            <p class="text-muted">Vous n'avez pas encore de réservation active.</p>
            <a href="{{ url('/vols_disponible') }}" class="btn btn-primary btn-lg rounded-pill px-4 mt-3">
                Découvrir nos vols
            </a>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @foreach($reservations as $res)
                <div class="ticket">
                    <div class="ticket-left">
                        <div class="badge bg-soft-primary text-primary mb-2 px-3">Billet #{{ $res->id }}</div>
                        <div class="route-info">
                            Vol #{{ $res->vol_id }} — Classe {{ $res->classe ?? 'Éco' }}
                        </div>
                        <div class="passenger-details">
                            <div class="mb-1"><i class="fas fa-user"></i> <strong>Passager :</strong> {{ $res->nom }} {{ $res->prenom }}</div>
                            <div><i class="fas fa-chair"></i> <strong>Sièges :</strong> {{ $res->nombre_places }} place(s)</div>
                        </div>
                    </div>
                    <div class="ticket-right">
                        <div class="small text-uppercase opacity-75 mb-1" style="letter-spacing: 1px;">Statut</div>
                        <div class="fw-bold text-warning">CONFIRMÉ</div>
                        <a href="{{ url('/confirmation/' . $res->id) }}" class="btn-view-ticket">
                            <i class="fas fa-search-plus me-1"></i> Détails
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection