<x-layouts.app>

    <x-alerts.success />

    <div class="sm:p-7 p-4">
        <div class="w-full text-left">
            <div class="block w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> ID </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Dealer </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Contact </h1>
                </div>
            </div>
            <div class="text-gray-600 dark:text-gray-100">
                @foreach ($dealers as $dealer)
                    <x-list-item>
                        <div class="flex-1 text-gray-600">
                            {{ $dealer->id }}
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$dealer->firstname" :second="$dealer->lastname" />
                        </div>
                        <div class="flex items-center justify-between flex-1 py-2 px-1">
                            <div class="sm:p-3 inline-block flex-1 py-2 px-1">
                                <div class="flex items-center text-blue-600 text-sm"> {{ $dealer->contact }} </div>
                            </div>
                            <x-list-dropdown name="dealer" :item="$dealer" />
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Dealer" :item="$dealer" :route="route('dealers.destroy', ['dealer' => $dealer->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $dealers->links() }}
        </div>
    </div>

</x-layouts.app>
