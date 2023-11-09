@if ($car->status === 'not_sold')
    <x-queue.card-item name="Message"> Car not sold </x-queue.card-item>
    <x-queue.card-item name="Car ID"> {{ $car->id }} </x-queue.card-item>
    <x-queue.card-item name="Car">
        <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
    </x-queue.card-item>
    <x-queue.card-item name="Owner">
        <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
    </x-queue.card-item>
    <x-queue.card-item name="Phone"> {{ $car->user->contact }} </x-queue.card-item>
@elseif ($car->status === 'didnt_sell')
    <x-queue.card-item name="Message"> Owner of the car did not agree to sell </x-queue.card-item>
    <x-queue.card-item name="Car ID"> {{ $car->id }} </x-queue.card-item>
    <x-queue.card-item name="Car">
        <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
    </x-queue.card-item>
    <x-queue.card-item name="Price"> ${{ $auction->highestPrice() }} </x-queue.card-item>
    <x-queue.card-item name="Owner">
        <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
    </x-queue.card-item>
    <x-queue.card-item name="Phone"> {{ $car->user->contact }} </x-queue.card-item>
@elseif ($car->status === 'sold_out')
    <x-queue.card-item name="Message"> Car sold out </x-queue.card-item>
    <x-queue.card-item name="Car ID"> {{ $car->id }} </x-queue.card-item>
    <x-queue.card-item name="Car">
        <x-two-row-text :first="$car->company" :second="$car->color . ' ' . $car->model" />
    </x-queue.card-item>
    <x-queue.card-item name="Price"> ${{ $auction->highestPrice() }} </x-queue.card-item>

    <x-queue.card-item name="Winner">
        <x-two-row-text :first="$auction->highestPriceOwner()->firstname" :second="$auction->highestPriceOwner()->lastname" />
    </x-queue.card-item>
    <x-queue.card-item name="Phone"> {{ $auction->highestPriceOwner()->contact }} </x-queue.card-item>

    <x-queue.card-item name="Owner">
        <x-two-row-text :first="$car->user->firstname" :second="$car->user->lastname" />
    </x-queue.card-item>
    <x-queue.card-item name="Phone"> {{ $car->user->contact }} </x-queue.card-item>
@endif
