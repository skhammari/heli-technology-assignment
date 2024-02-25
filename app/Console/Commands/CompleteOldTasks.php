<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class CompleteOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:complete-old-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will make old tasks (tasks that are older than 2 days) completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldUncompletedTasksIds = Task::where('completed', false)->where('created_at', '<', now()->subDays(2))->pluck('id');

		Task::whereIn('id', $oldUncompletedTasksIds)->update(['completed' => true, 'completed_at' => now()]);
    }
}
