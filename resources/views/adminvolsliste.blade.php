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
    <!-- @can('modifier-vols')
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
    @endcan -->
@endforeach