<?php

namespace App\Models;


use App\Traits\LogsChanges;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    use LogsChanges, UserTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =['id'];

    // protected $loggableFields = ['name', 'email'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // app/Models/User.php
        public function isAdmin()
        {
            return $this->hasRole('admin');// === 'admin'; // Adjust based on your role implementation

        }

        public function classification()
        {
          return $this->belongsTo(Classification::class);
        }

        public function contacts()
        {
            return $this->hasMany(Contact::class);
        }
        public function emails()
        {
            return $this->hasMany(Contact::class)->where('type','email');
        }
         public function phones()
        {
            return $this->hasMany(Contact::class)->where('type','phone');
        }
}
