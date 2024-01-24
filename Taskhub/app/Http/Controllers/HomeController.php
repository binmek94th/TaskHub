<?php

namespace App\Http\Controllers;
use App\Models\Status;
use App\Models\SubTasks;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $category = Category::where('user_id', '=', $id)->get();
        $tasks = Task::where('user_id', '=', $id)->get();
        $subTasks = [];

        foreach ($tasks as $task) {
            $subTasks[$task->id] = SubTasks::where('task_id', '=', $task->id)->get();
        }

        return view('dashboard', compact('category', 'tasks', 'subTasks'));
    }

    public function add($id)
    {
        $category = Category::find($id);
        return view('task/add',compact('category'));
    }

    public function create(Request $request)
    {
        $id = Auth::user()->id;
        $task = new Task();

        $task->user_id = $id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->category_id = $request->category;
        $task->is_completed = 0;
        $task->save();

        $status = new Status();
        $status->status = "Task Created";
        $status->task_id = $task->id;
        $status->save();


        $id = Auth::user()->id;
        $category = Category::where('user_id', '=', $id)->get();
        $tasks = Task::where('user_id', '=', $id)->get();

        if ($request->has('newSubtags')) {
            // Loop through each new subtag and create a SubTask
            foreach ($request->input('newSubtags') as $subtagName) {
                if($subtagName != null ){
                    $subtask = new SubTasks();
                    $subtask->name = $subtagName;
                    $subtask->task_id = $task->id; // Associate with the newly created task
                    $subtask->save();

                    $stat = new Status();
                    $stat->status = $subtagName . " Sub Task Created";
                    $stat->task_id = $task->id;
                    $stat->save();
                }
            }
        }

        return redirect()->action([HomeController::class, 'index']);
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $category = Category::find($id);
        $task_id = $task->id;
        $sub_task = SubTasks::where('task_id', '=',$task_id)->get();
        $status = $task->statuses()->where('task_id', $task->id)->get();

        $statuses = $task->statuses()->where('task_id', $task->id)->get();

        return view('task/edit', compact('sub_task', 'statuses', 'task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $due_date = $task->due_date;
        $task->due_date = $request->due_date;

        if($due_date == null){
            $stat = new Status();
            $stat->status = "Due Date Added To ". $task->due_date;
            $stat->task_id = $task->id;
            $stat->save();
        }
        else if($due_date != $request->due_date){
            $stat = new Status();
            $stat->status = "Due Date Changed From ". $due_date . " To " . $task->due_date;
            $stat->task_id = $task->id;
            $stat->save();
        }

        if($request->has('task_completed') && $task->is_completed == 0){
            $stat = new Status();
            $stat->status = "Task Completed";
            $stat->task_id = $task->id;
            $stat->save();
        }
        else if(!$request->has('task_completed') && $task->is_completed == 1){
            $stat = new Status();
            $stat->status = "Task Marked As Incomplete";
            $stat->task_id = $task->id;
            $stat->save();
        }
        $task->is_completed = $request->has('task_completed') ? 1 : 0;
        $task->save();


        // Update completed attribute to 0 for subtasks not selected
        SubTasks::where('task_id', $task->id)->update(['is_completed' => 0]);

        // Get selected subtask IDs and update completed attribute to 1
        $selectedSubtaskIds = (array) $request->input('subtasks', []);
        SubTasks::whereIn('id', $selectedSubtaskIds)->update(['is_completed' => 1]);

        // Add new subtasks
        if ($request->has('newSubtags')) {
            // Loop through each new subtag and create a SubTask
            foreach ($request->input('newSubtags') as $subtagName) {
                if($subtagName != null){
                    $subtask = new SubTasks();
                    $subtask->name = $subtagName;
                    $subtask->task_id = $task->id; // Associate with the newly created task
                    $subtask->save();

                    $stat = new Status();
                    $stat->status = $subtask->name ." Sub Task Added";
                    $stat->task_id = $task->id;
                    $stat->save();
                }
            }
        }
        return redirect()->action([HomeController::class, 'index']);
    }

    public function delete($id)
    {
        $data = Task::find($id);

        $data->delete();
        return redirect()->action([HomeController::class, 'index']);
    }
    public function delete_sub($id)
    {
        $data = SubTasks::find($id);

        $stat = new Status();
        $stat->status = $data->name . " Sub Task Deleted";
        $stat->task_id = $data->task_id;
        $stat->save();

        $data->delete();
        return redirect()->action([HomeController::class, 'index']);
    }

}
