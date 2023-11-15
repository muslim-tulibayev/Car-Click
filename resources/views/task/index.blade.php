<x-layouts.app>

    <x-alerts.success />

    <x-search-bar name="tasks" :types="App\Models\Task::fillables()" :oldcol="$oldcol ?? null" :oldval="$oldval ?? null" />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Operation </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Operator </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Is Done </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Created at </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>

            <div class="text-gray-600">
                @foreach ($tasks as $task)
                    <x-list-item name="task" :item="$task">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $task->id }}
                        </div>

                        {{-- operation --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $task->operation }}
                        </div>

                        {{-- Operator --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($task->operator)
                                <x-two-row-text :first="$task->operator->firstname" :second="$task->operator->lastname" />
                            @else
                                <span> Not taken </span>
                            @endif
                        </div>

                        {{-- is_done --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($task->is_done)
                                <span class="text-green-500"> True </span>
                            @else
                                <span class=" text-red-500"> False </span>
                            @endif
                        </div>

                        {{-- created_at --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$task->getCreatedAtClock()" :second="$task->getCreatedAtDate()" />
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Task" :item="$task" :route="route('tasks.destroy', ['task' => $task->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $tasks->links() }}
        </div>
    </div>

</x-layouts.app>
