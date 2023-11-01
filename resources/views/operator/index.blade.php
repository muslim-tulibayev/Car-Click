<x-layouts.app>

    <x-alerts.success />

    <div class="sm:p-7 p-4">
        <div class="w-full text-left">
            <div class="block w-full">
                <div class="text-gray-400 flex w-full">
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> ID </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Operator </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Contact </h1>
                    <h1 class="flex-1 font-normal px-3 pt-0 pb-3"> Validated </h1>
                </div>
            </div>
            <div class="text-gray-600 dark:text-gray-100">
                @foreach ($operators as $operator)
                    <x-list-item>
                        <div class="flex-1 text-gray-600">
                            {{ $operator->id }}
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <x-two-row-text :first="$operator->firstname" :second="$operator->lastname" />
                        </div>
                        <div class="inline-block flex-1 py-2 px-1">
                            <div class="flex items-center text-blue-600 text-sm">{{ $operator->contact }}</div>
                        </div>
                        <div class="flex items-center justify-between flex-1 py-2 px-1">
                            @if ($operator->is_validated)
                                <div class="flex items-center text-green-500"> True </div>
                            @else
                                <div class="flex items-center text-red-500"> False </div>
                            @endif
                            <x-list-dropdown name="operator" :item="$operator" />
                        </div>
                    </x-list-item>
                    <x-delete-modal name="Operator" :item="$operator" :route="route('operators.destroy', ['operator' => $operator->id])" />
                @endforeach
            </div>
        </div>
        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $operators->links() }}
        </div>
    </div>

</x-layouts.app>
