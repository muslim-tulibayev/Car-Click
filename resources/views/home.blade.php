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

    <div class="h-full flex flex-col justify-center gap-20">

        {{-- First row --}}
        <div class="flex justify-around">
            {{-- Auctions --}}
            <div class="flex flex-col gap-5 w-[400px] m-[5px] p-[15px] shadow-2xl rounded-lg">
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-green-600">
                    <i class="bx bx-user-voice text-2xl font-thin bg-green-300 text-green-600 p-2 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Auctions </span>
                </div>
                <div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Number
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $auction_number }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Finished
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $auction_finished }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Playing
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $auction_playing }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Waiting start
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $auction_waiting_start }}
                        </span>
                    </div>
                </div>
            </div>
            {{-- Cars --}}
            <div class="flex flex-col gap-5 w-[400px] m-[5px] p-[15px] shadow-2xl rounded-lg">
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-yellow-600">
                    <i class="bx bx-car text-2xl font-thin bg-yellow-300 text-yellow-600 p-2 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Cars </span>
                </div>
                <div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Number
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $car_number }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Amount of money (Sold out)
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            ${{ $car_amount }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Sold out
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $car_sold_out }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Did not sell
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $car_didnt_sell }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Not sold
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $car_not_sold }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Waiting validation
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $car_waiting_validation }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Second row --}}
        <div class="flex gap-3 justify-around">
            {{-- Users --}}
            <div class="flex flex-col gap-5 w-[400px] m-[5px] p-[15px] shadow-2xl rounded-lg">
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-violet-600">
                    <i class="bx bx-user text-2xl font-thin bg-violet-300 text-violet-600 p-2 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Users </span>
                </div>
                <div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Number
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $user_number }}
                        </span>
                    </div>
                </div>
            </div>
            {{-- Dealers --}}
            <div class="flex flex-col gap-5 w-[400px] m-[5px] p-[15px] shadow-2xl rounded-lg">
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-sky-600">
                    <i class="bx bx-user text-2xl font-thin bg-sky-300 text-sky-600 p-2 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Dealers </span>
                </div>
                <div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Number
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $dealer_number }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between my-[5px]">
                        <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                            Validated
                        </span>
                        <span class="text-sm px-3 py-px text-blue-500">
                            {{ $dealer_validated }}
                        </span>
                    </div>
                </div>
            </div>
            {{-- Operators --}}
            <div class="flex flex-col gap-5 w-[400px] m-[5px] p-[15px] shadow-2xl rounded-lg">
                <div class="flex items-center justify-center gap-2 h-auto w-full text-lg text-indigo-600">
                    <i class="bx bx-microphone text-2xl font-thin bg-indigo-300 text-indigo-600 p-2 rounded-md"></i>
                    <span class="inline-block font-medium text-xl"> Operators </span>
                </div>
                <div>
                    <div>
                        <div class="flex items-center justify-between my-[5px]">
                            <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                                Number
                            </span>
                            <span class="text-sm px-3 py-px text-blue-500">
                                {{ $operator_number }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between my-[5px]">
                            <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                                Validated
                            </span>
                            <span class="text-sm px-3 py-px text-blue-500">
                                {{ $operator_validated }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.app>
