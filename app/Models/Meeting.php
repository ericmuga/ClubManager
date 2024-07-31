<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'date',
        'venue',
        'topic',
        'host',
        'uuid',
        'meeting_no',
        'official_start_time',
        'official_end_time',
        'detail',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'meeting_no' => 'integer',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getOfficialStartTimeAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getOfficialEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function attendance()
    {
        //this will return all guests, members, hosts of the meeting

    }
}
