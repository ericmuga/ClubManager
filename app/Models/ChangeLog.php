<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    // use HasFactory;
    protected $fillable = [
        'table_name', 'field_name', 'change_type', 'old_value', 'new_value', 'user_id',
    ];
}
