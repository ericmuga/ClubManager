<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingStoreRequest;
use App\Models\Meeting;
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
        $meeting = Meeting::create($request->validated());

        return redirect()->route('meetings.index');
    }

    // public function show(Request $request, Meeting $meeting): Response
    // {
    //     return view('meeting');
    // }
}
