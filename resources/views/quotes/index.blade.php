@extends('layouts.app')

@section('title', 'Gestion des devis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Gestion des devis</h1>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nouveau devis
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
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotes ?? [] as $quote)
                                <tr>
                                    <td>{{ $quote->id }}</td>
                                    <td>{{ $quote->number }}</td>
                                    <td>{{ $quote->client_name }}</td>
                                    <td>{{ $quote->date->format('d/m/Y') ?? $quote->created_at->format('d/m/Y') }}</td>
                                    <td>{{ number_format($quote->amount ?? 0, 2, ',', ' ') }} €</td>
                                    <td>
                                        <span class="badge bg-{{ $quote->status === 'accepted' ? 'success' : ($quote->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('quotes.show', $quote->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('quotes.edit', $quote->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun devis trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $quotes->links() ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection