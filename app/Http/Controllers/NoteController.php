<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request, Client $client)
    {
        // Validate the note content
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Create a new note for the client
        $client->notes()->create([
            'content' => $request->content,
        ]);

        // Redirect back to the client details page
        return redirect()->route('clients.show', $client->id)->with('success', 'Note added successfully!');
    }
}

