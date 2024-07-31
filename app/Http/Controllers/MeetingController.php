<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingStoreRequest;
use App\Models\Guest;
use App\Models\Meeting;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\View\View;
use Inertia\Inertia;

class MeetingController extends Controller
{
    public function index(Request $request): Response
    {
        $meetings = Meeting::orderByDesc('meeting_no')->get();
        return Inertia::render('Meeting/List',compact('meetings'));
    }

    public function store(MeetingStoreRequest $request): RedirectResponse
    {
        $validated=$request->validated();
        $validated['meeting_no']=$this->generateNewMeetingNo();

        $meeting = Meeting::create($request->validated());

        return redirect()->route('meetings.index');
    }

    public function show(Meeting $meeting) : Response
    {
        //hydrate meeting with attendance
        // get members
        $members=Member::all('id','name');
        $guests=Guest::all('id','name','email');
        $attendance=$meeting->attendance();
        return Inertia::render('Meeting/Show',compact('meeting'));
    }

    /**
 * Generate a new meeting number in the format M0001, M0002, etc.
 *
 * @return string
 */
protected function generateNewMeetingNo()
{
    // Retrieve the latest meeting number
    $lastMeeting = Meeting::orderByDesc('meeting_no')->first();

    if ($lastMeeting && preg_match('/^M(\d+)$/', $lastMeeting->meeting_no, $matches)) {
        // Increment the numeric part and preserve leading zeros
        $newNumber = (int) $matches[1] + 1;
        $newMeetingNo = 'M' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    } else {
        // Start with M0001 if no meeting number exists
        $newMeetingNo = 'M000001';
    }

    return $newMeetingNo;
}


    // public function show(Request $request, Meeting $meeting): Response
    // {
    //     return view('meeting');
    // }
}
