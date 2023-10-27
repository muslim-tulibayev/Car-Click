<!-- component -->
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

<div class="flex flex-row">
    <div class="flex flex-col w-[250px] overflow-hidden">
        <ul class="flex flex-col py-4">
            <li>
                <a href="{{ route('auctions.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-user-voice"></i></span>
                    <span class="text-sm font-medium">Auctions</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\Auction::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('cars.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-car"></i></span>
                    <span class="text-sm font-medium">Cars</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\Car::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-user"></i></span>
                    <span class="text-sm font-medium">Users</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\User::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('dealers.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-user"></i></span>
                    <span class="text-sm font-medium">Dealers</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\Dealer::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('operators.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-microphone"></i></span>
                    <span class="text-sm font-medium">Operators</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\Operator::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('set-webhook') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-reset"></i></span>
                    <span class="text-sm font-medium">Webhook</span>
                    {{-- <span class="ml-auto mr-6 text-sm bg-green-100 rounded-full px-3 py-px text-green-500">
                        set
                    </span> --}}
                </a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-cog"></i></span>
                    <span class="text-sm font-medium">Settings</span>
                    {{-- <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\Setting::count() }}
                    </span> --}}
                </a>
            </li>
        </ul>
    </div>
</div>
