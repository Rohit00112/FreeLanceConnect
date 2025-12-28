<?php



namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    public function index()
    {
        // Retrieve messages for the logged-in user based on their role
        $user = auth()->user();
        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($query) use ($user) {
                if ($user->role === 'client') {
                    $query->where('receiver_id', $user->id);
                } else if ($user->role === 'freelancer') {
                    $query->where('sender_id', $user->id);
                }
            })
            ->get();

        return view('messages.index', compact('messages'));
    }
  function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:255',
            'receiver_id' => 'required|exists:users,id',
        ]);

        // Create a new message
        Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
    }
}

