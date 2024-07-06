<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request->all());
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
