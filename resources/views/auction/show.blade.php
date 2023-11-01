<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Auction id: {{ $auction->id }} </h2>
            <x-card-item name="Car">
                <x-two-row-text :first="$auction->car->company" :second="$auction->car->color . ' ' . $auction->car->model" />
            </x-card-item>
            <x-card-item name="Starting price">
                <span class="text-sm px-3 py-px text-green-500">
                    ${{ $auction->starting_price }}
                </span>
            </x-card-item>
            <x-card-item name="Highest price">
                <span class="text-sm px-3 py-px text-green-500">
                    ${{ $auction->highest_price }}
                </span>
            </x-card-item>
            <x-card-item name="Highest price owner">
                <span class="text-sm px-3 py-px text-gray-700">
                    @if (isset($auction->highestPriceOwner))
                        {{ $auction->highestPriceOwner->firstname . ' ' . $auction->highestPriceOwner->lastname }}
                    @endif
                </span>
            </x-card-item>
            <x-card-item name="Status">
                <span class="text-sm px-3 py-px text-gray-700">
                    {{ $auction->life_cycle }}
                </span>
            </x-card-item>
            <x-card-item name="Start">
                <x-two-row-text :first="$auction->getStartDate()" :second="$auction->getStartClock()" />
            </x-card-item>
            <x-card-item name="Finish">
                <x-two-row-text :first="$auction->getFinishDate()" :second="$auction->getFinishClock()" />
            </x-card-item>
        </x-show-card>
        <x-show-btns-bar name="auction" :item="$auction" />
        <x-delete-modal name="Auction" :item="$auction" :route="route('auctions.destroy', ['auction' => $auction->id])" />
    </div>

</x-layouts.app>
