<div class="flex flex-row">
    <div class="flex flex-col w-[250px] overflow-hidden">
        <ul class="flex flex-col">
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
                <a href="{{ route('userchats.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-chat"></i></span>
                    <span class="text-sm font-medium">User chats</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\UserChat::count() }}
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
                <a href="{{ route('dealerchats.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-chat"></i></span>
                    <span class="text-sm font-medium">Dealer chats</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\DealerChat::count() }}
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
                <a href="{{ route('operatorchats.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-chat"></i></span>
                    <span class="text-sm font-medium">Operator chats</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\OperatorChat::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('queues.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-task"></i></span>
                    <span class="text-sm font-medium">Tasks</span>
                    <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                        {{ App\Models\Queue::count() }}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}"
                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                    <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                            class="bx bx-cog"></i></span>
                    <span class="text-sm font-medium">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
