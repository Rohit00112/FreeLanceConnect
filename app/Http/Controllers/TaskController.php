<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->get();
        return view('Freelancer.todo', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'user_id' => auth()->id(),
            'status' => 'Pending',
            'priority' => 'Low',


        ]);

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:Pending,In Progress,Completed',
            'priority' => 'sometimes|in:Low,Medium,High',
            'due_date' => 'sometimes|date|nullable',
        ]);

        $task->update($request->only(['title', 'status', 'priority', 'due_date']));

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
