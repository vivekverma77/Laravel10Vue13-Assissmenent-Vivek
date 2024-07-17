<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index_returns_tasks()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson(route('tasks.index'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id', 'name', 'priority', 'status', 'user_id', 'assigned_user_id', 'created_at', 'updated_at'
                         ]
                     ]
                 ]);
    }

    public function test_store_creates_task()
    {
        $data = Task::factory()->make()->toArray();
        $response = $this->postJson(route('tasks.store'), $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => $data['name']]);

        $this->assertDatabaseHas('tasks', ['name' => $data['name']]);
    }

    public function test_show_returns_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson(route('tasks.show', $task));

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $task->name]);
    }

    public function test_update_modifies_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $data = ['name' => 'Updated Task Name'];

        $response = $this->putJson(route('tasks.update', $task), $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Task Name']);

        $this->assertDatabaseHas('tasks', ['name' => 'Updated Task Name']);
    }

    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_tasks_by_status_returns_filtered_tasks()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id, 'status' => 'pending']);

        $response = $this->getJson(route('tasks.byStatus', 'pending'));

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'pending']);
    }

    // public function test_tasks_by_search_returns_filtered_tasks()
    // {
    //     $task = Task::factory()->create(['user_id' => $this->user->id, 'name' => 'Test Task', 'status' => 'pending']);

    //     $response = $this->postJson(route('tasks.bySearch'), ['search' => 'Test', 'status' => 'pending']);

    //     $response->assertStatus(200)
    //              ->assertJsonFragment(['name' => 'Test Task', 'status' => 'pending']);
    // }
}
