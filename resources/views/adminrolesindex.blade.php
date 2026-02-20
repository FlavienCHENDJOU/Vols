@extends('layouts/admin')

@section('title', 'Gestion des Rôles')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Configuration des Accès</h2>
        {{-- Protection du bouton de création --}}
        @can('gerer-roles-permissions')
        <a href="{{ route('roles.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white me-2"></i>Nouveau Rôle
        </a>
        @endcan
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Rôles et Privilèges</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom du Rôle</th>
                            <th>Permissions assignées</th>
                            <th>Propriétaire / Créateur</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td class="fw-bold">
                                <span class="badge {{ $role->name === 'super_admin' ? 'bg-danger' : 'bg-dark' }}">
                                    {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                                </span>
                            </td>
                            <td style="max-width: 400px;">
                                @foreach($role->permissions as $permission)
                                    <span class="badge border text-dark fw-normal bg-light mb-1">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        {{ str_replace('-', ' ', $permission->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                @if($role->name === 'super_admin')
                                    <span class="text-primary fw-bold"> <i class="fas fa-shield-alt me-1"></i> Système</span>
                                @else
                                    <small class="text-muted">
                                        <i class="fas fa-user-circle me-1"></i>
                                        @if($role->created_by == auth()->id())
                                            {{ $allUsers[$role->created_by]->prenom }} {{ $allUsers[$role->created_by]->nom }} 
                                            <strong>(Moi #{{ auth()->id() }})</strong>
                                        @elseif(isset($allUsers[$role->created_by]))
                                            {{ $allUsers[$role->created_by]->prenom }} {{ $allUsers[$role->created_by]->nom }} 
                                            <span class="text-secondary">(#{{ $role->created_by }})</span>
                                        @else
                                           @if($mainAdmin)
                                                {{ $mainAdmin->prenom }} {{ $mainAdmin->nom }} 
                                                <span class="text-secondary">(#{{ $mainAdmin->id }})</span>
                                            @else
                                                Admin Système <span class="text-secondary">(#1)</span>
                                            @endif
                                        @endif
                                    </small>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($role->name !== 'super_admin' && (auth()->user()->hasRole('super_admin') || $role->created_by == auth()->id()))
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info text-white" title="Modifier les privilèges">
                                            <i class="fas fa-user-lock"></i> Privilèges
                                        </a>

                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Attention ! Supprimer ce rôle retirera les accès à tous les utilisateurs concernés. Continuer ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge bg-secondary opacity-50"><i class="fas fa-lock"></i> Verrouillé</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                                Aucun rôle n'est disponible pour votre niveau d'accès.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection