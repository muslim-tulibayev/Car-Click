@props([
    'alert_error' => null,
    'operator_bot' => null,
    'dealer_bot' => null,
    'user_bot' => null,
    'operator_message' => (object) [
        'primary' => 'Connected',
        'text' => 'Operator bot connected successfully',
    ],
    'dealer_message' => (object) [
        'primary' => 'Connected',
        'text' => 'Dealer bot connected successfully',
    ],
    'user_message' => (object) [
        'primary' => 'Connected',
        'text' => 'User bot connected successfully',
    ],
])

<x-layouts.empty-app>
    <div class="h-full w-full relative">
        <div class="w-[50%] h-auto mx-auto">

            <x-btns.back />

            @if ($alert_error)
                <x-webhook.error :message="$alert_error" />
            @endif

            @if ($operator_bot)
                <x-webhook.success :message="$operator_message" id="successOne" />
            @endif

            @if ($dealer_bot)
                <x-webhook.success :message="$dealer_message" id="successTwo" />
            @endif

            @if ($user_bot)
                <x-webhook.success :message="$user_message" id="successThree" />
            @endif

        </div>
    </div>
</x-layouts.empty-app>
