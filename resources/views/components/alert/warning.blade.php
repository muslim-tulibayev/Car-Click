<div class="p-4 text-yellow-900 bg-yellow-100 border border-yellow-200 rounded-md m-1">
    <div class="flex justify-between flex-wrap">
        <div class="w-0 flex-1 flex">
            <div class="mr-3 pt-1"> <svg width="26" height="26" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor">
                    <path
                        d="M13.6086 3.247l8.1916 15.8c.0999.2.1998.5.1998.8 0 1-.7992 1.8-1.7982 1.8H3.7188c-.2997 0-.4995-.1-.7992-.2-.7992-.5-1.1988-1.5-.6993-2.4 5.3067-10.1184 8.0706-15.385 8.2915-15.8.3314-.6222.8681-.8886 1.4817-.897.6135-.008 1.273.2807 1.6151.897zM12 18.95c.718 0 1.3-.582 1.3-1.3 0-.718-.582-1.3-1.3-1.3-.718 0-1.3.582-1.3 1.3 0 .718.582 1.3 1.3 1.3zm-.8895-10.203v5.4c0 .5.4.9.9.9s.9-.4.9-.9v-5.3c0-.5-.4-.9-.9-.9s-.9.4-.9.8z">
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
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-500 text-base font-medium text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:w-auto sm:text-sm">
                        Delete </button>
                    <span class="font-medium"> {{ $alert->getCreatedAt() }} </span>
                </form>
            </div>
        </div>
    </div>
</div>
