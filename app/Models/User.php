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
    use  UserTrait,LogsChanges;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =['id'];



    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


        public function isAdmin()
        {
            return $this->hasRole('admin');

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

        public function meeting_lines()
        {
            return $this->hasMany(MeetingLine::class,'user_id','id');
        }

    }
