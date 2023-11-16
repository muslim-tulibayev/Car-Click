<div class="flex flex-col justify-center">
    <div class="flex items-center justify-center">
        <div class=" relative inline-block text-left dropdown">
            <div class="block">
                <button type="button" class="inline-flex items-center relative rounded-md py-[2px] px-2 hover:bg-gray-100">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"
                        focusable="false"
                        style="display: block; fill: none; height: 20px; width: 20px; stroke: currentcolor; stroke-width: 3; overflow: visible;">
                        <g fill="none" fill-rule="nonzero">
                            <path d="m2 16h28"></path>
                            <path d="m2 24h28"></path>
                            <path d="m2 8h28"></path>
                        </g>
                    </svg>
                </button>
            </div>
            <div
                class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95">
                <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                    aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                    <div class="px-4 py-3">
                        <p class="text-sm leading-5">Signed in as</p>
                        <p class="text-sm font-medium leading-5 text-gray-900 truncate">
                            {{ auth()->user()->username }}
                        </p>
                    </div>
                    <div class="py-1 hover:bg-gray-100">
                        <a href="{{ route('profile.edit') }}" tabindex="0" role="menuitem"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left">
                            Account settings
                        </a>
                    </div>
                    <div class="py-1 hover:bg-gray-100">
                        <a href="{{ route('logout') }}" tabindex="3"
                            class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                            role="menuitem">Sign out</a>
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
