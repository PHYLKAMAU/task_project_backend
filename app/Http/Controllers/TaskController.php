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

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'task' => $task
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_completed' => 'boolean', // Optional field if you are updating it
        ]);
        dd($id);

        // Find the task by ID or return a 404 if not found
        $task = Task::findOrFail($id);

        // Update the task with validated data
        $task->update($request->only(['title', 'description', 'is_completed']));

        // Return the updated task as a resource
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
