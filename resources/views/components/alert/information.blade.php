<div class="p-4 text-blue-900 bg-blue-100 border border-blue-200 rounded-md m-1">
    <div class="flex justify-between flex-wrap">
        <div class="w-0 flex-1 flex">
            <div class="mr-3 pt-1"> <svg width="26" height="26" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor">
                    <path
                        d="M14.1667 17h-3.3334c-.5 0-.8333-.3146-.8333-.7865 0-.472.3333-.7865.8333-.7865H11.5c.0833 0 .1667-.0787.1667-.1573v-3.5394c0-.0786-.0834-.1573-.1667-.1573h-.6667c-.5 0-.8333-.3146-.8333-.7865S10.3333 10 10.8333 10h.8334c.9166 0 1.6666.7079 1.6666 1.573v3.7753c0 .0787.0834.1573.1667.1573h.6667c.5 0 .8333.3146.8333.7865 0 .472-.3333.7079-.8333.7079zM12.3 6c.6933 0 1.3.6067 1.3 1.3s-.52 1.3-1.3 1.3S11 7.9933 11 7.3 11.6067 6 12.3 6zM12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2">
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
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-700 text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                        Delete </button>
                    <span class="font-medium"> {{ $alert->getCreatedAt() }} </span>
                </form>
            </div>
        </div>
    </div>
</div>
