<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUid
{
    protected static function bootHasUid()
    {
        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = static::generateUid();
            }
        });
    }

    public static function generateUid()
    {
        $uid = Str::random(25); // 25 caractères aléatoires
        $exists = static::where('uid', $uid)->exists();
        
        // Regénérer si le UID existe déjà
        while ($exists) {
            $uid = Str::random(25);
            $exists = static::where('uid', $uid)->exists();
        }
        
        return $uid;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }
}