<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionCategorie extends Model
{
    use HasFactory;

    public function category_name()
    {

        $cat = Categorie::where('id', $this->categorie_id)->first();

        return $cat->categorie_name;

    }



}
