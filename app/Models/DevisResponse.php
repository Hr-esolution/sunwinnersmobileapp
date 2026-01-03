<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'devis_id',
        'technician_id',
        'commentaire',
        'prix_total',
        'statut',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function composants()
    {
        return $this->belongsToMany(Composant::class, 'devis_response_composant')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Relation projet, filtrée par devis_id ET technician_id
    public function project()
    {
        return $this->hasOne(Project::class, 'devis_id', 'devis_id')
                    ->where('technician_id', $this->technician_id);
    }
}