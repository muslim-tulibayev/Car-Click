<nav class="w-full h-[60px] flex justify-between items-center px-8">
    <a href="{{ route('home') }}">
        <h1 class="font-[700] text-[25px]"> Programmer uz </h1>
    </a>

    @if ($searchbar)
        <x-search-bar :name="$name" :types="$types" :oldcol="$oldcol" :oldval="$oldval" />
    @endif

    <x-dropdown />
</nav>
