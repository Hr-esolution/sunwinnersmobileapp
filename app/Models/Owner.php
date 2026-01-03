<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name', 'license_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}