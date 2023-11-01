<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Queue id: {{ $queue->id }} </h2>
            <x-card-item name="Operation">
                <span class="font-medium text-green-500">
                    {{ $queue->operation }}
                </span>
            </x-card-item>

            <x-queue.data :queue="$queue" />

            <x-card-item name="Operator">
                @if ($queue->operator)
                    <x-two-row-text :first="$queue->operator->firstname" :second="$queue->operator->lastname" />
                @else
                    <span class="text-orange-500"> Not given </span>
                @endif
            </x-card-item>

            <x-queue.finish-bar :queue="$queue" />

        </x-show-card>
        <x-show-btns-bar name="queue" :item="$queue" />
        <x-delete-modal name="Queue" :item="$queue" :route="route('queues.destroy', ['queue' => $queue->id])" />
    </div>

</x-layouts.app>
