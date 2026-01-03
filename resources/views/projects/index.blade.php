@extends('layouts.app')

@section('title', 'Gestion des projets')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Gestion des projets</h1>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nouveau projet
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
                                    <th>Nom</th>
                                    <th>Client</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects ?? [] as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->client_name }}</td>
                                    <td>{{ $project->start_date->format('d/m/Y') ?? 'Non définie' }}</td>
                                    <td>{{ $project->end_date->format('d/m/Y') ?? 'Non définie' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'primary' : 'secondary') }}">
                                            {{ $project->status === 'in_progress' ? 'En cours' : ($project->status === 'completed' ? 'Terminé' : 'En attente') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('projects.destroy', $project->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun projet trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $projects->links() ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection