
@extends('layouts/app')

@section('title', 'Mon Espace Personnel | ' . $user->prenom)

@section('content')

<div class="profile-header shadow">
    <div class="profile-avatar-wrapper">
        <div class="avatar-circle position-relative">
            <img id="avatar-preview" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/default-avatar.png') }}" 
                 style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            
            <label for="photo-upload" class="photo-change-overlay">
                <img src="{{ asset('img/edit.png') }}" alt="Changer la photo" class="icon-change">
            </label>

            <form id="photo-form" action="{{ url('/profil/update-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="photo-upload" name="photo" accept="image/*" style="display: none;" onchange="previewAndSubmit(this)">
            </form>
        </div>
        
        <div class="user-welcome">
            <h2 class="mb-0 text-white text-shadow">{{ $user->prenom }} {{ $user->nom }}</h2>
            <span class="badge-status bg-white mt-1 d-inline-block">
                <i class="fas fa-star me-1" style="color: #ff5733;"></i> Membre {{ $user->statut }}
            </span>
        </div>
    </div>
</div>
    
<div class="row">
    <div class="col-lg-4">
        <h5 class="fw-bold mb-3">Tableau de bord</h5>
        <div class="row mb-4">
            <div class="col-6">
                <div class="stat-card">
                    <i class="fas fa-plane-departure stat-icon"></i>
                    <div class="h5 mb-0">{{ $nbRes }}</div>
                    <div class="small text-muted">Vols</div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-card">
                    <i class="fas fa-coins stat-icon"></i>
                    <div class="h5 mb-0">{{$nbrpoints}} </div>
                    <div class="small text-muted">Points</div>
                </div>
            </div>
        </div>

        <div id="sideCarousel" class="carousel slide mb-4 shadow-sm" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4">
                <div class="carousel-item active">
                    <img src="{{ asset('img/image1.jpeg') }}" class="d-block w-100" alt="Promo">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/image2.jpeg') }}" class="d-block w-100" alt="Destinations">
                    <div class="carousel-caption d-none d-md-block bg-dark-50 rounded">
                        <p class="mb-0">Les meilleurs hôtels</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
    <div class="col-lg-8">
        <div class="card main-card">
            <div class="card-body p-4">
                <h5 class="mb-4"><i class="fas fa-user-edit me-2 text-primary"></i> Informations personnelles</h5>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="main-profile-form" method="POST" action="{{ url('/infoUtilisateur/update') }}">
                    @csrf
                    <div class="row g-3">
                       <div class="col-md-6">
                            <label class="form-label small fw-bold">Nom</label>
                            <div class="input-group">
                                <input name="nom" id="input-nom" value="{{ $user->nom }}" class="form-control" readonly required>
                                <span class="input-group-text bg-white" onclick="enableInput('input-nom')" style="cursor:pointer">
                                    <img src="{{ asset('img/edit.png') }}" style="width: 20px;">
                                </span>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <label class="form-label small fw-bold">Prénom</label>
                            <div class="input-group">
                                <input name="prenom" id="input-prenom" value="{{ $user->prenom }}" class="form-control" readonly required>
                                <span class="input-group-text bg-white" onclick="enableInput('input-prenom')" style="cursor:pointer">
                                    <img src="{{ asset('img/edit.png') }}" style="width: 20px;">
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Adresse E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="far fa-envelope text-muted"></i></span>
                                <input name="email" id="input-email" type="email" value="{{ $user->email }}" class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Mots de passe</label>
                            <div class="input-group">
                                <input name="password" id="input-password" type="password" class="form-control" placeholder="*******" readonly >
                                <span class="input-group-text bg-white" onclick="enableInput('input-password')" style="cursor:pointer">
                                    <img src="{{ asset('img/edit.png') }}" style="width: 20px;">
                                </span>
                            </div>
                            <div class="form-text text-muted">Minimum 6 caractères si vous modifiez.</div>
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <div id="password-confirm-section" class="mt-4 p-3 border rounded bg-light" style="display: none;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-shield-alt text-danger me-2"></i>
                            <span class="fw-bold small">Confirmation de sécurité</span>
                        </div>
                        <p class="text-muted small mb-2">Veuillez saisir votre mot de passe actuel pour valider les changements.</p>
                        <input type="password" id="current_password" name="current_password" class="form-control form-control-sm" placeholder="Mot de passe actuel">
                    </div>

                    <div class="text-end mt-3">
                        <button type="button" id="btn-submit-form" class="btn btn-update px-5">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  let hasChanged = false; 

// Surveiller les changements manuels dans les champs
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('input', () => {
        hasChanged = true;
    });
});

function enableInput(inputId) {
    const input = document.getElementById(inputId);
    input.removeAttribute('readonly');
    input.focus();
    input.style.backgroundColor = "#fff";
    input.style.border = "1px solid #ff5733";

    if (inputId === 'input-password') {
        input.value = '';
    }
    hasChanged = true; 
}

function previewAndSubmit(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result; 
            document.getElementById('photo-form').submit();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('btn-submit-form').addEventListener('click', function() {
    const confirmSection = document.getElementById('password-confirm-section');
    const currentPwdInput = document.getElementById('current_password');

    if (!hasChanged) {
        alert("Aucune modification détectée ! ✈️");
        return;
    }

    if (confirmSection.style.display === 'none') {
        confirmSection.style.display = 'block';
        currentPwdInput.focus();
    } else {
        if (currentPwdInput.value.trim() !== "") {
            document.getElementById('main-profile-form').submit();
        } else {
            currentPwdInput.classList.add('is-invalid');
            currentPwdInput.focus();
        }
    }
});
</script>

@endsection
