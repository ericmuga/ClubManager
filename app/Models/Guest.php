<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;


class Guest extends User
{
    use HasFactory;




    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_type = 'guest';
        });

        static::updating(function ($model) {
            $model->user_type = 'guest';
        });
    }
}
