<?php
// tests/Feature/TaskTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'description', 'is_completed', 'created_at', 'updated_at'],
                     ],
                 ]);
    }
    

    public function test_can_create_a_task()
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
        ];

        $response = $this->postJson('/api/v1/tasks', $taskData);

        $response->assertStatus(201)
                 ->assertJsonFragment($taskData);
    }

    public function test_can_update_a_task()
{
    $task = Task::factory()->create();

    // Include all required fields in the update data
    $updatedData = [
        'title' => 'Updated Task',
        'description' => $task->description, // Use the existing description
    ];

    $response = $this->putJson("/api/v1/tasks/{$task->id}", $updatedData);

    $response->assertStatus(200)
             ->assertJsonFragment($updatedData);
}


    public function test_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(204);
    }

    public function test_can_mark_task_as_completed()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson("/api/v1/tasks/{$task->id}/complete");

        $response->assertStatus(200)
                 ->assertJsonFragment(['is_completed' => !$task->is_completed]);
    }
}
