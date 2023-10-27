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

<x-layouts.app>

    @if ($alert_error)
        <x-alerts.error :message="$alert_error" />
    @endif

    @if ($operator_bot)
        <x-alerts.success :message="$operator_message" />
    @endif

    @if ($dealer_bot)
        <x-alerts.success :message="$dealer_message" />
    @endif

    @if ($user_bot)
        <x-alerts.success :message="$user_message" />
    @endif

</x-layouts.app>
