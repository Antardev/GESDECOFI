<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;


    public function subdomains()
{
    return $this->hasMany(SubDomain::class);
}


    protected $fillable = [
        'name',
    ];

    /**
     * Get the validation rules for the domain.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:domains,name',
        ];
    }
}
