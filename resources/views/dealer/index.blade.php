<x-layouts.app>

    <x-alerts.success />

    <x-search-bar name="dealers" :types="App\Models\Dealer::fillables()" :oldcol="$oldcol ?? null" :oldval="$oldval ?? null" />

    <div class="p-4">
        <div class="w-full">
            <div class="w-full flex text-gray-400 px-2">
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> ID </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Dealer </h1>
                <h1 class="inline-block flex-1 font-normal pb-2 px-1"> Contact </h1>
                <h1 class="inline-block w-[100px] font-normal pb-2 px-1 opacity-0"> List btns </h1>
            </div>
            <div class="text-gray-600">
                @foreach ($dealers as $dealer)
                    <x-list-item name="dealer" :item="$dealer">
                        {{-- id --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $dealer->id }}
                        </div>
                        {{-- Dealer --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$dealer->firstname" :second="$dealer->lastname" />
                        </div>
                        {{-- contact --}}
                        <div class="inline-block flex-1 py-2 px-1">
                            {{ $dealer->contact }}
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
