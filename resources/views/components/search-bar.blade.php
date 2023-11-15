<div class="w-[70%] mx-auto flex items-center h-12 rounded-lg shadow-lg bg-gray-50 overflow-hidden px-2">

    <div class="relative inline-flex border-r border-gray-300">
        <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 412 232">
            <path
                d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                fill="#648299" fill-rule="nonzero" />
        </svg>
        <select id="searchSelect" class="text-gray-500 px-[10px] bg-gray-50 outline-none appearance-none">
            @foreach ($types as $type)
                <option value="{{ $type }}" @if ($oldcol == $type) selected @endif>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <input type="text" id="searchInput" onkeydown="onInput()" value="{{ $oldval }}"
        x-route={{ route($name . '.search', ['col' => 'column_val', 'val' => 'value_val']) }}
        placeholder="Search something..." class="flex-1 outline-none text-gray-500 bg-gray-50 px-2" />

    <button onclick="search()" class="flex items-center justify-center text-gray-500 pl-2 border-l border-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>
</div>

<script>
    function search() {
        if (searchSelect.value === '') return
        if (searchInput.value === '') return

        window.location.href = searchInput.getAttribute('x-route')
            .replace(/column_val/, searchSelect.value)
            .replace(/value_val/, searchInput.value)
    }

    function onInput() {
        if (event.keyCode === 13)
            search()
    }
</script>
