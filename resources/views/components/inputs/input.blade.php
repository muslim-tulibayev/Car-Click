<input required type="{{ $type ?? 'text' }}" name="{{ $name }}" value="{{ old($name) ?? ($value ?? null) }}"
    placeholder="{{ ucwords(str_replace('_', ' ', $name)) }}"
    class="w-[70%] h-10 bg-gray-200 rounded-md outline-none my-1 px-2 @if ($class ?? null) {{ $class }} @endif" />
<x-v-error :name="$name" />
