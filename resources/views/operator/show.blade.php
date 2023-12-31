<x-layouts.app>

    <div class="w-full my-5 flex flex-col items-center justify-center">
        <x-show-card>
            <h2 class="text-[20px] text-gray-700 font-[700]"> Operator id: {{ $operator->id }} </h2>
            <x-card-item name="Operator">
                <x-two-row-text :first="$operator->firstname" :second="$operator->lastname" />
            </x-card-item>
            <x-card-item name="Contact">
                <span class="text-sm text-green-500">
                    {{ $operator->contact }}
                </span>
            </x-card-item>
            <x-card-item name="Is Validated">
                @if ($operator->is_validated)
                    <span class="text-sm text-green-500"> True </span>
                @else
                    <span class="text-sm text-red-500"> False </span>
                @endif
            </x-card-item>
            <x-card-item name="Is Muted">
                @if ($operator->is_muted)
                    <span class="text-sm text-green-500"> True </span>
                @else
                    <span class="text-sm text-red-500"> False </span>
                @endif
            </x-card-item>
            <x-card-item name="Telegram chat">
                @if ($operator->tg_chat)
                <a href="{{ route('operatorchats.show', ['operatorchat' => $operator->tg_chat->id]) }}"
                    class="font-medium bg-gray-200 rounded-md py-1 px-5"> Show </a>
            @else
                <span> Not available </span>
            @endif
            </x-card-item>
        </x-show-card>
        <x-show-btns-bar name="operator" :item="$operator" />
        <x-delete-modal name="Operator" :item="$operator" :route="route('operators.destroy', ['operator' => $operator->id])" />
    </div>

</x-layouts.app>
