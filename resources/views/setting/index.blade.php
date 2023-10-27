<x-layouts.app>

    <div class="w-full m-[20px] flex flex-col items-center justify-center">

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Setting </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Auction expire duration
                </span>
                <span class="text-sm px-3 py-px text-blue-500">
                    {{ $setting->auction_expire_duration }} minutes
                </span>
            </div>

        </div>
        <div class="mt-[10px]">
            <a href="{{ route('settings.edit', ['setting' => $setting->id]) }}"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Update
            </a>
        </div>

    </div>

</x-layouts.app>
