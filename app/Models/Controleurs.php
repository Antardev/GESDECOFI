<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controleurs extends Model
{
    use HasFactory;
    protected $table = 'controleurs'; // Nom de la table 
    protected $fillable = [
        'user_id',
        'name',
        'firstname',
        'date',
        'country',
        'email',
        'phone',
        'phone_code',
        'type',
        'affiliation',
        'country_contr',
        'numero_inscription',
        
    ];
    
    protected $casts = [
        'date' => 'date',
        'email_verified_at' => 'datetime',
    ];
    
       
}
