<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Queue\QueueController as QueueQueueController;
use App\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        return view('queue.index')->with('queues', Queue::paginate());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Queue $queue)
    {
        return view('queue.show')->with('queue', $queue);
    }

    public function edit(Queue $queue)
    {
        return view('queue.edit')
            ->with('queue', $queue);
    }

    public function update(Request $request, Queue $queue)
    {
        $request->validate([
            "operator_id" => ['nullable', 'exists:operators,id'],
        ]);

        $queue->update([
            "operator_id" => $request->operator_id,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Queue with ' . $queue->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('queue', $queue);
    }

    public function destroy(Queue $queue)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Queue with ' . $queue->id . ' id successfully deleted',
        ];

        $queue->delete();

        $queues = Queue::orderByDesc('id')->paginate();

        return redirect()
            ->route('queues.index')
            ->with('alert_success', $alert_success)
            ->with('queues', $queues);
    }





    public function finishQueue(Request $request, Queue $queue)
    {
        if ($queue->operation === 'new_car' and $request->data === 'allow')
            return redirect()
                ->route('auctions.create', ['car_id' => $queue->queueable->id]);

        QueueQueueController::finish($queue, $request->data);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Queue with ' . $queue->id . ' id successfully finished',
        ];

        return redirect()->route('queues.index')
            ->with('alert_success', $alert_success)
            ->with('queue', $queue);
    }
}
