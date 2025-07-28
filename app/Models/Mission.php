<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MissionSubCategorie;

class Mission extends Model
{
    use HasFactory;

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function sub_categories()
    {
        return $this->hasMany(MissionSubCategorie::class);
    }
}
