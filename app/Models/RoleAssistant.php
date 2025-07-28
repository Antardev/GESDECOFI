<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAssistant extends Model
{
    use HasFactory;

    public function assistants()
    {
        return $this->belongsToMany(ControleurAssistant::class, 'role_assistant', 'role_id', 'controleur_assistant_id');
    }

}
