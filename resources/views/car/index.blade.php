<x-layouts.app>

    <x-alerts.success />

    <div class="sm:p-7 p-4">
        <div class="w-full text-left">
            <div class="block w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> ID </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Car </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Status </h1>
                </div>
            </div>
            <div class="text-gray-600 dark:text-gray-100">
                @foreach ($cars as $car)
                    <x-list-item>
                        <div class="flex-1 text-gray-600">
                            {{ $car->id }}
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
                        </div>
                        <div class="flex items-center justify-between flex-1">
                            <div class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                                {{ $car->status }}
                            </div>
                            <x-list-dropdown name="car" :item="$car" />
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Car" :item="$car" :route="route('cars.destroy', ['car' => $car->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $cars->links() }}
        </div>
    </div>

</x-layouts.app>
