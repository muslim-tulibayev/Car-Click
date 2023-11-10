<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Auction id: {{ $auction->id }} </h2>

            {{-- car --}}
            <x-card-item name="Car">
                <a href="{{ route('cars.show', ['car' => $auction->car->id]) }}">
                    <x-two-row-text :first="$auction->car->company" :second="$auction->car->color . ' ' . $auction->car->model" />
                </a>
            </x-card-item>

            {{-- starting_price --}}
            <x-card-item name="Starting price">
                <span class="text-sm">
                    ${{ $auction->starting_price }}
                </span>
            </x-card-item>

            {{-- highestPrice --}}
            <x-card-item name="Highest price">
                @if ($auction->highestPrice())
                    <span class="text-sm">
                        ${{ $auction->highestPrice() }}
                    </span>
                @endif
            </x-card-item>

            {{-- highestPriceOwner --}}
            <x-card-item name="Highest price owner">
                <span class="text-sm text-gray-700">
                    @if ($auction->highestPriceOwner())
                        <a href="{{ route('dealers.show', ['dealer' => $auction->highestPriceOwner()->id]) }}">
                            {{ $auction->highestPriceOwner()->firstname . ' ' . $auction->highestPriceOwner()->lastname }}
                        </a>
                    @endif
                </span>
            </x-card-item>

            {{-- life_cycle --}}
            <x-card-item name="Status">
                <span class="text-sm text-gray-700">
                    {{ $auction->life_cycle }}
                </span>
            </x-card-item>

            {{-- Start --}}
            <x-card-item name="Start">
                <x-two-row-text :first="$auction->getStartDate()" :second="$auction->getStartClock()" />
            </x-card-item>

            {{-- Finish --}}
            <x-card-item name="Finish">
                <x-two-row-text :first="$auction->getFinishDate()" :second="$auction->getFinishClock()" />
            </x-card-item>

            {{-- join_btn_message_id --}}
            <x-card-item name="Message id (in Channel)">
                <span class="text-sm text-gray-700">
                    {{ $auction->join_btn_message_id }}
                </span>
            </x-card-item>

            {{-- Dealers anchor --}}
            <x-card-item name="Dealers">
                <a href="{{ route('auctions.dealers', ['auction' => $auction->id]) }}"
                    class="text-sm font-medium bg-gray-200 rounded-md px-10 py-1">
                    List
                </a>
            </x-card-item>

            {{-- Bids anchor --}}
            <x-card-item name="Bids">
                <a href="{{ route('auctions.bids', ['auction' => $auction->id]) }}"
                    class="text-sm font-medium bg-gray-200 rounded-md px-10 py-1">
                    List
                </a>
            </x-card-item>


        </x-show-card>
        <x-show-btns-bar name="auction" :item="$auction" />
        <x-delete-modal name="Auction" :item="$auction" :route="route('auctions.destroy', ['auction' => $auction->id])" />
    </div>

</x-layouts.app>
