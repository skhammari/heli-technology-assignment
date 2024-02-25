<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, TaskService $taskService)
	{
		$this->validate($request, [
			'title' => 'required'
		]);

		try {
			$taskService->newTask($request->all());

			return response()->json([
				'message' => 'Task created successfully.'
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage()
			], $e->getCode());
		}
	}

	public function complete(Request $request, TaskService $taskService) {
		$request->validate([
			'taskId' => 'required|integer'
		]);
		try {
			$taskService->completeTask($request['taskId']);
			return response()->json([
				'message' => 'Task completed successfully.'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage()
			], $e->getCode());
		}
	}

	public function all()
	{
		$tasks = auth()->user()->tasks()->paginate(10);
		return new TaskCollection($tasks);
	}
}
