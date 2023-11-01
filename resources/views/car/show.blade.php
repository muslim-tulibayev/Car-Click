<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Car id: {{ $car->id }} </h2>
            <x-card-item name="Car">
                <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
            </x-card-item>
            <x-card-item name="Condition">
                <span class="text-sm px-3 py-px text-blue-500">
                    {{ $car->condition }}
                </span>
            </x-card-item>
            <x-card-item name="Status">
                <span class="text-sm bg-green-100 rounded-full px-3 py-px text-green-500">
                    {{ $car->status }}
                </span>
            </x-card-item>
            <x-card-item name="Additional">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify">
                    {{ $car->additional }}
                </p>
            </x-card-item>
            <x-card-item name="Owner">
                <span class="text-sm px-3 py-px text-gray-700">
                    {{ $car->user->firstname . ' ' . $car->user->lastname }}
                </span>
            </x-card-item>
            <x-card-item name="Winner">
                <span class="text-sm px-3 py-px text-gray-700">
                    @if (isset($car->dealer))
                        {{ $car->dealer->firstname . ' ' . $car->dealer->lastname }}
                    @endif
                </span>
            </x-card-item>
        </x-show-card>
        <x-show-btns-bar name="car" :item="$car" />
        <x-delete-modal name="Car" :item="$car" :route="route('cars.destroy', ['car' => $car->id])" />
    </div>

</x-layouts.app>
