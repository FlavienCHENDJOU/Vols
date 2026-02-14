<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Finaliser ma Réservation | AeroFlight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    
    <style>
        body {
            font-family: 'Poppins', sans-serif; 
            background-image: url("{{ asset('/img/01.jpg') }}");         
            color: #333;
            margin: 0;
            padding: 20px;

        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .flight-summary {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .flight-summary h2 { margin: 0 0 10px 0; font-weight: 600; }
        .route-info { font-size: 1.2rem; display: flex; justify-content: center; align-items: center; gap: 20px; }
        .route-info i { color: #ff5733; }

        .booking-form { padding: 40px; }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            border-left: 4px solid #ff5733;
            padding-left: 15px;
        }

        .form-group { margin-bottom: 20px; }
        
        label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem; color: #64748b; }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-family: inherit;
            box-sizing: border-box; 
            transition: 0.3s;
        }

        input:focus { outline: none; border-color: #ff5733; box-shadow: 0 0 0 3px rgba(255, 87, 51, 0.1); }

      
        .custom-radio-group { display: flex; gap: 15px; flex-wrap: wrap; margin-top: 10px; }
        
        .custom-radio-group label {
            flex: 1;
            min-width: 120px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 0;
        }

        .custom-radio-group input { display: none; }

        .custom-radio-group label:hover { border-color: #cbd5e1; }

        .custom-radio-group input:checked + span { color: #ff5733; font-weight: 600; }
        .custom-radio-group input:checked + label, 
        .custom-radio-group label.active {
            border-color: #ff5733;
            background: rgba(255, 87, 51, 0.05);
        }

        .payment-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .payment-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }
        .payment-card img { height: 30px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
        .payment-card input { display: none; }
        
        .payment-card:has(input:checked) { border-color: #ff5733; background: #fffcfb; }

        button.btn-submit {
            background: #ff5733;
            color: white;
            border: none;
            padding: 18px;
            width: 100%;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(255, 87, 51, 0.2);
            margin-top: 20px;
        }

        button.btn-submit:hover { background: #e64a19; transform: translateY(-2px); }

        .info-alert {
            background: #fff9f0;
            border: 1px solid #ffedda;
            padding: 15px;
            border-radius: 10px;
            color: #b45309;
            font-size: 0.85rem;
            margin-bottom: 30px;
        }
        .alert-danger {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .alert-danger ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body id="booking">

<div class="container">
    <div class="flight-summary">
        <h2><i class="fas fa-ticket-alt"></i> Confirmation de vol</h2>
        <div class="route-info">
            <span>{{ $vol->depart }}</span>
            <i class="fas fa-plane"></i>
            <span>{{ $vol->destination }}</span>
        </div>
        <p style="margin-top:10px; opacity: 0.8; font-size: 0.9rem;">
            Vol n°{{ $vol->id }} | Départ le {{ $vol->date_depart }} à {{ $vol->heure_depart }}
        </p>
    </div>

    <div class="booking-form">
        <div class="info-alert">
            <i class="fas fa-info-circle"></i> Veuillez remplir tous les champs obligatoires pour finaliser votre réservation en toute sécurité.
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
               <ul>
                   @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('/form-reserver') }}" method="POST">
            @csrf
            <input type="hidden" name="vol_id" value="{{ $vol->id }}">

            <div class="section-title">Informations Passager</div>
            
            <div class="row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="nom"">Nom</label>
                    <input type="text" id="nom" name="nom"  required  value="{{old('nom')}}">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom"  required  value="{{old('prenom')}}">
                </div>
            </div>

            <div class="row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="email">Email professionnel ou privé</label>
                    <input type="email" id="email" name="email" placeholder="monemail@mail.com" required  value="{{old('email')}}">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" placeholder="+237 *********" required  value="{{old('telephone')}}">
                </div>
            </div>

            <div class="section-title">Options de Voyage</div>

            <div class="form-group">
                <label>Classe de voyage</label>
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

            <div class="form-group">
                <label for="nombre_places">Nombre de voyageurs</label>
                <input type="number" id="nombre_places" name="nombre_places"  required>
            </div>

            <div class="section-title">Paiement Sécurisé</div>
            
            <div class="payment-grid">
                <label class="payment-card">
                    <input type="radio" name="paiement" value="Orange Money" required>
                    <img src="{{ asset('img/orange.png') }}" alt="Orange">
                    <span class="small">Orange Money</span>
                </label>
                <label class="payment-card">
                    <input type="radio" name="paiement" value="Mobile Money">
                    <img src="{{ asset('img/mobile.png') }}" alt="MTN">
                    <span class="small">MTN Money</span>
                </label>
                <label class="payment-card">
                    <input type="radio" name="paiement" value="Carte Bancaire">
                    <img src="{{ asset('img/carte.jpeg') }}" alt="CB">
                    <span class="small">Carte Bancaire</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Confirmer ma réservation <i class="fas fa-chevron-right" style="margin-left: 10px;"></i>
            </button>
        </form>
    </div>
</div>

</body>
</html>