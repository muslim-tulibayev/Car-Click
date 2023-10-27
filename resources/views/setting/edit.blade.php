<x-layouts.app>

    @if (session('alert_success'))
        <x-alerts.success :message="session('alert_success')" />
    @endif

    <form action="{{ route('settings.update', ['setting' => $setting->id]) }}" method="POST"
        class="w-full mt-[20px] flex flex-col items-center">

        @method('PUT')
        @csrf

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Setting </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Auction expire duration
                </span>
                <input type="number" name="auction_expire_duration"
                    class="w-[150px] text-sm text-gray-700 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                    value="{{ old('auction_expire_duration') ?? $setting->auction_expire_duration }}" />
            </div>
            @error('auction_expire_duration')
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
