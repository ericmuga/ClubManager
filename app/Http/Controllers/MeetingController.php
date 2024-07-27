<?php

namespace App\Http\Controllers;

use App\Models\{Meeting, User};
use Illuminate\Http\Request;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     *
     */


    public function attend(Request $request, $meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);
         $user = User::findOrFail($request->user_id);
        $user->attendMeeting($meeting);
        return response()->json(['message' => 'User attended the meeting successfully']);
    }
    public function index()
    {

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeetingRequest $request)
    {
         Meeting::create($request->all());
         return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
