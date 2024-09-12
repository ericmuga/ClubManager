<?php
  use App\Http\Controllers\EntryTypeController;
use Illuminate\Support\Facades\Route;

// API routes for entry types
Route::get('/entry-types', [EntryTypeController::class, 'index']);      // Get all entry types
Route::post('/entry-types', [EntryTypeController::class, 'store']);     // Add new entry type
Route::put('/entry-types/{id}', [EntryTypeController::class, 'update']); // Update entry type by id
Route::delete('/entry-types/{id}', [EntryTypeController::class, 'destroy']); // Delete entry type by id


?>
