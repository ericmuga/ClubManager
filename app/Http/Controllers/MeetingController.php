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

    public function store(MeetingStoreRequest $request)
    {
        $validated=$request->validated();
        $validated['meeting_no']=$this->generateNewMeetingNo();
        $meeting = Meeting::create($validated);

        return response()->json(['meeting' => $meeting], 200);
    }

    public function show(Meeting $meeting) : Response
    {
        //hydrate meeting with attendance
        // get members
        $members=Member::all('id','name');
        $guests=Guest::all('id','name','email');
        $meeting_lines=$meeting->meeting_lines();

        return Inertia::render('Meeting/Show',compact('meeting','meeting_lines','members','guests'));
    }


    public function upload(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|mimes:xlsx,xls'
        // ]);

        // Excel::import(new MembersImport, $request->file('file'));

        return redirect()->back()->with('success', 'File uploaded successfully');
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
public function destroy($id)
{
    // Find the meeting by ID
    $meeting = Meeting::findOrFail($id);

    // Delete the meeting
    $meeting->delete();

    // Return a success response
    return response()->json([
        'message' => 'Meeting deleted successfully.'
    ], \Illuminate\Http\Response::HTTP_OK);
}

    // public function show(Request $request, Meeting $meeting): Response
    // {
    //     return view('meeting');
    // }
}
