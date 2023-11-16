<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Task\TaskManage;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            "is_done" => ['required', 'boolean'],
        ]);

        $task->update([
            "operator_id" => $request->operator_id,
            "is_done" => $request->is_done,
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




    public function search($col, $val)
    {
        $validator = Validator::make([
            'col' => $col,
            'val' => $val
        ], [
            'col' => ['required', 'in:' . implode(',', Task::fillables())],
            'val' => ['required', 'string'],
        ]);

        if ($validator->fails()) return;

        $tasks = Task::where($col, 'like', "%$val%")->paginate();

        return view('task.index')
            ->with('oldcol', $col)
            ->with('oldval', $val)
            ->with('tasks', $tasks);
    }
}
