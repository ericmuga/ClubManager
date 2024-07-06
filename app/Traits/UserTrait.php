<?php

namespace App\Traits;
use App\Models\{Classification,MeetingLine,Meeting};

trait UserTrait {
     public function Classification ()
    {
        return $this->belongsTo(Classification::class);
    }

    public function attendMeeting(Meeting $meeting)
    {
        $exists = MeetingLine::where('user_id', $this->id)
                             ->where('meeting_id', $meeting->id)
                             ->exists();

       if (!$exists)MeetingLine::create(['user_id'=>$this->id,'meeting_id'=>$meeting->id,'user_type'=>$this->user_type]);
    }
}
