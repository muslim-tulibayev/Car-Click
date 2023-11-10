<x-layouts.app>

    <x-alerts.success />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> User </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Contact </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>
            <div class="text-gray-600">
                @foreach ($users as $user)
                    <x-list-item name="user" :item="$user">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $user->id }}
                        </div>
                        {{-- User --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$user->firstname" :second="$user->lastname" />
                        </div>
                        {{-- contact --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $user->contact }}
                        </div>
                    </x-list-item>
                    <x-delete-modal name="User" :item="$user" :route="route('users.destroy', ['user' => $user->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $users->links() }}
        </div>
    </div>

</x-layouts.app>
