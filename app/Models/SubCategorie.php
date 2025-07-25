<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'categorie_name', 
        'subcategorie_name'
    ];
}
