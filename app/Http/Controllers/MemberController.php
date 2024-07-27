<?php

namespace App\Http\Controllers;

use App\Models\{Member,Guest,User};
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Imports\MembersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;
use Faker\Factory as Faker;
use App\Services\ModelService;


class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

    private function getAvatarURL(Request $request)
    {
        $path = '';
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');
        } else {
            $faker = Faker::create();
            $path = $faker->imageUrl(640, 480, 'people'); // Generates a random avatar URL
        }
        return $path;
    }



    public function store(Request $request)
    {

              User::create([
                                'name'=>$request->name,
                                'email'=>$request->email,
                                'password'=>bcrypt(Str::random(6)),
                                'phone'=>$request->phone,
                                'member_no'=>$request->member_no,
                                'nationality'=>$request->nationality,
                                'gender'=>$request->gender,
                                'avatar'=>$this->getAvatarURL($request),
                                "user_type"=>'member'
                            ]);


          return $this->index();
    }



    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
     //show memeber details
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
