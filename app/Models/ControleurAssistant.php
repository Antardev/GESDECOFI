<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControleurAssistant extends Model
{
    use HasFactory;

    public function roles()
    {
        return $this->hasMany(RoleAssistant::class);
    }

    public function controleur()
    {
        return $this->belongsTo(Controleurs::class);
    }
}
