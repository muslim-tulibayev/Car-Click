<x-task.card-item name="Message"> New car </x-task.card-item>
<x-task.card-item name="Car ID"> {{ $car->id }} </x-task.card-item>
<x-task.card-item name="Company"> {{ $car->company }} </x-task.card-item>
<x-task.card-item name="Model"> {{ $car->model }} </x-task.card-item>
<x-task.card-item name="Year"> {{ $car->year }} </x-task.card-item>
<x-task.card-item name="Color"> {{ $car->color }} </x-task.card-item>
<x-task.card-item name="Condition"> {{ $car->condition }} </x-task.card-item>
<x-task.card-item name="Additional">
    <p class="text-right max-w-[60%]"> {{ $car->additional }} </p>
</x-task.card-item>
