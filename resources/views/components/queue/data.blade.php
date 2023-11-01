<x-card-item name="Data" />
<div class="p-2 rounded-md bg-gray-100">
    @if ($queue->queueable instanceof \App\Models\Auction)
        <x-queue.auction :auction="$queue->queueable" :car="$queue->queueable->car" />
    @elseif ($queue->queueable instanceof \App\Models\Operator)
        <x-queue.operator :operator="$queue->queueable" />
    @elseif ($queue->queueable instanceof \App\Models\Car)
        <x-queue.car :car="$queue->queueable" />
    @endif
</div>
