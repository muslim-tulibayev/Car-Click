<x-queue.card-item name="Message"> New car </x-queue.card-item>
<x-queue.card-item name="Car ID"> {{ $car->id }} </x-queue.card-item>
<x-queue.card-item name="Company"> {{ $car->company }} </x-queue.card-item>
<x-queue.card-item name="Model"> {{ $car->model }} </x-queue.card-item>
<x-queue.card-item name="Year"> {{ $car->year }} </x-queue.card-item>
<x-queue.card-item name="Color"> {{ $car->color }} </x-queue.card-item>
<x-queue.card-item name="Condition"> {{ $car->condition }} </x-queue.card-item>
<x-queue.card-item name="Additional">
    <p class="text-right max-w-[60%]"> {{ $car->additional }} </p>
</x-queue.card-item>
