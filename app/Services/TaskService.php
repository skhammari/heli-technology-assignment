<?php

	namespace App\Services;

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
				$user->tasks()->where('id', $taskId)->first()->update([
					'completed'    => true,
					'completed_at' => now()
				]);
			} else {
				throw new \Exception('This task does not belong to you', 403);
			}
		}

		public function belongsToUser($user, $taskId)
		{
			return $user->tasks()->where('id', $taskId)->exists();
		}
	}