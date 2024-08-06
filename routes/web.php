<?php

use App\Http\Controllers\{MemberController,
                          ProfileController,
                          SettingController,
                          TemplateController,
                          MeetingController,
                          ClubSettingController};
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


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


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
});





// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/{id}', [SettingController::class, 'update'])->name('settings.update');
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
