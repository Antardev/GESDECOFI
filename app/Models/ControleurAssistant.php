<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function hasRoles($role)
    {
        if (RoleAssistant::where('name', $role)->where('controleur_assistant_id', $this->id)->exists())
        {
            return true;
        }else {
            return false;
        }
    }


}
