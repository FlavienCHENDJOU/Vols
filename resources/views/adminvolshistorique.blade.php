@extends('layouts/admin')

@section('title', 'Gestion des Vols')

@section('content')
<h2 class="fw-bold"><i class="fas fa-history me-2"></i> Historique des Vols</h2>
<table class="table">
    <thead>
        <tr>
            <th>Vol</th>
            <th>Date</th>
            <th>Raison Archive</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vols as $vol)
        <tr class="table-secondary">
            <td>{{ $vol->depart }} -> {{ $vol->destination }}</td>
            <td>{{ \Carbon\Carbon::parse($vol->date_depart)->format('d/m/Y') }}</td>
            <td>
                @if($vol->places_disponibles <= 0)
                    <span class="badge bg-danger">Complet</span>
                @else
                    <span class="badge bg-dark">Terminé</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection