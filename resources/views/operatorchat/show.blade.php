<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Operatorchat id: {{ $operatorchat->id }} </h2>

            {{-- chat_id --}}
            <x-card-item name="Chat id (in Tg)">
                <span> {{ $operatorchat->chat_id }} </span>
            </x-card-item>

            {{-- Operator --}}
            <x-card-item name="Operator">
                @if ($operatorchat->operator)
                    <a href="{{ route('operators.show', ['operator' => $operatorchat->operator->id]) }}">
                        <x-two-row-text :first="$operatorchat->operator->firstname" :second="$operatorchat->operator->lastname" />
                    </a>
                @else
                    <span> Not available </span>
                @endif
            </x-card-item>

            {{-- action --}}
            <x-card-item name="Action">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify overflow-auto">
                    {{ $operatorchat->action }}
                </p>
            </x-card-item>

            {{-- data --}}
            <x-card-item name="Data">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify overflow-auto">
                    {{ $operatorchat->data }}
                </p>
            </x-card-item>

            {{-- lang --}}
            <x-card-item name="Lang">
                <span> {{ $operatorchat->lang }} </span>
            </x-card-item>

        </x-show-card>
        <x-show-btns-bar name="operatorchat" :item="$operatorchat" />
        <x-delete-modal name="Operatorchat" :item="$operatorchat" :route="route('operatorchats.destroy', ['operatorchat' => $operatorchat->id])" />
    </div>

</x-layouts.app>
