<x-layouts.app>

    <div class="w-full m-[20px] flex flex-col items-center justify-center">

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Car id: {{ $car->id }} </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Car
                </span>
                <div class="">
                    <div class="flex items-center">
                        <div class="sm:flex hidden flex-col text-gray-400">
                            {{ $car->company }}
                            <div class="text-gray-600 text-xs">
                                {{ $car->color . ' ' . $car->model }} </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Condition
                </span>
                <span class="text-sm px-3 py-px text-blue-500">
                    {{ $car->condition }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Status
                </span>
                <span class="text-sm bg-green-100 rounded-full px-3 py-px text-green-500">
                    {{ $car->status }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Additional
                </span>
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify">
                    {{ $car->additional }}
                </p>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Owner
                </span>
                <span class="text-sm px-3 py-px text-gray-700">
                    {{ $car->user->firstname . ' ' . $car->user->lastname }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Winner
                </span>
                <span class="text-sm px-3 py-px text-gray-700">
                    @if (isset($car->dealer))
                        {{ $car->dealer->firstname . ' ' . $car->dealer->lastname }}
                    @endif
                </span>
            </div>

        </div>
        <div class="mt-[10px]">
            <button
                class="w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-red-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)] delete-button"
                data-id="{{ $car->id }}">
                Delete
            </button>
            <a href="{{ route('cars.edit', ['car' => $car->id]) }}"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Update
            </a>
        </div>

        <x-delete-modal name="Car" :item="$car" :route="route('cars.destroy', ['car' => $car->id])" />

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
