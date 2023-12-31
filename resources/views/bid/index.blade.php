<x-layouts.app>

    <x-alerts.success />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Auction ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Dealer </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Price </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>
            <div class="text-gray-600">
                @foreach ($bids as $bid)
                    <x-list-item name="bid" :item="$bid">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $bid->id }}
                        </div>

                        {{-- auction_id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $bid->auction->id }}
                        </div>

                        {{-- dealer_id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$bid->dealer->firstname" :second="$bid->dealer->lastname" />
                        </div>

                        {{-- price --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            ${{ $bid->price }}
                        </div>

                    </x-list-item>
                    <x-delete-modal name="Bid" :item="$bid" :route="route('bids.destroy', ['bid' => $bid->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $bids->links() }}
        </div>
    </div>

</x-layouts.app>
