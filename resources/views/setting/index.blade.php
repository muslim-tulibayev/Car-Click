<x-layouts.empty-app>
    <div class="h-full w-full relative">
        <div class="w-[50%] h-auto mx-auto">

            <x-btns.back />

            <div class="w-full">
                <h1 class="font-medium text-xl w-[70%] mb-2"> Settings </h1>

                <x-settings-list-item>
                    <span class="text-sm text-blue-500 font-medium">
                        Auction expire duration and Telegram system language
                    </span>
                    <a href="{{ route('settings.edit', ['setting' => $setting->id]) }}"
                        class="flex items-center justify-center w-[120px] h-[30px] my-2 rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                        Update
                    </a>
                </x-settings-list-item>

                <x-settings-list-item>
                    <span class="text-sm text-blue-500 font-medium">
                        Webhook
                    </span>
                    <a href="{{ route('set-webhook') }}"
                        class="flex items-center justify-center w-[120px] h-[30px] my-2 rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                        Set
                    </a>
                </x-settings-list-item>

                <x-settings-list-item>
                    <span class="text-sm text-blue-500 font-medium">
                        Alerts
                    </span>
                    <a href="{{ route('alerts.index') }}"
                        class="flex items-center justify-center w-[120px] h-[30px] my-2 rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                        Show
                    </a>
                </x-settings-list-item>

                <x-settings-list-item>
                    <span class="text-sm text-blue-500 font-medium">
                        Set telegram commands
                    </span>
                    <a href="{{ route('set-tg-cmds') }}"
                        class="flex items-center justify-center w-[120px] h-[30px] my-2 rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                        Set
                    </a>
                </x-settings-list-item>
            </div>

        </div>
    </div>
</x-layouts.empty-app>
