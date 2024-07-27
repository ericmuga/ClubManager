<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Member extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_type = 'member';
        });

        static::updating(function ($model) {
            $model->user_type = 'member';
        });
    }
    protected $fillable=['name', 'email', 'nationality', 'gender', 'member_no', 'phone'];

}
