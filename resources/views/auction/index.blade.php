<x-layouts.app>

    @if(session('alert_success'))
        <x-alerts.success :message="session('alert_success')" />
    @endif

    <div class="sm:p-7 p-4">
        {{-- <div class="flex w-full items-center mb-7 border-[1px] border-[red]">
            <div class="ml-auto text-gray-500 text-xs sm:inline-flex hidden items-center">
                <span class="mr-3">Page 2 of 4</span>
                <button
                    class="inline-flex mr-2 items-center h-8 w-8 justify-center text-gray-400 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none py-0">
                    <svg class="w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button
                    class="inline-flex items-center h-8 w-8 justify-center text-gray-400 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none py-0">
                    <svg class="w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div> --}}
        <div class="w-full text-left">
            <div class="block w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3">
                        ID
                    </h1>
                    <h1
                        class="flex-1 font-normal px-3 pt-0 pb-3 sm:text-gray-400 text-white">
                        Car
                    </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3">
                        Starting price
                    </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3">
                        Start
                    </h1>
                </div>
            </div>
            <div class="text-gray-600 dark:text-gray-100">


                @foreach ($auctions as $auction)
                    <div class="flex items-end shadow-md rounded-md">
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                            <div class="flex items-center text-gray-600"> {{ $auction->id }} </div>
                        </div>
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                            <div class="flex items-center">
                                <div class="sm:flex hidden flex-col text-gray-400">
                                    {{ $auction->car->company }}
                                    <div class="text-gray-600 text-xs">
                                        {{ $auction->car->color . ' ' . $auction->car->model }} </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="sm:p-3 inline-block flex-1 py-2 px-1 text-green-500">
                            ${{ $auction->starting_price }}
                        </div>
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                            <div class="flex items-center justify-between">
                                <div class="sm:flex hidden flex-col text-gray-400">
                                    {{ $auction->getStartDate() }}
                                    <div class="text-gray-600 text-xs"> {{ $auction->getStartClock() }} </div>
                                </div>
                                <!-- dropdown -->
                                <div class="flex flex-col justify-center">
                                    <div class="flex items-center justify-center">
                                        <div class="inline-block text-left dropdown">
                                            <div class="block">
                                                <div class="inline">
                                                    <button type="button"
                                                        class="inline-flex items-center px-2 rounded-full hover:shadow-lg text-gray-400">
                                                        <svg viewBox="0 0 24 24" class="w-5" stroke="currentColor"
                                                            stroke-width="2" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="19" cy="12" r="1"></circle>
                                                            <circle cx="5" cy="12" r="1"></circle>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div
                                                class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                                                <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg outline-none overflow-hidden"
                                                    aria-labelledby="headlessui-menu-button-1"
                                                    id="headlessui-menu-items-117" role="menu">
                                                    <div class="py-1 hover:bg-[#80808086]">
                                                        <a href="{{ route('auctions.show', ['auction' => $auction->id]) }}"
                                                            tabindex="0" role="menuitem"
                                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                                                            Show
                                                        </a>
                                                    </div>
                                                    <div class="py-1 hover:bg-[#80808086]">
                                                        <a href="{{ route('auctions.edit', ['auction' => $auction->id]) }}"
                                                            tabindex="0" role="menuitem"
                                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                                                            Edit
                                                        </a>
                                                    </div>
                                                    <div class="py-1 hover:bg-[#80808086] delete-button"
                                                        data-id="{{ $auction->id }}">
                                                        <a tabindex="0" role="menuitem"
                                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .dropdown:focus-within .dropdown-menu {
                                        opacity: 1;
                                        transform: translate(0) scale(1);
                                        visibility: visible;
                                    }
                                </style>
                                <!-- end dropdown -->
                            </div>
                        </div>
                    </div>
                    <x-delete-modal name="Auction" :item="$auction" :route="route('auctions.destroy', ['auction' => $auction->id])" />
                @endforeach



            </div>
            {{-- <div class="flex w-full mt-5 space-x-2 justify-end border-[1px] border-[red]">
            <button
                class="inline-flex items-center h-8 w-8 justify-center text-gray-400 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none">
                <svg class="w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button
                class="inline-flex items-center h-8 w-8 justify-center text-gray-500 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none">1</button>
            <button
                class="inline-flex items-center h-8 w-8 justify-center text-gray-500 rounded-md shadow border border-gray-200 dark:border-gray-800 bg-gray-100 dark:bg-gray-800 dark:text-white leading-none">2</button>
            <button
                class="inline-flex items-center h-8 w-8 justify-center text-gray-500 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none">3</button>
            <button
                class="inline-flex items-center h-8 w-8 justify-center text-gray-500 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none">4</button>
            <button
                class="inline-flex items-center h-8 w-8 justify-center text-gray-400 rounded-md shadow border border-gray-200 dark:border-gray-800 leading-none">
                <svg class="w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div> --}}
        </div>

        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $auctions->links() }}
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
