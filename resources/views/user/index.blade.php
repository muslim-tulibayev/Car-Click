<x-layouts.app>

    <x-alerts.success />

    <div class="sm:p-7 p-4">
        <div class="w-full text-left">
            <div class="block w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> ID </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> User </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Contact </h1>
                </div>
            </div>
            <div class="text-gray-600 dark:text-gray-100">
                @foreach ($users as $user)
                    <x-list-item>
                        <div class="flex-1 text-gray-600">
                            {{ $user->id }}
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$user->firstname" :second="$user->lastname" />
                        </div>
                        <div class="flex items-center justify-between flex-1 py-2 px-1">
                            <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                                <div class="flex items-center text-blue-600 text-sm"> {{ $user->contact }} </div>
                            </div>
                            <x-list-dropdown name="user" :item="$user" />
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
