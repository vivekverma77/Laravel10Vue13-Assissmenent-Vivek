<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use GuzzleHttp\Psr7\Request;

class TaskController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Task::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return TaskResource::collection(Task::with(['user'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('assigned_user_id', $user->id);
            })
            ->orderby('id', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }

    public function tasksByStatus($status)
    {   
        $user = auth()->user();
        return TaskResource::collection(Task::with(['user'])
            ->where('status', $status)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('assigned_user_id', $user->id);
            })
            ->orderby('id', 'desc')->get());
    }

    public function tasksBySearch()
    {
        $user = auth()->user();
        $json = file_get_contents('php://input');
        $search = json_decode($json);
        return TaskResource::collection(Task::with(['user'])
            ->where('name', 'LIKE', "%$search->search%")
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('assigned_user_id', $user->id);
            })
            ->orderby('id', 'desc')->get());
    }
}
