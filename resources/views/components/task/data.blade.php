<x-card-item name="Data" />
<div class="p-2 rounded-md bg-gray-100">
    @if ($task->taskable instanceof \App\Models\Auction)
        <x-task.auction :auction="$task->taskable" :car="$task->taskable->car" />
    @elseif ($task->taskable instanceof \App\Models\Operator)
        <x-task.operator :operator="$task->taskable" />
    @elseif ($task->taskable instanceof \App\Models\Car)
        <x-task.car :car="$task->taskable" />
    @else
        <div class="flex items-center justify-between">
            <span> {{ $task->taskable_type }} </span>
            <span> {{ $task->taskable_id }} </span>
        </div>
    @endif
</div>
