@extends('layouts.app')

@section('title', 'Détails du devis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Détails du devis</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du devis</h6>
                    <div>
                        <a href="{{ route('quotes.edit', $quote->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <a href="{{ route('quotes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Numéro</label>
                                <p class="mb-0">{{ $quote->number }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date</label>
                                <p class="mb-0">{{ $quote->date?->format('d/m/Y') ?? $quote->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Client</label>
                                <p class="mb-0">{{ $quote->client_name }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email du client</label>
                                <p class="mb-0">{{ $quote->client_email ?? 'Non fourni' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montant</label>
                                <p class="mb-0">{{ number_format($quote->amount ?? 0, 2, ',', ' ') }} €</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Statut</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $quote->status === 'accepted' ? 'success' : ($quote->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <p class="mb-0">{{ $quote->description ?? 'Aucune description fournie' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection