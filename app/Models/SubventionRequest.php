<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubventionRequest extends Model
{
    protected $fillable = [
        'nom_projet',
        'type_projet',
        'nom',
        'adresse',
        'telephone',
        'representant',
        'email',
        'secteur',
        'type_entreprise',
        'taille_entreprise',
        'description_projet',
        'adresse_projet',
        'date_debut',
        'eligibilite',
        'signataire_nom',
        'signataire_fonction',
        'signataire_signature',
        'signataire_lieu_date',
        'statut',
    ];

    protected $casts = [
        'eligibilite' => 'array',
        'date_debut' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}