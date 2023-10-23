<x-layouts.empty-app>

    <div>
        <div class="w-[50%] mx-auto">

            <a href="{{ route('profile') }}"
                class="block my-[20px] bg-gray-600 hover:bg-[green] w-[100px] text-center py-[3px] rounded">
                Back
            </a>

            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe amet soluta incidunt dolorem quia nobis.
            <form action="{{ route('delete') }}" method="POST"
                class="flex flex-col items-center bg-[rgba(0,0,0,0.5)] px-[20px] w-[100%] rounded-lg my-[10px]">
                @method('DELETE')
                @csrf
                <input required type="password" name="password" value="{{ old('password') }}" placeholder="Password"
                    class="h-[35px] w-[70%] px-[5px] m-[5px] mt-[20px] rounded-md outline-none" />
                @error('password')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror

                <button type="submit"
                    class="h-[35px] w-[200px] rounded-md bg-[red] my-[20px] flex items-center justify-center">
                    Delete
                </button>
            </form>
        </div>
    </div>

</x-layouts.empty-app>
