@extends('layouts.app')

@section('title', 'Gestion des subventions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Gestion des subventions</h1>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('subsidies.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nouvelle subvention
                </a>
                
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Rechercher..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">Rechercher</button>
                </form>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Organisme</th>
                                    <th>Montant</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subsidies ?? [] as $subsidy)
                                <tr>
                                    <td>{{ $subsidy->id }}</td>
                                    <td>{{ $subsidy->title }}</td>
                                    <td>{{ $subsidy->organization }}</td>
                                    <td>{{ number_format($subsidy->amount ?? 0, 2, ',', ' ') }} €</td>
                                    <td>{{ $subsidy->start_date->format('d/m/Y') ?? 'Non définie' }}</td>
                                    <td>{{ $subsidy->end_date->format('d/m/Y') ?? 'Non définie' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $subsidy->status === 'approved' ? 'success' : ($subsidy->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ $subsidy->status === 'approved' ? 'Approuvée' : ($subsidy->status === 'pending' ? 'En attente' : 'Rejetée') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('subsidies.show', $subsidy->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('subsidies.edit', $subsidy->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('subsidies.destroy', $subsidy->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette subvention ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucune subvention trouvée</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $subsidies->links() ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection