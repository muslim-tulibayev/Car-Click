<x-layouts.app :searchbar="true" name="dealerchats" :types="App\Models\DealerChat::fillables()" :oldcol="$oldcol ?? null" :oldval="$oldval ?? null">

    <x-alerts.success />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Chat id (in Tg) </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Dealer </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Language </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>

            <div class="text-gray-600">
                @foreach ($dealerchats as $dealerchat)
                    <x-list-item name="dealerchat" :item="$dealerchat">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $dealerchat->id }}
                        </div>

                        {{-- chat_id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $dealerchat->chat_id }}
                        </div>

                        {{-- Dealer --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($dealerchat->dealer)
                                <x-two-row-text :first="$dealerchat->dealer->firstname" :second="$dealerchat->dealer->lastname" />
                            @else
                                <span> Not available </span>
                            @endif
                        </div>

                        {{-- lang --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $dealerchat->lang }}
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Dealerchat" :item="$dealerchat" :route="route('dealerchats.destroy', ['dealerchat' => $dealerchat->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $dealerchats->links() }}
        </div>
    </div>

</x-layouts.app>
