@extends('layouts/admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold"><i class="fas fa-users me-2 text-primary"></i> Gestion des Utilisateurs</h2>
        <p class="text-muted">Administrez les accès et les rôles de vos membres.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card main-card shadow-sm border-0">
         <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Utilisateur</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Rôle</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($users as $user) 
                        <tr>
                            <td class="px-4 text-muted">
                                #{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #eef2ff;">
                                        {{ strtoupper(substr($user->prenom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $user->prenom }} {{ $user->nom }}</div>
                                        <small class="text-muted">Inscrit le {{ $user->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->roles->isEmpty())
                                    <span class="badge bg-secondary">User</span>
                                @else
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="text-end px-4">
                                @can('gerer-roles-permissions')
                                    @if($user->id !== Auth::id())
                                        @php
                                            $isTargetSuperAdmin = Auth::user()->hasRole('super_admin');
                                            $isTargetSuperAdmin = $user->hasRole('super_admin');
                                            $targetRole = $user->roles->first();
                                            $isProtected = !$isAuthSuperAdmin && (  $isTargetSuperAdmin || ($targetRole && $targetRole->created_by != Auth::id()));
                                        @endphp
                                        
                                        @if($isProtected)
                                            <span class="badge bg-light text-muted"><i class="fas fa-lock me-1"></i> Protégé (par un Admin)</span>
                                        @else
                                            <form action="{{ url('/admin/users/update-role/'.$user->id) }}" method="POST" class="d-inline-block me-2">
                                                @csrf
                                                <select name="role" class="form-select form-select-sm d-inline-block w-auto border-primary" onchange="this.form.submit()" style="font-size: 0.8rem;">
                                                    <option value="" disabled selected>Attribuer un rôle...</option>
                                                    <option value="client">Rendre user (Aucun)</option>
                                                        @foreach($allRoles as $role)
                                                            @if($role->name !== 'super_admin' || $isAuthSuperAdmin)
                                                                @if($isAuthSuperAdmin || $role->created_by == Auth::id()|| is_null($role->created_by))
                                                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                                    </option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    @endif
                                @endcan

                                @can('supprimer-utilisateurs')
                                    @if($user->id !== Auth::id())
                                        @php
                                            $isAuthSuperAdmin = Auth::user()->hasRole('super_admin');
                                            $isTargetSuperAdmin = $user->hasRole('super_admin');
                                            $targetRole = $user->roles->first();
                                            $isCreatedByMe = $targetRole && $targetRole->created_by == Auth::id();
                                            $isSimpleUser = $user->roles->isEmpty();
                                        @endphp

                                        @if($isAuthSuperAdmin || (!$isTargetSuperAdmin && ($isSimpleUser || $isCreatedByMe)))
                                            <a href="{{ url('/admin/utilisateurs/supprimer/'.$user->id) }}" 
                                            onclick="return confirm('Supprimer cet utilisateur ?')"
                                            title="Supprimer">
                                                <img src="{{ asset('img/delete.png') }}" alt="Supprimer" class="img-delete" style="width: 22px;">
                                            </a>
                                        @endif
                                    @endif
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
   

