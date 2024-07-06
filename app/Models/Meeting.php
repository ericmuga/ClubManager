<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsChanges;

class Meeting extends Model
{
    use HasFactory;
    use LogsChanges;

    protected $guarded=['id'];
}
