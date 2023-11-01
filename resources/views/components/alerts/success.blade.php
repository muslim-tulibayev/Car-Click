@if (session('alert_success'))
    <div class="p-4 text-green-900 bg-green-100 border border-green-200 rounded-md m-1" id="alertSuccess">
        <div class="flex justify-between flex-wrap">
            <div class="w-0 flex-1 flex">
                <div class="mr-3 pt-1"> <svg width="26" height="26" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path
                            d="M8.445 12.6675A.9.9 0 0 0 7.1424 13.91l2.5726 2.7448c.3679.3856.9884.3689 1.335-.036l5.591-7.0366a.9.9 0 0 0-1.3674-1.1705l-4.6548 5.9132a.4.4 0 0 1-.607.0252l-1.567-1.6826zM1.9995 12c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z">
                        </path>
                    </svg> </div>
                <div>
                    <h4 class="text-md leading-6 font-medium"> {{ session('alert_success')->primary }} </h4>
                    <p class="text-sm"> {{ session('alert_success')->text }} </p>
                    <div class="flex mt-3">
                        <button onclick="closeAlertSuccess()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <button onclick="closeAlertSuccess()"
                    class="rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor">
                        <path
                            d="M17.6555 6.3331a.9.9 0 0 1 .001 1.2728l-4.1032 4.1085a.4.4 0 0 0 0 .5653l4.1031 4.1088a.9002.9002 0 0 1 .0797 1.1807l-.0806.092a.9.9 0 0 1-1.2728-.0009l-4.1006-4.1068a.4.4 0 0 0-.5662 0l-4.099 4.1068a.9.9 0 1 1-1.2738-1.2718l4.1027-4.1089a.4.4 0 0 0 0-.5652L6.343 7.6059a.9002.9002 0 0 1-.0796-1.1807l.0806-.092a.9.9 0 0 1 1.2728.0009l4.099 4.1055a.4.4 0 0 0 .5662 0l4.1006-4.1055a.9.9 0 0 1 1.2728-.001z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeAlertSuccess() {
            alertSuccess.classList.add('hidden')
        }
    </script>
@endif
