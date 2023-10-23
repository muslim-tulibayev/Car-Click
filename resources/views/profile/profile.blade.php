<x-layouts.empty-app>

    <div>
        <div class="w-[50%] mx-auto">

            <a href="{{ route('home') }}"
                class="block my-[20px] bg-gray-600 hover:bg-[green] w-[100px] text-center py-[3px] rounded">
                Back
            </a>

            @if ($updated_message ?? null)
                <div
                    class="flex flex-col items-center bg-[rgba(0,0,0,0.5)] p-[20px] w-[100%] rounded-lg my-[10px] text-[green]">
                    {{ $updated_message }}
                </div>
            @endif

            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur, similique!
            <form action="{{ route('profile') }}" method="POST"
                class="flex flex-col items-center bg-[rgba(0,0,0,0.5)] px-[20px] w-[100%] rounded-lg my-[10px]">
                @method('PUT')
                @csrf
                <input required type="text" name="firstname" value="{{ old('firstname') ?? $firstname }}"
                    placeholder="Firstname"
                    class="h-[35px] w-[70%] px-[5px] m-[5px] mt-[20px] rounded-md outline-none" />
                @error('firstname')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror
                <input required type="text" name="lastname" value="{{ old('lastname') ?? $lastname }}"
                    placeholder="Lastname" class="h-[35px] w-[70%] px-[5px] m-[5px] rounded-md outline-none" />
                @error('lastname')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror
                <input required type="text" name="username" value="{{ old('username') ?? $username }}"
                    placeholder="Username" class="h-[35px] w-[70%] px-[5px] m-[5px] rounded-md outline-none" />
                @error('username')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror

                <button type="submit" class="h-[35px] w-[200px] rounded-md bg-[green] my-[20px]"> Update </button>
            </form>

            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates ex nostrum necessitatibus consequuntur,
            beatae maxime.
            <form action="{{ route('profile.change-password') }}" method="POST"
                class="flex flex-col items-center bg-[rgba(0,0,0,0.5)] px-[20px] w-[100%] rounded-lg my-[10px]">
                @method('PUT')
                @csrf
                <input required type="password" name="current_password" value="{{ old('current_password') }}"
                    placeholder="Current password"
                    class="h-[35px] w-[70%] px-[5px] m-[5px] mt-[20px] rounded-md outline-none" />
                @error('current_password')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror
                <input required type="password" name="password" value="{{ old('password') }}"
                    placeholder="New password" class="h-[35px] w-[70%] px-[5px] m-[5px] rounded-md outline-none" />
                @error('password')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror
                <input required type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                    placeholder="Confirm new password"
                    class="h-[35px] w-[70%] px-[5px] m-[5px] rounded-md outline-none" />
                @error('password_confirmation')
                    <p class="text-[red]"> {{ $message }} </p>
                @enderror

                <button type="submit" class="h-[35px] w-[200px] rounded-md bg-[green] my-[20px]"> Change </button>
            </form>

            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad voluptas fugiat architecto odio voluptates nihil
            accusantium a enim quae accusamus!
            <div class="flex flex-col items-center bg-[rgba(0,0,0,0.5)] px-[20px] w-[100%] rounded-lg my-[10px]">
                <a href="{{ route('delete') }}"
                    class="h-[35px] w-[200px] rounded-md bg-[red] my-[20px] flex items-center justify-center">
                    Delete account
                </a>
            </div>
        </div>
    </div>

</x-layouts.empty-app>
