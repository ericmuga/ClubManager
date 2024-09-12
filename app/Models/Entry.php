<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;


    protected $guarded=['id'];

    public function user()
    {
        return $this->belongsTo(Entry::class);
    }

    public function entry_type()
    {
      return $this->belongsTo(EntryType::class);
    }
}
