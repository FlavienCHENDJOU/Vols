@extends($layout)

@section('title', 'Finaliser ma Réservation | AeroFlight')

@section('content')
<link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />
 
<div class="booking-wrapper">
    <div class="booking-container animate__animated animate__fadeInUp">
        <div class="flight-summary">
            <h2 class="h4 mb-2"><i class="fas fa-ticket-alt me-2"></i> Confirmation de vol</h2>
            <div class="route-info">
                <span>{{ $vol->depart }}</span>
                <i class="fas fa-plane"></i>
                <span>{{ $vol->destination }}</span>
            </div>
            <p class="mb-0 mt-2 opacity-75 small">
                Vol n°{{ $vol->id }} | Départ le {{ $vol->date_depart }} à {{ $vol->heure_depart }}
            </p>
        </div>

        <div class="p-4 p-md-5">
            <div class="info-alert mb-4">
                <i class="fas fa-info-circle me-2"></i> Veuillez remplir vos informations pour finaliser la réservation.
            </div>

            <form action="{{ url('/form-reserver') }}" method="POST">
                @csrf
                <input type="hidden" name="vol_id" value="{{ $vol->id }}">

                <div class="section-title mt-0">Informations Passager</div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Nom</label>
                        <input type="text" name="nom" class="form-control form-control-lg" required value="{{old('nom')}}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Prénom</label>
                        <input type="text" name="prenom" class="form-control form-control-lg" required value="{{old('prenom')}}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Email</label>
                        <input type="email" name="email" class="form-control" value="{{auth()->user()->email}}" readonly required >
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control" placeholder="+237 ..." required value="{{old('telephone')}}">
                    </div>
                </div>

                <div class="section-title">Options de Voyage</div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">Classe de voyage</label>
                    <div class="custom-radio-group">
                        <label>
                            <input type="radio" name="classe" value="Économique" checked required>
                            <span>Économique</span>
                        </label>
                        <label>
                            <input type="radio" name="classe" value="Business">
                            <span>Business</span>
                        </label>
                        <label>
                            <input type="radio" name="classe" value="Première Classe">
                            <span>Première</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">Nombre de voyageurs</label>
                    <input type="number" name="nombre_places" class="form-control w-25" min="1" max="{{ $vol->places_disponibles }}" required>
                </div>

                <div class="section-title">Paiement Sécurisé</div>
                
                <div class="payment-grid mb-5">
                    <label class="payment-card">
                        <input type="radio" name="paiement" value="Orange Money" required>
                        <img src="{{ asset('img/orange.png') }}" alt="Orange">
                        <div class="small fw-bold">Orange</div>
                    </label>
                    <label class="payment-card">
                        <input type="radio" name="paiement" value="Mobile Money">
                        <img src="{{ asset('img/mobile.png') }}" alt="MTN">
                        <div class="small fw-bold">MTN</div>
                    </label>
                    <label class="payment-card">
                        <input type="radio" name="paiement" value="Carte Bancaire">
                        <img src="{{ asset('img/carte.jpeg') }}" alt="CB">
                        <div class="small fw-bold">Carte</div>
                    </label>
                </div>

                <button type="submit" class="btn btn-submit btn-lg">
                    Confirmer ma réservation <i class="fas fa-chevron-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection