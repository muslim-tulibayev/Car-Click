@props([
    'cars' => App\Models\Car::orderByDesc('id')->get(),
    'dealers' => App\Models\Dealer::all(),
])

<x-layouts.app>

    @if (session('alert_success'))
        <x-alerts.success :message="session('alert_success')" />
    @endif

    <form action="{{ route('auctions.update', ['auction' => $auction->id]) }}" method="POST"
        class="w-full mt-[20px] flex flex-col items-center">

        @method('PUT')
        @csrf

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Auction id: {{ $auction->id }} </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Car
                </span>
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="car_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}" @if ($auction->car->id === $car->id) selected @endif>
                                {{ 'ID: ' . $car->id }}, {{ $car->company }} {{ $car->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('car_id')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Starting price
                </span>
                <div>
                    <span class="text-green-500"> $ </span>
                    <input type="number" name="starting_price"
                        class="w-[100px] text-sm text-green-500 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                        value="{{ old('starting_price') ?? $auction->starting_price }}" />
                </div>
            </div>
            @error('starting_price')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Highest price
                </span>
                <div>
                    <span class="text-green-500"> $ </span>
                    <input type="number" name="highest_price"
                        class="w-[100px] text-sm text-green-500 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                        value="{{ old('highest_price') ?? $auction->highest_price }}" />
                </div>
            </div>
            @error('highest_price')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Highest price owner
                </span>
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="highest_price_owner_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}" @if ($auction->highestPriceOwner and $auction->highestPriceOwner->id === $dealer->id) selected @endif>
                                {{ $dealer->lastname }} {{ $dealer->firstname[0] }}.
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('highest_price_owner_id')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Status
                </span>
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="life_cycle"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($auction->lifeCycleList() as $item)
                            <option value="{{ $auction->life_cycle }}"
                                @if ($auction->life_cycle === $item) selected @endif>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('life_cycle')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Start
                </span>
                <input type="datetime-local" name="start"
                    value="{{ old('start') ?? $auction->getStart('Y-m-d H:i') }}"
                    class="px-[5px] rounded-md bg-gray-100 outline-none" />
            </div>
            @error('start')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Finish
                </span>
                <input type="datetime-local" name="finish"
                    value="{{ old('finish') ?? $auction->getFinish('Y-m-d H:i') }}"
                    class="px-[5px] rounded-md bg-gray-100 outline-none" />
            </div>
            @error('finish')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

        </div>
        <div class="mt-[10px]">
            <button type="submit"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-green-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Save
            </button>
        </div>

    </form>

</x-layouts.app>
