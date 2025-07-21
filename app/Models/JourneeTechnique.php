<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourneeTechnique extends Model
{
    use HasFactory;

    public function modules()
    {

        return $this->hasMany(JtModule::class);

    }
}
