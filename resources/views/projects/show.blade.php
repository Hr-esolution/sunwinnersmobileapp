@extends('layouts.app')

@section('title', 'Détails du projet')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Détails du projet</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du projet</h6>
                    <div>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nom</label>
                                <p class="mb-0">{{ $project->name }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Client</label>
                                <p class="mb-0">{{ $project->client_name }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de début</label>
                                <p class="mb-0">{{ $project->start_date?->format('d/m/Y') ?? 'Non définie' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de fin</label>
                                <p class="mb-0">{{ $project->end_date?->format('d/m/Y') ?? 'Non définie' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Statut</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'in_progress' ? 'primary' : 'secondary') }}">
                                        {{ $project->status === 'in_progress' ? 'En cours' : ($project->status === 'completed' ? 'Terminé' : 'En attente') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Budget</label>
                                <p class="mb-0">{{ $project->budget ? number_format($project->budget, 2, ',', ' ') . ' €' : 'Non défini' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <p class="mb-0">{{ $project->description ?? 'Aucune description fournie' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection