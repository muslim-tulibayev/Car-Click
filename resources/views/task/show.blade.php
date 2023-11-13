<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Task id: {{ $task->id }} </h2>

            {{-- operation --}}
            <x-card-item name="Operation">
                <span class="font-medium text-green-500">
                    {{ $task->operation }}
                </span>
            </x-card-item>

            {{-- operator_id --}}
            <x-card-item name="Operator">
                @if ($task->operator)
                    <a href="{{ route('operators.show', ['operator' => $task->operator->id]) }}">
                        <x-two-row-text :first="$task->operator->firstname" :second="$task->operator->lastname" />
                    </a>
                @else
                    <span class="text-orange-500"> Not taken </span>
                @endif
            </x-card-item>

            {{-- is_done --}}
            <x-card-item name="Is Done">
                @if ($task->is_done)
                    <span class="text-green-500"> True </span>
                @else
                    <span class=" text-red-500"> False </span>
                @endif
            </x-card-item>

            <x-task.data :task="$task" />

            @if (!$task->is_done)
                <x-task.finish-bar :task="$task" />
            @endif

        </x-show-card>
        <x-show-btns-bar name="task" :item="$task" />
        <x-delete-modal name="Task" :item="$task" :route="route('tasks.destroy', ['task' => $task->id])" />
    </div>

</x-layouts.app>
