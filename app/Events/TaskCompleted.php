<?php

	namespace App\Events;

	use App\Models\Task;
	use Illuminate\Broadcasting\InteractsWithSockets;
	use Illuminate\Broadcasting\PrivateChannel;
	use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
	use Illuminate\Foundation\Events\Dispatchable;
	use Illuminate\Queue\SerializesModels;

	class TaskCompleted implements ShouldBroadcastNow
	{
		use Dispatchable, InteractsWithSockets, SerializesModels;

		/**
		 * Create a new event instance.
		 */
		public function __construct(public Task $task)
		{
		}

		public function broadcastAs(): string
		{
			return 'task-completed';
		}

		/**
		 * Get the channels the event should broadcast on.
		 *
		 * @return array<int, \Illuminate\Broadcasting\Channel>
		 */
		public function broadcastOn(): array
		{
			return [
				new PrivateChannel('private-' . $this->task->user_id),
			];
		}

		public function broadcastWith()
		{
			return ['taskId' => $this->task->id, 'title' => $this->task->title, 'completed' => $this->task->completed];
		}
	}
