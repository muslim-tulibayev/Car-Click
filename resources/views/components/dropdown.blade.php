<div class="flex flex-col justify-center">
    <div class="flex items-center justify-center">
        <div class=" relative inline-block text-left dropdown">
            <div class="block">
                <div class="inline relative">
                    <button type="button"
                        class="inline-flex items-center relative px-2 border rounded-full hover:shadow-lg">
                        <div class="pl-1">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                role="presentation" focusable="false"
                                style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3; overflow: visible;">
                                <g fill="none" fill-rule="nonzero">
                                    <path d="m2 16h28"></path>
                                    <path d="m2 24h28"></path>
                                    <path d="m2 8h28"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="block flex-grow-0 flex-shrink-0 h-10 w-12 pl-5">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                role="presentation" focusable="false"
                                style="display: block; height: 100%; width: 100%; fill: currentcolor;">
                                <path
                                    d="m16 .7c-8.437 0-15.3 6.863-15.3 15.3s6.863 15.3 15.3 15.3 15.3-6.863 15.3-15.3-6.863-15.3-15.3-15.3zm0 28c-4.021 0-7.605-1.884-9.933-4.81a12.425 12.425 0 0 1 6.451-4.4 6.507 6.507 0 0 1 -3.018-5.49c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5a6.513 6.513 0 0 1 -3.019 5.491 12.42 12.42 0 0 1 6.452 4.4c-2.328 2.925-5.912 4.809-9.933 4.809z">
                                </path>
                            </svg>
                        </div>
                    </button>
                </div>
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
