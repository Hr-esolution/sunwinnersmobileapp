<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'devis_id',
        'technician_id',
        'status',
        'is_active',
        'contrat_signed_file',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function isActiveLabel()
    {
        return $this->is_active ? 'Actif' : 'Inactif';
    }

    public function subvention()
    {
        return $this->hasOne(SubventionRequest::class);
    }
}