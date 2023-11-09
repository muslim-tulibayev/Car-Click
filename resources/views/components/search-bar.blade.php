<div class="h-auto w-full mb-5">
    <div class="relative flex items-center w-[70%] mx-auto h-12 rounded-lg shadow-lg bg-gray-50 overflow-hidden">
        <div class="grid place-items-center h-full w-12 text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <input type="text" name="value" id="searchBar" onchange="search()" value="{{ $value }}"
            x-route={{ route($name . '.search', ['search' => 'search_value']) }} placeholder="Search something..."
            class="peer h-full w-full outline-none text-sm text-gray-700 pr-2 bg-gray-50" />
    </div>
</div>

<script>
    function search() {
        if (searchBar.value === '') return
        window.location.href = searchBar.getAttribute('x-route').replace(/search_value/, searchBar.value)
    }
</script>
