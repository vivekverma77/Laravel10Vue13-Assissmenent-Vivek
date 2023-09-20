<?php

namespace App\Http\Controllers\Api\V2;

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return TaskResource::collection(Task::all());
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
        return TaskResource::collection(Task::where('status', $status)->get());
    }

    public function tasksBySearch()
    {  
        $json = file_get_contents('php://input');
        $search = json_decode($json);   
        return TaskResource::collection(Task::where('name', 'LIKE',"%$search->search%")->get());
    }
}
