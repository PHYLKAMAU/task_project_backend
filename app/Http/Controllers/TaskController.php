<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

class TaskController extends Controller
{
    public function index()
    {
        return new TaskCollection(Task::all());
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $task = Task::create($request->all());

        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_completed' => 'boolean',
        ]);

        $task->update($request->all());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }

    public function complete(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);

        return new TaskResource($task);
    }
}
