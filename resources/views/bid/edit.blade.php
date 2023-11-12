@props([
    'auctions_list' => App\Models\Auction::all(),
    'dealers_list' => App\Models\Dealer::all(),
])

<x-layouts.app>

    <x-alerts.success />

    <form action="{{ route('bids.update', ['bid' => $bid->id]) }}" method="POST"
        class="w-full my-5 flex flex-col items-center justify-center">
        @method('PUT')
        @csrf

        <x-show-card>

            <h2 class="text-[20px] text-gray-700 font-[700]"> Bid id: {{ $bid->id }} </h2>

            <x-card-item name="Auction ID">
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="auction_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($auctions_list as $auction)
                            <option value="{{ $auction->id }}"
                                @if (old('auction_id')) @if (old('auction_id') == $auction->id)
                                        selected @endif
                            @else @if ($bid->auction_id === $auction->id) selected @endif @endif>
                                {{ $auction->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </x-card-item>
            <x-v-error name="auction_id" />

            <x-card-item name="Dealer">
                <div class="relative inline-flex">
                    <svg class="w-2 h-2 absolute top-0 right-0 m-2 pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                        <path
                            d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                            fill="#648299" fill-rule="nonzero" />
                    </svg>
                    <select name="dealer_id"
                        class="rounded-md text-gray-600 px-[10px] bg-gray-100 focus:bg-gray-300 focus:outline-none appearance-none">
                        @foreach ($dealers_list as $dealer)
                            <option value="{{ $dealer->id }}"
                                @if (old('dealer_id')) @if (old('dealer_id') == $dealer->id)
                                        selected @endif
                            @else @if ($bid->dealer_id === $dealer->id) selected @endif @endif>
                                {{ $dealer->firstname . ' ' . $dealer->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </x-card-item>
            <x-v-error name="dealer_id" />

            <x-card-item name="Price">
                <div>
                    <input type="number" name="price"
                        class="w-[150px] text-sm text-gray-400 outline-none bg-gray-100 focus:bg-gray-300 rounded-md px-[3px]"
                        value="{{ old('price') ?? $bid->price }}" />
                </div>
            </x-card-item>
            <x-v-error name="price" />

        </x-show-card>

        <div class="mt-[10px]">
            <button type="submit"
                class="inline-flex items-center justify-center w-[120px] h-[30px] mx-[10px] rounded-md text-white bg-green-700 bg-gradient-to-t from-[rgba(0,0,0,0.1)]">
                Save
            </button>
        </div>

    </form>

</x-layouts.app>
