<x-layouts.app>

    <div class="w-full m-[20px] flex flex-col items-center justify-center">

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> User id: {{ $user->id }} </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    User
                </span>
                <div class="">
                    <div class="flex items-center">
                        <div class="sm:flex hidden flex-col text-gray-400">
                            {{ $user->firstname }}
                            <div class="text-gray-600 text-xs">
                                {{ $user->lastname }} </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Contact
                </span>
                <span class="text-sm text-green-500">
                    {{ $user->contact }}
                </span>
            </div>

            <x-delete-modal name="User" :item="$user" :route="route('users.destroy', ['user' => $user->id])" />

        </div>
        <div class="mt-[10px]">
            <button
                class="w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-red-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)] delete-button"
                data-id="{{ $user->id }}">
                Delete
            </button>
            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-blue-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Update
            </a>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const deleteButtons = document.querySelectorAll(".delete-button");
                deleteButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const itemId = this.getAttribute("data-id");
                        const modal = document.getElementById(`confirmationModal_${itemId}`);
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });
            });
        </script>

</x-layouts.app>
