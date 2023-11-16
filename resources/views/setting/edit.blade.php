@props([
    'langs_list' => App\Models\Setting::langsList(),
])

<x-layouts.empty-app>
    <div class="h-full w-full relative">
        <div class="w-[50%] h-auto mx-auto">

            <x-btns.back />

            <x-alerts.success />

            <form action="{{ route('settings.update', ['setting' => $setting->id]) }}" method="POST"
                class="w-full mt-[20px] flex flex-col items-center">

                @method('PUT')
                @csrf

                <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
                    <h2 class="text-[20px] text-gray-700 font-[700]"> Setting </h2>

                    {{-- auction_expire_duration --}}
                    <x-card-item name="Auction expire duration (in mins)">
                        <div>
                            <input type="number" name="auction_expire_duration"
                                class="w-[150px] text-sm text-gray-400 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                                value="{{ old('auction_expire_duration') ?? $setting->auction_expire_duration }}" />
                        </div>
                    </x-card-item>
                    <x-v-error name="auction_expire_duration" />

                    {{-- system_lang --}}
                    <x-card-item name="System language (In Telegram)">
                        <div class="relative inline-flex">
                            <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                                <path
                                    d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                                    fill="#648299" fill-rule="nonzero" />
                            </svg>
                            <select name="system_lang"
                                class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                                @foreach ($langs_list as $system_lang)
                                    <option value="{{ $system_lang }}"
                                        @if (old('system_lang')) @if (old('system_lang') == $system_lang) selected @endif
                                    @else @if ($setting->system_lang === $system_lang) selected @endif @endif>
                                        {{ $system_lang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </x-card-item>
                    <x-v-error name="system_lang" />
                </div>

                <div class="mt-[10px]">
                    <button type="submit"
                        class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-green-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-layouts.empty-app>
