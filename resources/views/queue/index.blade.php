<x-layouts.app>

    <x-alerts.success />

    <div class="p-4">
        <div class="w-full text-left">
            <div class="w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> ID </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Operation </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Operator </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Created at </h1>
                </div>
            </div>
            <div class="text-gray-600">
                @foreach ($queues as $queue)
                    <x-list-item name="queue" :item="$queue">
                        <div class="inline-block flex-1 py-2 px-1">
                            <div class="flex items-center text-gray-600"> {{ $queue->id }} </div>
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">{{ $queue->operation }}</div>
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($queue->operator)
                                <x-two-row-text :first="$queue->operator->firstname" :second="$queue->operator->lastname" />
                            @else
                                <span class="text-orange-500"> Not given </span>
                            @endif
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$queue->getCreatedAtClock()" :second="$queue->getCreatedAtDate()">
                                <x-list-dropdown name='queue' :item="$queue" />
                            </x-two-row-text>
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Queue" :item="$queue" :route="route('queues.destroy', ['queue' => $queue->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $queues->links() }}
        </div>
    </div>

</x-layouts.app>
