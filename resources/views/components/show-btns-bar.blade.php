<div class="mt-[10px]">
    <button
        class="w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-red-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)] delete-button"
        data-id="{{ $item->id }}">
        Delete
    </button>
    <a href="{{ route($name . 's.edit', [$name => $item->id]) }}"
        class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
        Update
    </a>
</div>
