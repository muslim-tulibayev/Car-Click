<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Userchat id: {{ $userchat->id }} </h2>

            {{-- chat_id --}}
            <x-card-item name="Chat id (in Tg)">
                <span> {{ $userchat->chat_id }} </span>
            </x-card-item>

            {{-- User --}}
            <x-card-item name="User">
                @if ($userchat->user)
                    <a href="{{ route('users.show', ['user' => $userchat->user->id]) }}">
                        <x-two-row-text :first="$userchat->user->firstname" :second="$userchat->user->lastname" />
                    </a>
                @else
                    <span> Not available </span>
                @endif
            </x-card-item>

            {{-- action --}}
            <x-card-item name="Action">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify overflow-auto">
                    {{ $userchat->action }}
                </p>
            </x-card-item>

            {{-- data --}}
            <x-card-item name="Data">
                <p class="w-[300px] p-2 bg-gray-100 rounded-md text-gray-500 text-sm text-justify overflow-auto">
                    {{ $userchat->data }}
                </p>
            </x-card-item>

            {{-- lang --}}
            <x-card-item name="Lang">
                <span> {{ $userchat->lang }} </span>
            </x-card-item>

        </x-show-card>
        <x-show-btns-bar name="userchat" :item="$userchat" />
        <x-delete-modal name="Userchat" :item="$userchat" :route="route('userchats.destroy', ['userchat' => $userchat->id])" />
    </div>

</x-layouts.app>
