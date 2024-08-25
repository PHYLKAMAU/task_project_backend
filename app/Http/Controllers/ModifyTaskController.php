<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ModifyTaskController extends Controller
{
  public function updateTask(Request $request,$id){
      $request->validate([
          'title' => 'required|string|max:255',
          'description' => 'required|string',
          'is_completed' => 'boolean', // Optional field if you are updating it
      ]);

      // Find the task by ID or return a 404 if not found
      $task = Task::findOrFail($id);
      $task->title = $request['title'];
      $task->description = $request['description'];
      $task->is_completed = $request['is_completed'];
      // Update the task with validated data
      $task->update();
        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }
    public function markComplete($id){
//      dd($id);
      $task = Task::findOrfail($id);
      $task->is_completed = true;
      $task->update();
      return response()->json([
          'status' => 'success',
          'message' => 'Task updated successfully',
          'task' => $task,
      ]);
    }
    public function deleteComplete($id){
//      dd($id);
      $task = Task::findOrfail($id);

      $task->delete();
      return response()->json([
          'status' => 'success',
          'message' => 'Task deleted successfully',
          'task' => $task,
      ]);
    }
}
