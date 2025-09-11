<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->tasks;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        return $request->user()->tasks()->create([
            'title' => $request->title,
            'status' => 'pending',
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:pending,done',
        ]);

        $task->update($request->only('title', 'status'));
        return $task;
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    private function authorizeTask(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }
    }
}
