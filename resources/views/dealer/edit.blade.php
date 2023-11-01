@props([
    'cars' => App\Models\Car::orderByDesc('id')->get(),
    'dealers' => App\Models\Dealer::all(),
])

<x-layouts.app>

    <x-alerts.success />

    <form action="{{ route('dealers.update', ['dealer' => $dealer->id]) }}" method="POST"
        class="w-full my-5 flex flex-col items-center justify-center">
        @method('PUT')
        @csrf

        <x-show-card>

            <h2 class="text-[20px] text-gray-700 font-[700]"> Dealer id: {{ $dealer->id }} </h2>

            <x-card-item name="Firstname">
                <div>
                    <input type="text" name="firstname"
                        class="w-[150px] text-sm text-gray-400 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                        value="{{ old('firstname') ?? $dealer->firstname }}" />
                </div>
            </x-card-item>
            <x-v-error name="firstname" />

            <x-card-item name="Lastname">
                <div>
                    <input type="text" name="lastname"
                        class="w-[150px] text-sm text-gray-400 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                        value="{{ old('lastname') ?? $dealer->lastname }}" />
                </div>
            </x-card-item>
            <x-v-error name="lastname" />

            <x-card-item name="Contact">
                <div>
                    <input type="text" name="contact"
                        class="w-[150px] text-sm text-gray-400 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                        value="{{ old('contact') ?? $dealer->contact }}" />
                </div>
            </x-card-item>
            <x-v-error name="contact" />

        </x-show-card>

        <div class="mt-[10px]">
            <button type="submit"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-green-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Save
            </button>
        </div>

    </form>

</x-layouts.app>
