@props([
    'operators_list' => App\Models\Operator::where('is_validated', true)
        ->where('is_muted', false)
        ->has('tg_chat')
        ->get(),
])

<x-layouts.app>

    <x-alerts.success />

    <form action="{{ route('tasks.update', ['task' => $task->id]) }}" method="POST"
        class="w-full my-5 flex flex-col items-center justify-center">
        @method('PUT')
        @csrf

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
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="operator_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        <option value=""> Null </option>
                        @foreach ($operators_list as $operator)
                            <option value="{{ $operator->id }}"
                                @if (old('operator_id')) @if (old('operator_id') == $operator->id)
                                        selected @endif
                            @else @if ($task->operator_id == $operator->id) selected @endif @endif>
                                {{ $operator->firstname . ' ' . $operator->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </x-card-item>
            <x-v-error name="operator_id" />

            {{-- is_done --}}
            <x-card-item name="Is Done">
                <div>
                    <select name="is_done"
                        class="w-[150px] text-sm text-gray-400 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]">
                        <option value="1" @if ($task->is_done) selected @endif> True </option>
                        <option value="0" @if (!$task->is_done) selected @endif> False </option>
                    </select>
                </div>
            </x-card-item>
            <x-v-error name="is_done" />

            {{-- data --}}
            <x-task.data :task="$task" />

        </x-show-card>
        <div class="mt-[10px]">
            <button type="submit"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-green-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Save
            </button>
        </div>
    </form>

</x-layouts.app>
