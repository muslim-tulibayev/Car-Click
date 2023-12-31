<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Dealer id: {{ $dealer->id }} </h2>
            <x-card-item name="Dealer">
                <x-two-row-text :first="$dealer->firstname" :second="$dealer->lastname" />
            </x-card-item>
            <x-card-item name="Contact">
                <span class="text-sm text-green-500">
                    {{ $dealer->contact }}
                </span>
            </x-card-item>
            <x-card-item name="Telegram chat">
                @if ($dealer->tg_chat)
                    <a href="{{ route('dealerchats.show', ['dealerchat' => $dealer->tg_chat->id]) }}"
                        class="font-medium bg-gray-200 rounded-md py-1 px-5"> Show </a>
                @else
                    <span> Not available </span>
                @endif
            </x-card-item>
        </x-show-card>
        <x-show-btns-bar name="dealer" :item="$dealer" />
        <x-delete-modal name="Dealer" :item="$dealer" :route="route('dealers.destroy', ['dealer' => $dealer->id])" />
    </div>

</x-layouts.app>
