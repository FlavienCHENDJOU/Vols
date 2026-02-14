<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vols Disponibles - AeroFlight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #1e293b;
            margin: 0;
            font-weight: 600;
        }

        .btn-back {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }
        .btn-back:hover { color: #ff5733; }
        .btn-back i { margin-right: 8px; }

        ul { list-style: none; padding: 0; }

        li {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(0,0,0,0.03);
        }

        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .info-vol { flex: 1; }

        .route {
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .route i {
            margin: 0 15px;
            color: #cbd5e1;
            font-size: 0.9rem;
        }

        .details-time {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .details-time i { color: #ff5733; width: 20px; }

        .actions { display: flex; gap: 10px; }

        .btn {
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-reserve {
            background-color: #ff5733;
            color: white;
            box-shadow: 0 4px 12px rgba(255, 87, 51, 0.2);
        }
        .btn-reserve:hover { background-color: #e64a19; }

        .btn-details {
            background-color: #f1f5f9;
            color: #475569;
        }
        .btn-details:hover { background-color: #e2e8f0; }

        .img-container {
            width: 150px;
            height: 100px;
            overflow: hidden;
            border-radius: 15px;
            margin-left: 20px;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 600px) {
            li { flex-direction: column; text-align: center; }
            .img-container { margin: 20px 0; width: 100%; }
            .route { justify-content: center; }
        }
    </style>
</head>
<body  id="booking">

    <div class="container">
        <div class="header-section">
            <a href="{{ url('/infoUtilisateur') }}" class="btn-back">
                 <i class="fas fa-arrow-left"></i> 
                 Retour au profil
            </a>
            <h1>Vols disponibles</h1>
        </div>

            <ul>
                 @foreach ($vols as $vol)
                <li>
                    <div class="info-vol">
                        <div class="route">
                            {{ $vol->depart }} 
                            <i class="fas fa-plane"></i> 
                            {{ $vol->destination }}
                        </div>
                        
                        <div class="details-time">
                            <div><i class="far fa-calendar-alt"></i> {{ $vol->date_depart }}</div>
                            <div><i class="far fa-clock"></i> {{ $vol->heure_depart }}</div>
                        </div>

                        <div class="actions">
                            <a href="{{ url('/reserver/' . $vol->id) }}" class="btn btn-reserve">
                                <i class="fas fa-ticket-alt"></i> Réserver
                            </a>

                            <button type="button" class="btn btn-details" data-toggle="modal" data-target="#modalVol{{ $vol->id }}">
                                <i class="fas fa-info-circle"></i> Détails
                            </button>
                        </div>
                    </div>

                    <div class="img-container">
                        <img src="{{ asset('img/volimage.jpeg') }}" alt="Aperçu vol">
                    </div>

                    <div class="modal fade" id="modalVol{{ $vol->id }}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
                                
                                <div class="modal-header" style="background: #f8f9fa;">
                                    <h5 class="modal-title" style="font-weight: 600;">
                                        <i class="fas fa-plane text-primary mr-2"></i> Fiche du Vol #{{ $vol->id }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body p-4 text-left">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <span class="badge badge-primary">Trajet Officiel</span>
                                                <h4 class="mt-2" style="font-weight: 700;">{{ $vol->depart }} <i class="fas fa-arrow-right mx-2 text-muted"></i> {{ $vol->destination }}</h4>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6 border-right">
                                                    <p class="small text-muted mb-0">Date de départ</p>
                                                    <p><strong>{{ $vol->date_depart }}</strong></p>
                                                </div>
                                                <div class="col-6 pl-4">
                                                    <p class="small text-muted mb-0">Heure locale</p>
                                                    <p><strong>{{ $vol->heure_depart }}</strong></p>
                                                </div>
                                            </div>

                                            <hr>
                                            
                                            <p><i class="fas fa-map-marker-alt text-danger mr-2"></i> <strong>Aéroport :</strong> {{ $vol->pays_depart }}</p>
                                            <p><i class="fas fa-chair text-info mr-2"></i> <strong>Disponibilité :</strong> {{ $vol->places_disponibles }} places</p>
                                            <p><i class="fas fa-building text-warning mr-2"></i> <strong>Compagnie :</strong> {{ $vol->compagnie ?? 'AeroFlight' }}</p>
                                        </div>
                                        
                                        <div class="col-md-5">
                                            <img src="{{ asset('img/volimage.jpeg') }}" class="img-fluid rounded shadow" alt="Vol">
                                            <div class="alert alert-warning mt-3 small">
                                                <i class="fas fa-exclamation-triangle"></i> Réservation non remboursable à moins de 24h.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer" style="background: #f8f9fa;">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px;">Fermer</button>
                                    <a href="{{ url('/reserver/' . $vol->id) }}" class="btn btn-reserve" style="padding: 10px 25px;">
                                        Confirmer la sélection
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    @include('script')
</body>
</html>






