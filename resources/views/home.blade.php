@props([
    'auction_number' => App\Models\Auction::count(),
    'auction_finished' => App\Models\Auction::where('life_cycle', 'finished')->count(),
    'auction_playing' => App\Models\Auction::where('life_cycle', 'playing')
        ->orwhere('life_cycle', 'waiting_confirmation')
        ->count(),
    'auction_waiting_start' => App\Models\Auction::where('life_cycle', 'waiting_start')->count(),

    'car_number' => App\Models\Car::count(),
    'car_amount' => App\Models\Auction::whereHas('car', function ($query) {
        $query->where('status', 'sold_out');
    })->sum('highest_price'),
    'car_sold_out' => App\Models\Car::where('status', 'sold_out')->count(),
    'car_didnt_sell' => App\Models\Car::where('status', 'didnt_sell')->count(),
    'car_not_sold' => App\Models\Car::where('status', 'not_sold')->count(),
    'car_waiting_validation' => App\Models\Car::where('status', 'waiting_validation')->count(),

    'user_number' => App\Models\User::count(),

    'dealer_number' => App\Models\Dealer::count(),
    'dealer_validated' => App\Models\Dealer::where('is_validated', true)->count(),

    'operator_number' => App\Models\Operator::count(),
    'operator_validated' => App\Models\Operator::where('is_validated', true)->count(),
])

<x-layouts.app>

    <div class="h-full flex flex-col gap-2 p-5">
        <div class="flex gap-2">
            {{-- Users --}}
            <x-home-card>
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-violet-600">
                    <i class="bx bx-user h-10 w-10 flex items-center justify-center text-2xl font-thin bg-violet-300 text-violet-600 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Users </span>
                </div>
                <x-home-card-item name="Number" value="{{ $user_number }}" />
            </x-home-card>
            {{-- Dealers --}}
            <x-home-card>
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-sky-600">
                    <i class="bx bx-user h-10 w-10 flex items-center justify-center text-2xl font-thin bg-sky-300 text-sky-600 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Dealers </span>
                </div>
                <div>
                    <x-home-card-item name="Number" value="{{ $dealer_number }}" />
                </div>
            </x-home-card>
            {{-- Operators --}}
            <x-home-card>
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-indigo-600">
                    <i class="bx bx-microphone h-10 w-10 flex items-center justify-center text-2xl font-thin bg-indigo-300 text-indigo-600 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Operators </span>
                </div>
                <div>
                    <x-home-card-item name="Number" value="{{ $operator_number }}" />
                    <x-home-card-item name="Validated" value="{{ $operator_validated }}" />
                </div>
            </x-home-card>
        </div>
        <div class="flex gap-2">
            {{-- Auctions --}}
            <x-home-card>
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-green-600">
                    <i class="bx bx-user-voice h-10 w-10 flex items-center justify-center text-2xl font-thin bg-green-300 text-green-600 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Auctions </span>
                </div>
                <div>
                    <x-home-card-item name="Number" value="{{ $auction_number }}" />
                    <x-home-card-item name="Finished" value="{{ $auction_finished }}" />
                    <x-home-card-item name="Playing" value="{{ $auction_playing }}" />
                    <x-home-card-item name="Waiting start" value="{{ $auction_waiting_start }}" />
                </div>
            </x-home-card>
            {{-- Cars --}}
            <x-home-card>
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-yellow-600">
                    <i class="bx bx-car h-10 w-10 flex items-center justify-center text-2xl font-thin bg-yellow-300 text-yellow-600 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Cars </span>
                </div>
                <div>
                    <x-home-card-item name="Number" value="{{ $car_number }}" />
                    <x-home-card-item name="Amount of money (Sold out)" value="{{ $car_amount }}" />
                    <x-home-card-item name="Sold out" value="{{ $car_sold_out }}" />
                    <x-home-card-item name="Did not sell" value="{{ $car_didnt_sell }}" />
                    <x-home-card-item name="Not sold" value="{{ $car_not_sold }}" />
                    <x-home-card-item name="Waiting validation" value="{{ $car_waiting_validation }}" />
                </div>
            </x-home-card>
        </div>
    </div>

</x-layouts.app>
