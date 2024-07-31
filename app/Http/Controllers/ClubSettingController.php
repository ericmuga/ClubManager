<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubSettingStoreRequest;
use App\Http\Requests\ClubSettingUpdateRequest;
use App\Models\ClubSetting;
use Illuminate\Http\{Request,RedirectResponse};
use Illuminate\Support\Facades\{Storage,Log};
use App\Traits\UploadsFiles;
use Inertia\Inertia;
use Inertia\Response;
class ClubSettingController extends Controller
{
   use UploadsFiles;

   public function __construct()
    {
        Log::info('ClubSettingController initialized.');
    }

    public function index(Request $request): Response
    {
        $clubSetting= ClubSetting::first();
        return Inertia::render('ClubSetting/Show',compact('clubSetting'));

    }



    public function store(ClubSettingStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        if ($request->id!==null)
        {
            $clubSetting=ClubSetting::find($request->id);
            $clubSetting->delete();
            if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($clubSetting->logo) {
                Storage::disk('public')->delete($clubSetting->logo);
        }

        $validated['logo'] = $this->uploadFile($request, 'logo', 'logo');
       }

        }

        $validated['logo'] = $this->uploadFile($request, 'logo', 'logo');
        $clubSetting = ClubSetting::create($validated);

        return redirect()->route('club-settings.index');
    }

    public function getLogo()
    {
        $clubSetting = ClubSetting::latest()->first(); // Adjust this query as per your requirement
        $logoPath = $clubSetting ? $clubSetting->logo : null;

        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            return response()->json([
                'exists' => true,
                'filename' => basename($logoPath),
                'url' => Storage::url($logoPath), // URL to access the logo
            ]);
        }

        return response()->json(['exists' => false]);
    }







}
