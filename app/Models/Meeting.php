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

   protected $fillable = [
        'type', 'description', 'meeting_date', 'venue', 'topic', 'detail', 'host', 'uuid', 'meeting_no', 'official_start_time', 'official_end_time'
    ];
}
