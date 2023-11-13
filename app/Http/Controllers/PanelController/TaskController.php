<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Task\TaskManage;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('task.index')->with('tasks', Task::orderByDesc('id')->paginate());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Task $task)
    {
        return view('task.show')->with('task', $task);
    }

    public function edit(Task $task)
    {
        return view('task.edit')
            ->with('task', $task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            "operator_id" => ['nullable', 'exists:operators,id'],
        ]);

        $task->update([
            "operator_id" => $request->operator_id,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Task with ' . $task->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('task', $task);
    }

    public function destroy(Task $task)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Task with ' . $task->id . ' id successfully deleted',
        ];

        $task->delete();

        $tasks = Task::orderByDesc('id')->paginate();

        return redirect()
            ->route('tasks.index')
            ->with('alert_success', $alert_success)
            ->with('tasks', $tasks);
    }





    public function finishTask(Request $request, Task $task)
    {
        if ($task->operation === 'new_car' and $request->data === 'allow')
            return redirect()
                ->route('auctions.create', ['car_id' => $task->taskable->id]);

        TaskManage::finish($task, $request->data);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Task with ' . $task->id . ' id successfully finished',
        ];

        return redirect()->route('tasks.index')
            ->with('alert_success', $alert_success)
            ->with('task', $task);
    }
}
