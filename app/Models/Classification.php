<?php

namespace App\Models;

use App\Traits\LogsChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    use LogsChanges;

    protected $guarded =['id'];

    public function parent_classification() {
        return $this->belongsTo(Classification::class);
    }
    public function members()
    {
        return $this->hasMany(Member::class)->where('user_type','member');
    }

     public function guests()
    {
        return $this->hasMany(Guest::class)->where('user_type','guest');
    }

}
