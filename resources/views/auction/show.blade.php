<x-layouts.app>

    <div class="w-full m-[20px] flex flex-col items-center justify-center">

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Auction id: {{ $auction->id }} </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Car
                </span>
                <div class="">
                    <div class="flex items-center">
                        <div class="sm:flex hidden flex-col text-gray-400">
                            {{ $auction->car->company }}
                            <div class="text-gray-600 text-xs">
                                {{ $auction->car->color . ' ' . $auction->car->model }} </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Starting price
                </span>
                <span class="text-sm px-3 py-px text-green-500">
                    ${{ $auction->starting_price }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Highest price
                </span>
                <span class="text-sm px-3 py-px text-green-500">
                    ${{ $auction->highest_price }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Highest price owner
                </span>
                <span class="text-sm px-3 py-px text-gray-700">
                    @if (isset($auction->highestPriceOwner))
                        {{ $auction->highestPriceOwner->firstname . ' ' . $auction->highestPriceOwner->lastname }}
                    @endif
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Status
                </span>
                <span class="text-sm px-3 py-px text-gray-700">
                    {{ $auction->life_cycle }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Start
                </span>
                <div class="">
                    <div class="flex items-center">
                        <div class="sm:flex hidden flex-col text-gray-400">
                            {{ $auction->getStartDate() }}
                            <div class="text-gray-600 text-xs"> {{ $auction->getStartClock() }} </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Finish
                </span>
                <div class="">
                    <div class="flex items-center">
                        <div class="sm:flex hidden flex-col text-gray-400">
                            {{ $auction->getFinishDate() }}
                            <div class="text-gray-600 text-xs"> {{ $auction->getFinishClock() }} </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-[10px]">
            <button
                class="w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-red-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)] delete-button"
                data-id="{{ $auction->id }}">
                Delete
            </button>
            <a href="{{ route('auctions.edit', ['auction' => $auction->id]) }}"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Update
            </a>
        </div>

        <x-delete-modal name="Auction" :item="$auction" :route="route('auctions.destroy', ['auction' => $auction->id])" />

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll(".delete-button");
            deleteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const itemId = this.getAttribute("data-id");
                    const modal = document.getElementById(`confirmationModal_${itemId}`);
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });
        });
    </script>

</x-layouts.app>
