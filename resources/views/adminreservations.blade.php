@extends('layouts/admin')

@section('title', 'Gestion des Réservations')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i> Gestion des Réservations</h2>
        <p class="text-muted">Consultez et gérez l'ensemble des billets réservés.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card main-card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Passager</th>
                            <th class="py-3">Vol</th>
                            <th class="py-3">Date Réservation</th>
                            <th class="py-3">Statut</th>
                            @can('annuler-reservation')
                                <th class="py-3 text-end px-4">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $res) 
                        <tr>
                            <td class="px-4 text-muted">
                                #{{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}
                            </td>
                            
                            <td>
                                <div class="fw-bold">{{ $res->prenom }} {{ $res->nom }}</div>
                                <small class="text-muted">{{ $res->email ?? '-' }}</small>
                            </td>

                            <td>
                                <div  class="badge bg-soft-info text-info p-2" style="background: #e0f2fe;">{{ $res->vol->depart ?? '???' }} → {{ $res->vol->destination ?? '???' }}</div>
                                <small class="text-muted">{{ $res->email ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="badge bg-soft-info text-info p-2" style="background: #e0f2fe;">
                                    ✈️ {{ $res->vol->depart ?? '???' }} → {{ $res->vol->destination ?? '???' }}
                                </div>
                                <div class="small mt-1 text-dark">Le {{ \Carbon\Carbon::parse($res->vol->date_depart)->format('d/m/Y') }}</div>
                            </td>
                            <td>{{ $res->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-success">Confirmé</span>
                            </td>
                            @can('annuler-reservation')  
                                <td class="text-end px-4">
                                    <a href="{{ url('/admin/reservations/supprimer/'.$res->id) }}" 
                                    onclick="return confirm('⚠️ Annuler cette réservation définitivement ?')"
                                    title="Annuler la réservation">
                                        <img src="{{ asset('img/delete.png') }}" alt="Annuler" class="img-delete" style="width: 22px;">
                                    </a>
                                </td>
                            @endcan
                        </tr>
                        @endforeach
    
                    </tbody>
                </table>               
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
