<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Dealerchat id: {{ $dealerchat->id }} </h2>

            {{-- chat_id --}}
            <x-card-item name="Chat id (in Tg)">
                <span> {{ $dealerchat->chat_id }} </span>
            </x-card-item>

            {{-- Dealer --}}
            <x-card-item name="Dealer">
                @if ($dealerchat->dealer)
                    <a href="{{ route('dealers.show', ['dealer' => $dealerchat->dealer->id]) }}">
                        <x-two-row-text :first="$dealerchat->dealer->firstname" :second="$dealerchat->dealer->lastname" />
                    </a>
                @else
                    <span> Not available </span>
                @endif
            </x-card-item>

            {{-- action --}}
            <x-card-item name="Action">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify overflow-auto">
                    {{ $dealerchat->action }}
                </p>
            </x-card-item>

            {{-- data --}}
            <x-card-item name="Data">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify overflow-auto">
                    {{ $dealerchat->data }}
                </p>
            </x-card-item>

            {{-- lang --}}
            <x-card-item name="Lang">
                <span> {{ $dealerchat->lang }} </span>
            </x-card-item>

        </x-show-card>
        <x-show-btns-bar name="dealerchat" :item="$dealerchat" />
        <x-delete-modal name="Dealerchat" :item="$dealerchat" :route="route('dealerchats.destroy', ['dealerchat' => $dealerchat->id])" />
    </div>

</x-layouts.app>
