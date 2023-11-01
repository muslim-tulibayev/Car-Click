<div class="flex flex-col justify-center">
    <div class="flex items-center justify-center">
        <div class="inline-block text-left dropdown">
            <div class="block">
                <div class="inline">
                    <button type="button"
                        class="inline-flex items-center px-2 rounded-full hover:shadow-lg text-gray-400">
                        <svg viewBox="0 0 24 24" class="w-5" stroke="currentColor" stroke-width="2" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </button>
                </div>
            </div>
            <div
                class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg outline-none overflow-hidden"
                    aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                    <div class="py-1 hover:bg-gray-100">
                        <a href="{{ route($name . 's.show', [$name => $item->id]) }}" tabindex="0" role="menuitem"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                            Show
                        </a>
                    </div>
                    <div class="py-1 hover:bg-gray-100">
                        <a href="{{ route($name . 's.edit', [$name => $item->id]) }}" tabindex="0" role="menuitem"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                            Edit
                        </a>
                    </div>
                    <div class="py-1 hover:bg-gray-100 delete-button" data-id="{{ $item->id }}">
                        <a tabindex="0" role="menuitem"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .dropdown:focus-within .dropdown-menu {
        opacity: 1;
        transform: translate(0) scale(1);
        visibility: visible;
    }
</style>
