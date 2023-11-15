<x-layouts.app>

    <x-alerts.success />

    <x-search-bar name="cars" :types="App\Models\Car::fillables()" :oldcol="$oldcol ?? null" :oldval="$oldval ?? null" />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Car </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Year </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Condition </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Status </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Owner </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Winner </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>
            <div class="text-gray-600">
                @foreach ($cars as $car)
                    <x-list-item name="car" :item="$car">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $car->id }}
                        </div>
                        {{-- car --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
                        </div>
                        {{-- year --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $car->year }}
                        </div>
                        {{-- condition --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $car->condition }}
                        </div>
                        {{-- status --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $car->status }}
                        </div>
                        {{-- Owner --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
                        </div>
                        {{-- Winner --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($car->dealer)
                                <x-two-row-text :first="$car->dealer->firstname" :second="$car->dealer->lastname" />
                            @else
                                <span> Not available </span>
                            @endif
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
