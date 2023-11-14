@if ($car->status === 'not_sold')
    <x-task.card-item name="Message"> Car not sold </x-task.card-item>
    <x-task.card-item name="Car ID"> {{ $car->id }} </x-task.card-item>
    <x-task.card-item name="Car">
        <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
    </x-task.card-item>
    <x-task.card-item name="Owner">
        <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
    </x-task.card-item>
    <x-task.card-item name="Phone"> {{ $car->user->contact }} </x-task.card-item>
@elseif ($car->status === 'didnt_sell')
    <x-task.card-item name="Message"> Owner of the car did not agree to sell </x-task.card-item>
    <x-task.card-item name="Car ID"> {{ $car->id }} </x-task.card-item>
    <x-task.card-item name="Car">
        <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
    </x-task.card-item>
    <x-task.card-item name="Price"> ${{ $auction->highestPrice() }} </x-task.card-item>
    <x-task.card-item name="Owner">
        <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
    </x-task.card-item>
    <x-task.card-item name="Phone"> {{ $car->user->contact }} </x-task.card-item>
@elseif ($car->status === 'sold_out')
    <x-task.card-item name="Message"> Car sold out </x-task.card-item>
    <x-task.card-item name="Car ID"> {{ $car->id }} </x-task.card-item>
    <x-task.card-item name="Car">
        <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
    </x-task.card-item>
    <x-task.card-item name="Price"> ${{ $auction->highestPrice() }} </x-task.card-item>

    <x-task.card-item name="Winner">
        <x-two-row-text :first="$auction->highestPriceOwner()->firstname" :second="$auction->highestPriceOwner()->lastname" />
    </x-task.card-item>
    <x-task.card-item name="Phone"> {{ $auction->highestPriceOwner()->contact }} </x-task.card-item>

    <x-task.card-item name="Owner">
        <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
    </x-task.card-item>
    <x-task.card-item name="Phone"> {{ $car->user->contact }} </x-task.card-item>
@endif
