<div class="flex items-center justify-between">
    <div class="sm:flex hidden flex-col text-gray-400">
        {{ $first }}
        <div class="text-gray-600 text-xs">
            {{ $second }}
        </div>
    </div>
    @if ($slot ?? null)
        {{ $slot }}
    @endif
</div>
