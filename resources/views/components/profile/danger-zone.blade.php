<x-profile.delete-modal />

<div class="w-[70%] mx-auto">
    <h1 class="font-bold text-2xl w-[70%] mb-2"> Danger Zone </h1>
    <div class="p-4 text-red-900 bg-red-100 border border-red-200 rounded-md">
        <div class="flex justify-between flex-wrap">
            <div class="w-0 flex-1 flex">
                <div class="mr-3 pt-1">
                    <svg width="26" height="26" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor">
                        <path
                            d="M13.6086 3.247l8.1916 15.8c.0999.2.1998.5.1998.8 0 1-.7992 1.8-1.7982 1.8H3.7188c-.2997 0-.4995-.1-.7992-.2-.7992-.5-1.1988-1.5-.6993-2.4 5.3067-10.1184 8.0706-15.385 8.2915-15.8.3314-.6222.8681-.8886 1.4817-.897.6135-.008 1.273.2807 1.6151.897zM12 18.95c.718 0 1.3-.582 1.3-1.3 0-.718-.582-1.3-1.3-1.3-.718 0-1.3.582-1.3 1.3 0 .718.582 1.3 1.3 1.3zm-.8895-10.203v5.4c0 .5.4.9.9.9s.9-.4.9-.9v-5.3c0-.5-.4-.9-.9-.9s-.9.4-.9.8z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-md leading-6 font-medium">
                        Deleting current account - This process cannot be undone
                    </h4>
                    <div class="flex mt-3">
                        <button type="button" onclick="showModal()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal() {
        accountDeleteModal.classList.remove('hidden')
        accountDeleteModal.classList.add('flex')
    }
</script>
