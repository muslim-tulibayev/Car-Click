<x-layouts.app>

    <x-alerts.success />

    <div class="p-4">
        <div class="w-full">
            {{-- <div class="w-full mb-2 text-white font-medium text-right">
                <a href="{{ route('auctions.create') }}" class="inline-block bg-green-500 py-1 px-3 rounded-md"> + New </a>
            </div> --}}
            <div class="w-full flex text-gray-400">
                <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> ID </h1>
                <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Car </h1>
                <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Starting price </h1>
                <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Start </h1>
            </div>
            <div class="text-gray-600 dark:text-gray-100">
                @foreach ($auctions as $auction)
                    <x-list-item>
                        <div class="inline-block flex-1 py-2 px-1">
                            <div class="flex items-center text-gray-600"> {{ $auction->id }} </div>
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$auction->car->company" :second="$auction->car->color . ' ' . $auction->car->model" />
                        </div>
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1 text-green-500">
                            ${{ $auction->starting_price }}
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$auction->getStartClock()" :second="$auction->getStartDate()">
                                <x-list-dropdown name='auction' :item="$auction" />
                            </x-two-row-text>
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
