<?php

namespace App\Http\Controllers;

use App\Models\{Member,Guest,User};
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Imports\MembersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;
use Faker\Factory as Faker;
use App\Services\ModelService;
use App\Traits\UploadsFiles;


class MemberController extends Controller
{
    use UploadsFiles;

     protected $modelService;
    public function index()
    {
      //display all the members
      $members=Member::all();

      return inertia('Member/List',compact('members'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new MembersImport, $request->file('file'));

        return redirect()->back()->with('success', 'File uploaded successfully');
    }


    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function showFillableProperties()
    {
        $user = new User();
        $fillable = $this->modelService->getFillableProperties($user);
        return response()->json($fillable);
    }

    public function downloadTemplate()
    {
        // dd('here');

        return Excel::download(new TemplateExport($this->showFillableProperties()), 'member_template.xlsx');
    }




    public function store(StoreMemberRequest $request): Response
    {
         $validated=$request->validated();
         $validated['logo'] = $this->uploadFile($request, 'avatar', 'avatar');
         User::create($validated);
         return redirect()->route('members.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {

    $meeting_lines=$member->meeting_lines->load('meeting');
     return inertia('Member/Show',compact('member','meeting_lines'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        $member->delete();
        $this->index();
    }
}
