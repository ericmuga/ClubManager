<?php

use App\Http\Controllers\{MemberController,
                          ProfileController,
                          SettingController,
                          TemplateController,
                          MeetingController,
                          ClubSettingController,
                          DashboardController,
                        EntryTypeController};
use GuzzleHttp\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;


Route::get('/', fn()=>redirect('login'));use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/api/club-settings/logo', [ClubSettingController::class, 'getLogo']);


Route::get('/dashboard',[DashboardController::class,'index'] )->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function ()
    {


            Route::get('/download-template/{model}', [TemplateController::class, 'downloadTemplate'])->name('downloadTemplate');
            Route::get('/download-list/{model}', [TemplateController::class, 'downloadList'])->name('downloadList');
            Route::get('/download-pdf-list/{model}', [TemplateController::class, 'downloadPDFList'])->name('downloadPdfList');

            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

                //member routes
            Route::resource('members',MemberController::class);
            Route::post('/members/upload', [MemberController::class, 'upload'])->name('members.upload');


            //meetings
            Route::resource('meetings',MeetingController::class);
            Route::post('/meetings/upload', [MeetingController::class, 'upload'])->name('meetings.upload');
            Route::post('/meeting-attend',[MeetingController::class,'attend'])->name('meetings.attend');
    }
);





// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/{id}', [SettingController::class, 'update'])->name('settings.update');

});

Route::middleware('auth')->group(function(){
       Route::get('/entry-types', [EntryTypeController::class, 'index']);      // Get all entry types
Route::post('/entry-types', [EntryTypeController::class, 'store']);     // Add new entry type
Route::put('/entry-types/{id}', [EntryTypeController::class, 'update']); // Update entry type by id
Route::delete('/entry-types/{id}', [EntryTypeController::class, 'destroy']); // Delete entry type by id
});

require __DIR__.'/auth.php';


Route::resource('club-settings', ClubSettingController::class)->only('index', 'store');




Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');

Route::resource('meetings', App\Http\Controllers\MeetingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');

Route::resource('meetings', App\Http\Controllers\MeetingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');

Route::resource('meetings', App\Http\Controllers\MeetingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');

Route::resource('meetings', App\Http\Controllers\MeetingController::class)->only('index', 'store', 'show');


Route::resource('club-settings', App\Http\Controllers\ClubSettingController::class)->only('index', 'store', 'show');

Route::resource('meetings', App\Http\Controllers\MeetingController::class)->only('index', 'store', 'show');



