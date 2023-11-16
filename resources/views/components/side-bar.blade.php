@props([
    'items' => [
        (object) [
            'name' => 'auctions',
            'icon' => 'bx-user-voice',
            'count' => App\Models\Auction::count(),
        ],
        (object) [
            'name' => 'cars',
            'icon' => 'bx-car',
            'count' => App\Models\Car::count(),
        ],
        (object) [
            'name' => 'users',
            'icon' => 'bx-user',
            'count' => App\Models\User::count(),
        ],
        (object) [
            'name' => 'userchats',
            'icon' => 'bx-chat',
            'count' => App\Models\UserChat::count(),
        ],
        (object) [
            'name' => 'dealers',
            'icon' => 'bx-user',
            'count' => App\Models\Dealer::count(),
        ],
        (object) [
            'name' => 'dealerchats',
            'icon' => 'bx-chat',
            'count' => App\Models\DealerChat::count(),
        ],
        (object) [
            'name' => 'operators',
            'icon' => 'bx-microphone',
            'count' => App\Models\Operator::count(),
        ],
        (object) [
            'name' => 'operatorchats',
            'icon' => 'bx-chat',
            'count' => App\Models\OperatorChat::count(),
        ],
        (object) [
            'name' => 'tasks',
            'icon' => 'bx-task',
            'count' => App\Models\Task::count(),
        ],
    ],
])

<div class="flex flex-row">
    <div class="flex flex-col w-[250px] overflow-hidden">
        <ul class="flex flex-col pl-1">

            @foreach ($items as $item)
                <li class="rounded-md border-gray-300 @if (request()->routeIs($item->name) or
                        request()->routeIs($item->name . '.index') or
                        request()->routeIs($item->name . '.create') or
                        request()->routeIs($item->name . '.show') or
                        request()->routeIs($item->name . '.edit') or
                        request()->routeIs($item->name . '.search')) bg-gray-200 @endif">
                    <a href="{{ route($item->name . '.index') }}"
                        class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                class="bx {{ $item->icon }}"></i></span>
                        <span class="text-sm font-medium capitalize"> {{ $item->name }} </span>
                        <span class="ml-auto mr-6 text-sm bg-blue-100 rounded-full px-3 py-px text-blue-500">
                            {{ $item->count }}
                        </span>
                    </a>
                </li>
            @endforeach

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
