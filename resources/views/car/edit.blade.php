@props([
    'condition_list' => App\Models\Car::conditionList(),
    'status_list' => App\Models\Car::statusList(),
    'users_list' => App\Models\User::all(),
    'dealers_list' => App\Models\Dealer::all(),
])

<x-layouts.app>

    @if (session('alert_success'))
        <x-alerts.success :message="session('alert_success')" />
    @endif

    <form action="{{ route('cars.update', ['car' => $car->id]) }}" method="POST"
        class="w-full mt-[20px] flex flex-col items-center">

        @method('PUT')
        @csrf

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Car id: {{ $car->id }} </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Company
                </span>
                <input type="text" name="company"
                    class="w-[150px] text-sm text-gray-700 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                    value="{{ old('company') ?? $car->company }}" />
            </div>
            @error('company')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Model
                </span>
                <input type="text" name="model"
                    class="w-[150px] text-sm text-gray-700 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                    value="{{ old('model') ?? $car->model }}" />
            </div>
            @error('model')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Color
                </span>
                <input type="text" name="color"
                    class="w-[150px] text-sm text-gray-700 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                    value="{{ old('color') ?? $car->color }}" />
            </div>
            @error('color')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Year
                </span>
                <input type="number" name="year"
                    class="w-[150px] text-sm text-gray-700 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                    value="{{ old('year') ?? $car->year }}" />
            </div>
            @error('year')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Condition
                </span>
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="condition"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($condition_list as $condition)
                            <option value="{{ $condition }}" 
                                @if (old('condition'))
                                    @if (old('condition') == $condition)
                                        selected
                                    @endif
                                @else
                                    @if ($car->condition === $condition)
                                        selected
                                    @endif
                                @endif>
                                {{ $condition }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('condition')
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
                    <select name="status"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($status_list as $status)
                            <option value="{{ $status }}" 
                                @if (old('status'))
                                    @if (old('status') == $status)
                                        selected
                                    @endif
                                @else
                                    @if ($car->status === $status)
                                        selected
                                    @endif
                                @endif>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('status')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Additional
                </span>
                <textarea maxlength="255" name="additional"
                    class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-start outline-none focus:bg-gray-300">{{ $car->additional }}</textarea>
            </div>
            @error('additional')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Owner
                </span>
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="user_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        <option value=""> Null </option>
                        @foreach ($users_list as $user)
                            <option value="{{ $user->id }}" 
                                @if (old('user_id'))
                                    @if (old('user_id') == $user->id)
                                        selected
                                    @endif
                                @else
                                    @if ($car->user_id === $user->id)
                                        selected
                                    @endif
                                @endif>
                                {{ $user->firstname . ' ' . $user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('user_id')
                <p class="text-red-600 bg-red-100 rounded-md text-[14px] py-[3px] px-[5px]"> {{ $message }} </p>
            @enderror

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Winner
                </span>
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="dealer_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        <option value=""> Null </option>
                        @foreach ($dealers_list as $dealer)
                            <option value="{{ $dealer->id }}" 
                                @if (old('dealer_id'))
                                    @if (old('dealer_id') == $dealer->id)
                                        selected
                                    @endif
                                @else
                                    @if ($car->dealer_id === $dealer->id)
                                        selected
                                    @endif
                                @endif>
                                {{ $dealer->firstname . ' ' . $dealer->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('dealer_id')
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
