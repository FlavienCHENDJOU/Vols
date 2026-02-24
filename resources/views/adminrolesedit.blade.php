@extends('layouts/admin')

@section('title', 'Modifier les Privilèges')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-dark text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-user-shield me-2"></i>Modifier le rôle : {{ $role->name }}
            </h6>
            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-light">Retour</a>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Nom du Rôle</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" readonly>
                    <small class="text-muted italic">Note : Le nom du rôle ne peut pas être modifié pour des raisons de sécurité.</small>
                </div>

                <hr>
                <h5 class="mb-3 text-primary"><i class="fas fa-key me-2"></i>Mise à jour des Permissions</h5>

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
                                // On ne montre que ce que l'admin actuel a le droit de gérer
                                $permsAutorisees = array_filter($permsDuGroupe, function($p) use ($userConnecte) {
                                    return $userConnecte->hasPermissionTo($p);
                                });
                                if(!empty($permsAutorisees)) {
                                    $groups[$nomGroupe] = $permsAutorisees;
                                }
                            }
                        }
                    @endphp

                    @forelse($groups as $groupName => $groupPermissions)
                        <div class="col-md-4 mb-4">
                            <div class="border rounded p-3 bg-light h-100 shadow-sm">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                    {{ $groupName }}
                                </h6>
                                
                                @foreach($groupPermissions as $permName)
                                    @php $permission = $permissions->where('name', $permName)->first(); @endphp
                                    
                                    @if($permission)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                   value="{{ $permission->name }}" 
                                                   id="perm_{{ $permission->id }}"
                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ ucfirst(str_replace('-', ' ', $permName)) }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                Vous n'avez aucune permission que vous pouvez déléguer.
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4">Annuler</a>
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fas fa-check-circle me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection