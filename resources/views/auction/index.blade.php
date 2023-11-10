<x-layouts.app>

    <x-alerts.success />

    {{-- <x-search-bar name="post" value="{{ $search_val ?? null }}" /> --}}

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Car </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Starting price </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Life cycle </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Start </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Finish </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>
            <div class="text-gray-600">
                @foreach ($auctions as $auction)
                    <x-list-item name="auction" :item="$auction">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $auction->id }}
                        </div>
                        {{-- car --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$auction->car->company" :second="$auction->car->color . ' ' . $auction->car->model" />
                        </div>
                        {{-- starting_price --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            ${{ $auction->starting_price }}
                        </div>
                        {{-- life_cycle --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $auction->life_cycle }}
                        </div>
                        {{-- start --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$auction->getStartClock()" :second="$auction->getStartDate()" />
                        </div>
                        {{-- finish --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$auction->getFinishClock()" :second="$auction->getFinishDate()" />
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Auction" :item="$auction" :route="route('auctions.destroy', ['auction' => $auction->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $auctions->links() }}
        </div>
    </div>

</x-layouts.app>
