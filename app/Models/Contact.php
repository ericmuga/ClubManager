<?php

namespace App\Models;

use App\Traits\LogsChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use function PHPUnit\Framework\returnSelf;

class Contact extends Model
{
    use HasFactory;

    use LogsChanges;

    protected $guarded=['id'];
    public function user(){
        return $this->belongsTo(User::class);
    }


}
