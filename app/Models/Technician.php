<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificates',
        'experience',
        'logo',
        'company_name',
        'address',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function devis()
    {
        return $this->belongsToMany(Devis::class, 'devis_technician', 'technician_id', 'devis_id');
    }
    
    public function composants()
    {
        return $this->hasMany(Composant::class, 'technician_id');  // 'technician_id' correspond à la clé étrangère
    }
}