@if ($task->taskable instanceof \App\Models\Auction)
    <div class="bg-gray-100 rounded-md flex overflow-hidden h-[30px] mt-3">
        <a href="{{ route('finish-task', ['task' => $task->id, 'data' => 'done']) }}"
            class="h-full flex-1 font-medium flex items-center justify-center hover:bg-green-500 hover:text-white">
            Done </a>
    </div>
@else
    <div class="bg-gray-100 rounded-md flex overflow-hidden h-[30px] mt-3">
        <a href="{{ route('finish-task', ['task' => $task->id, 'data' => 'allow']) }}"
            class="h-full flex-1 font-medium flex items-center justify-center hover:bg-green-500 hover:text-white">
            Allow </a>
        <a href="{{ route('finish-task', ['task' => $task->id, 'data' => 'deny']) }}"
            class="h-full flex-1 font-medium flex items-center justify-center hover:bg-red-500 hover:text-white">
            Deny </a>
    </div>
@endif
