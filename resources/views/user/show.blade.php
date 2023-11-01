<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> User id: {{ $user->id }} </h2>
            <x-card-item name="User">
                <x-two-row-text :first="$user->firstname" :second="$user->lastname" />
            </x-card-item>
            <x-card-item name="Contact">
                <span class="text-sm text-green-500">
                    {{ $user->contact }}
                </span>
            </x-card-item>
        </x-show-card>
        <x-show-btns-bar name="user" :item="$user" />
        <x-delete-modal name="User" :item="$user" :route="route('users.destroy', ['user' => $user->id])" />
    </div>

</x-layouts.app>
