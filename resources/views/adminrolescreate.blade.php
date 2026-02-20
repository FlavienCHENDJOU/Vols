@extends('layouts/admin')

@section('title', 'Créer un Nouveau Rôle')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Configuration du nouveau rôle</h6>
            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-light">Retour</a>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Nom du Rôle</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Ex: Gestionnaire de Vols Junior" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <h5 class="mb-3 text-secondary"><i class="fas fa-key me-2"></i>Définir les Permissions</h5>

                <div class="row">
                  @php
                        $userConnecte = auth()->user();
                        $allGroups = [
                            'Vols' => ['voir-vols', 'creer-vols', 'modifier-vols', 'supprimer-vols'],
                            'Réservations' => ['voir-reservations', 'annuler-reservations'],
                            'Utilisateurs & Rôles' => ['voir-utilisateurs', 'gerer-roles-permissions', 'supprimer-utilisateurs']
                        ];

                        $groups = [];
                        foreach($allGroups as $nomGroupe => $permsDuGroupe) {
                            if($userConnecte->hasRole('super_admin')) {
                                $groups[$nomGroupe] = $permsDuGroupe;
                            } else {
                                $permsAutorisees = array_filter($permsDuGroupe, function($p) use ($userConnecte) {
                                    return $userConnecte->hasPermissionTo($p);
                                });

                                if(!empty($permsAutorisees)) {
                                    $groups[$nomGroupe] = $permsAutorisees;
                                }
                            }
                        }
                    @endphp

                    @foreach($groups as $groupName => $groupPermissions)
                        <div class="col-md-4 mb-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-folder me-2"></i>{{ $groupName }}
                                </h6>
                                
                                @foreach($groupPermissions as $permName)
                                    @php $permission = $permissions->where('name', $permName)->first(); @endphp
                                    
                                    @if($permission)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                   value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ ucfirst(str_replace('-', ' ', $permName)) }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 text-end">
                    <button type="reset" class="btn btn-secondary px-4">Réinitialiser</button>
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i>Enregistrer le Rôle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection