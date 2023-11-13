<?php

namespace App\Console\Commands;

use App\Models\Queue;
use App\Models\Task;
use Illuminate\Console\Command;

class ChangeTaskToQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue-to-task:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback queue-to-task:start command (This command works only after queue-to-task:start command)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // * Get back queues table
        $this->call('migrate:rollback', [
            '--step' => 1,
        ]);

        $tasks = Task::all();

        foreach ($tasks as $task)
            Queue::create([
                "operation" => $task->operation,
                "operator_id" => $task->operator_id,
                "queueable_id" => $task->taskable_id,
                "queueable_type" => $task->taskable_type,
            ]);

        // * Drop task_msgs table
        $this->call('migrate:rollback', [
            '--step' => 1,
        ]);
        // * Drop tasks table
        $this->call('migrate:rollback', [
            '--step' => 1,
        ]);
        // * Drop is_muted column from operators table
        $this->call('migrate:rollback', [
            '--step' => 1,
        ]);

        return Command::SUCCESS;
    }
}
