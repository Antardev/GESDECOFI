<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategorie::class);
    }
}
