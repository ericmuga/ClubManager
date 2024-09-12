<?php
namespace App\Http\Controllers;

use App\Models\EntryType;
use App\Http\Requests\StoreEntryTypeRequest;
use App\Http\Requests\UpdateEntryTypeRequest;

class EntryTypeController extends Controller
{
    // Fetch all entry types
    public function index()
    {
        return EntryType::all();
    }

    // Store a new entry type
    public function store(StoreEntryTypeRequest $request)
    {
        EntryType::create($request->validated());

        return response()->json(['message' => 'Entry Type added successfully'], 201);
    }

    // Update an existing entry type
    public function update(UpdateEntryTypeRequest $request, $id)
    {
        $entryType = EntryType::findOrFail($id);
        $entryType->update($request->validated());

        return response()->json(['message' => 'Entry Type updated successfully']);
    }

    // Delete an entry type
    public function destroy($id)
    {
        $entryType = EntryType::findOrFail($id);
        $entryType->delete();

        return response()->json(['message' => 'Entry Type deleted successfully']);
    }
}
