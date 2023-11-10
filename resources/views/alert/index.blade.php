<x-layouts.app>

    <x-alerts.success />

    <div class="w-full">
        <div class="flex items-center justify-between mx-2 mb-2">
            <h2 class="text-gray-700 text-[20px] font-[700]"> Alerts </h2>
            <form action="{{ route('alerts.destroy-all') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-md bg-red-500 hover:bg-red-700 font-medium text-white py-1 px-5">
                    Clear All </button>
            </form>
        </div>

        @foreach ($alerts as $alert)
            @if ($alert->type === 'success')
                <x-alert.success :alert="$alert" />
            @elseif ($alert->type === 'information')
                <x-alert.information :alert="$alert" />
            @elseif ($alert->type === 'warning')
                <x-alert.warning :alert="$alert" />
            @elseif ($alert->type === 'error')
                <x-alert.error :alert="$alert" />
            @endif
        @endforeach

        <div class="w-[70%] mx-auto mt-[20px] mb-[150px]">
            {{ $alerts->links() }}
        </div>

    </div>

</x-layouts.app>
