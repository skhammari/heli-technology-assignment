<?php

	namespace App\Services;

	use App\Events\TaskCompleted;

	class TaskService
	{
		public function newTask(array $data)
		{
			$user = auth()->user();
			$user->tasks()->create([
				'title'       => trim($data['title']),
				'description' => $data['description'] ?? null,
				'completed'   => false
			]);
		}

		public function completeTask(int $taskId)
		{
			$user = auth()->user();

			if ($this->belongsToUser($user, $taskId)) {
				$task = $user->tasks()->where('id', $taskId)->first();
				$task->update([
					'completed'    => true,
					'completed_at' => now()
				]);
				TaskCompleted::dispatch($task);
			} else {
				throw new \Exception('This task does not belong to you', 403);
			}
		}

		public function belongsToUser($user, $taskId)
		{
			return $user->tasks()->where('id', $taskId)->exists();
		}
	}