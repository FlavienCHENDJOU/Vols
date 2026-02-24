@extends('layouts/admin')

@section('title', 'Gestion des Vols')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-plane me-2 text-primary"></i> Gestion des Vols</h2>
        @can('creer-vols')
            <button type="button" class="btn btn-update-premium" data-bs-toggle="modal" data-bs-target="#addVolModal">
                <i class="fas fa-plus-circle me-2"></i> AJOUTER UN NOUVEAU VOL
            </button>
        @endcan
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
                            <th class="px-4 py-3">N° Vol</th>
                            <th class="py-3">Départ</th>
                            <th class="py-3">Arrivée</th>
                            <th class="py-3">Date & Heure</th>
                            <th class="py-3">Places</th>
                            <th class="py-3">Prix</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                     
                    <tbody>
                        @foreach($vols as $vol) 
                        <tr>
                            <td class="px-4 text-muted">
                                #{{ ($vols->currentPage() - 1) * $vols->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $vol->depart }}</td>
                            <td>{{ $vol->destination }}</td>
                            <td>{{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $vol->places_disponibles > 10 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $vol->places_disponibles }}
                                </span>
                            </td>
                            <td class="fw-bold text-nowrap">{{ number_format($vol->prix, 2) }} €</td>
                            <td class="text-end px-4">
                                {{-- CORRECTION : Ajout du @ devant can --}}
                                @can('modifier-vols')
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editVolModal{{ $vol->id }}" class="me-2 text-decoration-none">
                                        <img src="{{ asset('img/edit.png') }}" alt="Modifier" style="width: 22px;"> 
                                    </a>
                                @endcan

                                @can('supprimer-vols')
                                    <a href="{{ url('/admin/vols/supprimer/'.$vol->id) }}" 
                                        onclick="return confirm('⚠️ Supprimer ce vol ?')">
                                        <img src="{{ asset('img/delete.png') }}" alt="Supprimer" style="width: 22px;">
                                    </a>
                                @endcan
                            </td>
                        </tr>
                         @can('modifier-vols')
                        <div class="modal fade" id="editVolModal{{ $vol->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Modifier le Vol #{{ $vol->id }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ url('/admin/vols/modifier/'.$vol->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Départ</label>
                                                    <input type="text" name="depart" class="form-control" value="{{ $vol->depart }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Destination</label>
                                                    <input type="text" name="destination" class="form-control" value="{{ $vol->destination }}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Date et Heure de départ</label>
                                                    <input type="datetime-local" name="date_depart" class="form-control" 
                                                        value="{{ \Carbon\Carbon::parse($vol->date_depart)->format('Y-m-d\TH:i') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Prix (€)</label>
                                                    <input type="number" name="prix" class="form-control" value="{{ $vol->prix }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Places</label>
                                                    <input type="number" name="places_disponibles" class="form-control" value="{{ $vol->places_disponibles }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $vols->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addVolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Nouveau Vol</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/vols/ajouter') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        @php
                            $prochainID = \App\Models\Vol::max('id') + 1;
                        @endphp

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Numéro de vol (Auto)</label>
                            <input type="text" name="numero_vol" class="form-control bg-light" value="{{ $prochainID }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Prix (€)</label>
                            <input type="number" name="prix" class="form-control" placeholder="150" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Ville de départ</label>
                            <input type="text" name="ville_depart" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Ville d'arrivée</label>
                            <input type="text" name="ville_arrivee" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Date de départ</label>
                            <input type="datetime-local" name="date_depart" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Places totales</label>
                            <input type="number" name="places_disponibles" class="form-control" value="100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-update-premium" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-update-premium">Enregistrer le vol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const myModal = document.getElementById('addVolModal');
        myModal.addEventListener('shown.bs.modal', function () {
            const firstInput = myModal.querySelector('input[name="numero_vol"]');
            firstInput.focus();
        });

         const deleteButtons = document.querySelectorAll('.btn-outline-danger');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('⚠️ Attention : La suppression de ce vol entraînera l\'annulation de toutes les réservations associées. Continuer ?')) {
                    e.preventDefault();
                }
            });
        });

         const alerts = document.querySelectorAll('.alert-success');
        alerts.forEach(alert => {
            setTimeout(() => {
                 if (window.bootstrap) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } else {
                    alert.style.display = 'none';
                }
            }, 4000);
        });
        
    });
</script>
@endsection

