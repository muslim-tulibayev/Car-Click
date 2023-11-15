<x-layouts.app>

    <x-alerts.success />

    <x-search-bar name="operatorchats" :types="App\Models\OperatorChat::fillables()" :oldcol="$oldcol ?? null" :oldval="$oldval ?? null" />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Chat id (in Tg) </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Operator </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Language </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>

            <div class="text-gray-600">
                @foreach ($operatorchats as $operatorchat)
                    <x-list-item name="operatorchat" :item="$operatorchat">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $operatorchat->id }}
                        </div>

                        {{-- chat_id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $operatorchat->chat_id }}
                        </div>

                        {{-- Operator --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($operatorchat->operator)
                                <x-two-row-text :first="$operatorchat->operator->firstname" :second="$operatorchat->operator->lastname" />
                            @else
                                <span> Not available </span>
                            @endif
                        </div>

                        {{-- lang --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $operatorchat->lang }}
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Operatorchat" :item="$operatorchat" :route="route('operatorchats.destroy', ['operatorchat' => $operatorchat->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $operatorchats->links() }}
        </div>
    </div>

</x-layouts.app>
