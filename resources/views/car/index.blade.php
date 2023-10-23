<x-layouts.app>

    @if (session('alert_success'))
        <x-alerts.success :message="session('alert_success')" />
    @endif

    <div class="sm:p-7 p-4">
        <div class="w-full text-left">
            <div class="block w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3">
                        ID
                    </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3 sm:text-gray-400 text-white">
                        Car
                    </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3">
                        Status
                    </h1>
                </div>
            </div>
            <div class="text-gray-600 dark:text-gray-100">


                @foreach ($cars as $car)
                    <div class="flex items-end shadow-md rounded-md">
                        <!-- ID -->
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                            <div class="flex items-center text-gray-600"> {{ $car->id }} </div>
                        </div>
                        <!-- Car -->
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                            <div class="flex items-center">
                                <div class="sm:flex hidden flex-col text-gray-400">
                                    {{ $car->company }}
                                    <div class="text-gray-600 text-xs">
                                        {{ $car->color . ' ' . $car->model }} </div>
                                </div>
                            </div>
                        </div>
                        <!-- ID -->
                        <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                            <div class="flex items-center justify-between">
                                <div class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                                    {{ $car->status }}
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
                                                        <a href="{{ route('cars.show', ['car' => $car->id]) }}"
                                                            tabindex="0" role="menuitem"
                                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                                                            Show
                                                        </a>
                                                    </div>
                                                    <div class="py-1 hover:bg-[#80808086]">
                                                        <a href="{{ route('cars.edit', ['car' => $car->id]) }}"
                                                            tabindex="0" role="menuitem"
                                                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                                                            Edit
                                                        </a>
                                                    </div>
                                                    <div class="py-1 hover:bg-[#80808086] delete-button"
                                                        data-id="{{ $car->id }}">
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
                    <x-delete-modal name="Car" :item="$car" :route="route('cars.destroy', ['car' => $car->id])" />
                @endforeach



            </div>
        </div>

        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $cars->links() }}
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
