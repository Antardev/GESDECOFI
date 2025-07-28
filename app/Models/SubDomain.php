<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomain extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'domain_id'];

public function domain()
{
    return $this->belongsTo(Domain::class);
}
}
