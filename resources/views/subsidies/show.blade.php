@extends('layouts.app')

@section('title', 'Détails de la subvention')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Détails de la subvention</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la subvention</h6>
                    <div>
                        <a href="{{ route('subsidies.edit', $subsidy->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <a href="{{ route('subsidies.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Titre</label>
                                <p class="mb-0">{{ $subsidy->title }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Organisme</label>
                                <p class="mb-0">{{ $subsidy->organization }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montant</label>
                                <p class="mb-0">{{ number_format($subsidy->amount ?? 0, 2, ',', ' ') }} €</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Statut</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $subsidy->status === 'approved' ? 'success' : ($subsidy->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ $subsidy->status === 'approved' ? 'Approuvée' : ($subsidy->status === 'pending' ? 'En attente' : 'Rejetée') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de début</label>
                                <p class="mb-0">{{ $subsidy->start_date?->format('d/m/Y') ?? 'Non définie' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de fin</label>
                                <p class="mb-0">{{ $subsidy->end_date?->format('d/m/Y') ?? 'Non définie' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <p class="mb-0">{{ $subsidy->description ?? 'Aucune description fournie' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection