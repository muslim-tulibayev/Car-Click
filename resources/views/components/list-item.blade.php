<div class="flex items-center shadow-md rounded-md px-2 hover:bg-gray-100 cursor-pointer">

    <a href="{{ route($name . 's.show', [$name => $item->id]) }}" class="flex items-center w-full">
        {{ $slot }}
    </a>

    <div class="flex items-center justify-end gap-2 w-[100px]">
        <a href="{{ route($name . 's.edit', [$name => $item->id]) }}"
            class="inline-flex items-center justify-center text-xl text-blue-400"><i class="bx bx-edit-alt"></i></a>
        <span class="inline-flex items-center justify-center text-xl text-red-400 delete-button cursor-pointer"
            data-id="{{ $item->id }}"><i class="bx bx-trash"></i></span>
    </div>

</div>
