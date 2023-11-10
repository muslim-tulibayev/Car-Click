<div class="p-4 text-green-900 bg-green-100 border border-green-200 rounded-md m-1">
    <div class="flex justify-between flex-wrap">
        <div class="w-0 flex-1 flex">
            <div class="mr-3 pt-1"> <svg width="26" height="26" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor">
                    <path
                        d="M8.445 12.6675A.9.9 0 0 0 7.1424 13.91l2.5726 2.7448c.3679.3856.9884.3689 1.335-.036l5.591-7.0366a.9.9 0 0 0-1.3674-1.1705l-4.6548 5.9132a.4.4 0 0 1-.607.0252l-1.567-1.6826zM1.9995 12c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z">
                    </path>
                </svg> </div>
            <div class="flex-1">
                <h4 class="text-md leading-6 font-medium capitalize"> {{ $alert->type }} </h4>
                <p class="text-sm"> {{ $alert->message }} </p>
                <form action="{{ route('alerts.destroy', ['alert' => $alert->id]) }}" method="POST"
                    class="flex items-center justify-between mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                        Delete </button>
                    <span class="font-medium"> {{ $alert->getCreatedAt() }} </span>
                </form>
            </div>
        </div>
    </div>
</div>
