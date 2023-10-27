<x-layouts.app>

    <div class="w-full m-[20px] flex flex-col items-center justify-center">

        <div class="w-[500px] m-[5px] p-[15px] shadow-2xl rounded-lg">
            <h2 class="text-[20px] text-gray-700 font-[700]"> Operator id: {{ $operator->id }} </h2>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Operator
                </span>
                <div class="">
                    <div class="flex items-center">
                        <div class="sm:flex hidden flex-col text-gray-400">
                            {{ $operator->firstname }}
                            <div class="text-gray-600 text-xs">
                                {{ $operator->lastname }} </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Contact
                </span>
                <span class="text-sm text-green-500">
                    {{ $operator->contact }}
                </span>
            </div>

            <div class="flex items-center justify-between my-[5px]">
                <span class="text-sm bg-orange-100 rounded-full px-3 py-px text-orange-500">
                    Validated
                </span>
                @if ($operator->is_validated)
                    <span class="text-sm text-green-500"> True </span>
                @else
                    <span class="text-sm text-red-500"> False </span>
                @endif
            </div>

            <x-delete-modal name="Operator" :item="$operator" :route="route('operators.destroy', ['operator' => $operator->id])" />

        </div>
        <div class="mt-[10px]">
            <button
                class="w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-red-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)] delete-button"
                data-id="{{ $operator->id }}">
                Delete
            </button>
            <a href="{{ route('operators.edit', ['operator' => $operator->id]) }}"
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
