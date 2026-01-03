<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_demandeur', // 'personne' ou 'societe'
        'date',
        'reference',
        'type_demande', // 'nouvelle installation', 'extension et mise à niveau', 'entretien et réparation'
        'objectif', // 'réduction de consommation', 'stockage d\'énergie', 'extension future prévue'
        'type_installation', // Voir les types d'installation
        'type_pompe', // 'surface' ou 'immergée' (si applicable)
        'debit_estime', // m3/ha (si applicable)
        'profondeur_forage', // (si applicable)
        'capacite_reservoir', // (si applicable)
        'adresse_complete',
        'toit_installation',
        'images', // JSON pour stocker plusieurs fichiers
        'type_utilisation', // 'domestique', 'industrielle', 'agricole'
        'status',
        'technician_id',
    ];

    protected $casts = [
        'date' => 'date',
        'images' => 'array',
        'type_utilisation' => 'string',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'devis_technician');
    }

    public function composants()
    {
        return $this->belongsToMany(Composant::class, 'devis_composants')
                    ->withPivot('quantity', 'technician_id');
    }

    public static function generateReferenceDevis()
    {
        $date = now()->format('Ymd');
        $id = self::max('id') + 1;
        do {
            $reference = 'DV-' . $date . '-' . str_pad($id, 5, '0', STR_PAD_LEFT);
            $id++;
        } while (self::where('reference', $reference)->exists());
        return $reference;
    }

    protected static function booted()
    {
        static::creating(function ($devis) {
            $devis->reference = $devis->reference ?? self::generateReferenceDevis();
            $devis->date = $devis->date ?? now();
        });
    }
    
    public function responses()
    {
        return $this->hasMany(DevisResponse::class);
    }
}