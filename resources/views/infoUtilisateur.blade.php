
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mon Espace Personnel | {{ $user->prenom }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .profile-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            height: 200px;
            margin-bottom: 80px;
            position: relative;
        }

        .profile-avatar-wrapper {
            position: absolute;
            bottom: -50px;
            left: 50px;
            display: flex;
            align-items: flex-end;
        }

        .avatar-circle {
            width: 120px;
            height: 120px;
            background: #ff5733;
            border: 5px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .user-welcome {
            margin-left: 20px;
            color: white;
            padding-bottom: 10px;
        }

        .stat-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon { color: #ff5733; font-size: 1.5rem; margin-bottom: 10px; }

        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: white;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            transition: 0.3s;
        }
        .form-control:focus {
            border-color: #ff5733;
            box-shadow: 0 0 0 3px rgba(255, 87, 51, 0.1);
        }

        .btn-update {
            background: #ff5733;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(255, 87, 51, 0.3);
        }
        .btn-update:hover {
            background: #e64a19;
            transform: scale(1.02);
            color: white;
        }

        .sidebar-title { font-weight: 600; color: #1e293b; margin-bottom: 20px; }
        .badge-status {
            background: rgba(255, 87, 51, 0.1);
            color: #ff5733;
            border: 1px solid #ff5733;
            padding: 5px 15px;
            border-radius: 20px;
        }

        .carousel-inner { border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    @include('navbar')

    <div class="profile-header">
        <div class="profile-avatar-wrapper">
            <div class="avatar-circle">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-welcome">
                <h2 class="mb-0">{{ $user->prenom }} {{ $user->nom }}</h2>
                <span class="badge-status"><i class="fas fa-star mr-1"></i> Membre {{ $user->statut }}</span>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-lg-4">
                <h5 class="sidebar-title">Tableau de bord</h5>
                <div class="row mb-4">
                    <div class="col-6">
                        <div class="stat-card">
                            <i class="fas fa-plane-departure stat-icon"></i>
                            <div class="h5 mb-0">12</div>
                            <div class="small text-muted">Vols</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <i class="fas fa-coins stat-icon"></i>
                            <div class="h5 mb-0">450</div>
                            <div class="small text-muted">Points</div>
                        </div>
                    </div>
                </div>

                <div id="sideCarousel" class="carousel slide mb-4" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('img/image1.jpeg') }}" class="d-block w-100" alt="Promo">
                            
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/image2.jpeg') }}" class="d-block w-100" alt="Destinations">
                            <P>les meilleurs hotels</P>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card main-card">
                    <div class="card-body p-4">
                        <h5 class="mb-4"><i class="fas fa-user-edit mr-2 text-primary"></i> Informations personnelles</h5>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/infoUtilisateur/update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Nom</label>
                                    <input name="nom" value="{{ $user->nom }}" class="form-control" placeholder="Votre nom" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Prénom</label>
                                    <input name="prenom" value="{{ $user->prenom }}" class="form-control" placeholder="Votre prénom" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Adresse E-mail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="far fa-envelope text-muted"></i></span>
                                    </div>
                                    <input name="email" value="{{ $user->email }}" class="form-control border-left-0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Sécurité du compte</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-lock text-muted"></i></span>
                                    </div>
                                    <input name="password" type="password" class="form-control border-left-0" placeholder="Laissez vide pour conserver l'actuel">
                                </div>
                                <small class="text-muted">Minimum 6 caractères si vous modifiez.</small>
                            </div>

                            <hr class="my-4">
                            
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-update">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    <script>
    const form = document.querySelector('form'); 
    const btn = form.querySelector('button[type="submit"]');
    const inputs = form.querySelectorAll('input[required], select[required]');

    function checkInputs() {
        let allFilled = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                allFilled = false;
            }
        });
        btn.disabled = !allFilled;
        btn.style.opacity = allFilled ? "1" : "0.5";
        btn.style.cursor = allFilled ? "pointer" : "not-allowed";
    }

    inputs.forEach(input => {
        input.addEventListener('input', checkInputs);
    });
    checkInputs();
</script>
</body>
</html>