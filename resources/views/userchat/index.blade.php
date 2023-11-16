<x-layouts.app :searchbar="true" name="userchats" :types="App\Models\UserChat::fillables()" :oldcol="$oldcol ?? null" :oldval="$oldval ?? null">

    <x-alerts.success />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Chat id (in Tg) </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> User </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Language </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>

            <div class="text-gray-600">
                @foreach ($userchats as $userchat)
                    <x-list-item name="userchat" :item="$userchat">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $userchat->id }}
                        </div>

                        {{-- chat_id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $userchat->chat_id }}
                        </div>

                        {{-- User --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            @if ($userchat->user)
                                <x-two-row-text :first="$userchat->user->firstname" :second="$userchat->user->lastname" />
                            @else
                                <span> Not available </span>
                            @endif
                        </div>

                        {{-- lang --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $userchat->lang }}
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Userchat" :item="$userchat" :route="route('userchats.destroy', ['userchat' => $userchat->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $userchats->links() }}
        </div>
    </div>

</x-layouts.app>
