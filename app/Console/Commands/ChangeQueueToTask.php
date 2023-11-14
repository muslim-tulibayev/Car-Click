<?php

namespace App\Console\Commands;

use App\Http\Controllers\Task\TaskManage;
use App\Models\Queue;
use Illuminate\Console\Command;

class ChangeQueueToTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue-to-task:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create tasks table first, copy queues to tasks and drop queues table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // * Adding new column to Operators first
        $this->call('migrate', [
            '--path' => 'database/migrations/2023_11_12_060119_add_is_muted_column_to_operators_table.php',
        ]);

        $this->call('migrate', [
            '--path' => 'database/migrations/2023_11_12_070119_create_tasks_table.php',
        ]);
        $this->call('migrate', [
            '--path' => 'database/migrations/2023_11_12_071715_create_task_msgs_table.php',
        ]);

        $queues = Queue::all();

        foreach ($queues as $queue)
            TaskManage::make($queue->operation, $queue->queueable_id);

        $this->call('migrate', [
            '--path' => 'database/migrations/2023_11_12_094439_drop_queues_table.php',
        ]);

        return Command::SUCCESS;
    }
}
