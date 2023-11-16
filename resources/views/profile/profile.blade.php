<x-layouts.empty-app>
    <div class="h-full w-full relative">
        <div class="w-[50%] h-auto mx-auto">

            <x-btns.back />
            <x-alerts.success />

            <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col items-center">
                @method('PUT')
                @csrf
                <h1 class="font-medium text-xl w-[70%] mb-2"> Profile Update </h1>
                <x-inputs.input name="firstname" value="{{ $firstname }}" />
                <x-inputs.input name="lastname" value="{{ $lastname }}" />
                <x-inputs.input name="username" value="{{ $username }}" />
                <button type="submit"
                    class="bg-blue-500 text-white font-medium w-[100px] h-8 my-1 rounded-md hover:bg-blue-800"> Update
                </button>
            </form>

            <form action="{{ route('profile.password') }}" method="POST" class="flex flex-col items-center">
                @method('PUT')
                @csrf
                <h1 class="font-medium text-xl w-[70%] mb-2"> Change Password </h1>
                <x-inputs.input type="password" name="current_password" />
                <x-inputs.input type="password" name="password" />
                <x-inputs.input type="password" name="password_confirmation" />
                <button type="submit"
                    class="bg-blue-500 text-white font-medium w-[100px] h-8 my-1 rounded-md hover:bg-blue-800"> Change
                </button>
            </form>

            <x-profile.danger-zone />

        </div>
    </div>
</x-layouts.empty-app>
