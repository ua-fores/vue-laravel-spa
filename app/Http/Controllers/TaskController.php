<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    } 

    public function show(Task $task)
    {
        return $task;
    }

    public function store(Request $request)
    {

        return Task::create($request->all());
    }
    
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return $task;
    }

}
