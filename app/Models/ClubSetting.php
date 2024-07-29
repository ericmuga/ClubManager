<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'club_name',
        'change_log_active',
        'default_currency',
        'logo',
        'dispatch_emails',
        'active',
        'address',
        'telephone',
        'email',
        'slogan',
        'pin',
        'id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'change_log_active' => 'boolean',
        'dispatch_emails' => 'boolean',
        'active' => 'boolean',

    ];
}
