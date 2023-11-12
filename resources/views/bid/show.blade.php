<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Bid id: {{ $bid->id }} </h2>

            {{-- auction_id --}}
            <x-card-item name="Auction ID">
                <a href="{{ route('auctions.show', ['auction' => $bid->auction->id]) }}">
                    <span class="text-sm">
                        {{ $bid->auction->id }}
                    </span>
                </a>
            </x-card-item>

            {{-- dealer_id --}}
            <x-card-item name="Dealer">
                <a href="{{ route('dealers.show', ['dealer' => $bid->dealer->id]) }}">
                    <x-two-row-text :first="$bid->dealer->firstname" :second="$bid->dealer->lastname" />
                </a>
            </x-card-item>

            {{-- price --}}
            <x-card-item name="Price">
                <span class="text-sm">
                    ${{ $bid->price }}
                </span>
            </x-card-item>

        </x-show-card>
        <x-show-btns-bar name="bid" :item="$bid" />
        <x-delete-modal name="Bid" :item="$bid" :route="route('bids.destroy', ['bid' => $bid->id])" />
    </div>

</x-layouts.app>
