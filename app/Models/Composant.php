<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Composant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'unit_price',
        'technician_id',
        'manufacturer',
        'warranty_period',
        'certifications',
    ];

    // Relation avec le technicien
    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }
    
    public function devis()
    {
        return $this->belongsToMany(Devis::class, 'devis_composants')
            ->withPivot('quantity', 'technician_id')
            ->withTimestamps();
    }
}