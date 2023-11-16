<x-layouts.empty-app>
    <div class="h-full w-full relative">
        <div class="w-[50%] h-auto mx-auto">

            <x-btns.back />

            <x-alerts.success />

            <div class="w-full">
                <div class="flex items-center justify-between mx-2 mb-2">
                    <h1 class="font-medium text-xl w-[70%] mb-2"> Alerts </h1>
                    <form action="{{ route('alerts.destroy-all') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-md bg-red-500 hover:bg-red-700 font-medium text-white py-1 px-5">
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

        </div>
    </div>
</x-layouts.empty-app>
