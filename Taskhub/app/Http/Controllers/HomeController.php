<?php

namespace App\Http\Controllers;
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

        $task->save();
        $id = Auth::user()->id;
        $category = Category::where('user_id', '=', $id)->get();
        $tasks = Task::where('user_id', '=', $id)->get();

        if ($request->has('newSubtags')) {
            // Loop through each new subtag and create a SubTask
            foreach ($request->input('newSubtags') as $subtagName) {
                $subtask = new SubTasks();
                $subtask->name = $subtagName;
                $subtask->task_id = $task->id; // Associate with the newly created task
                $subtask->save();
            }
        }

        foreach ($tasks as $task) {
            $subTasks[$task->id] = SubTasks::where('task_id', '=', $task->id)->get();
        }

        return view('/dashboard', compact('category', 'tasks', 'subTasks'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $category = Category::find($id);
        $task_id = $task->id;
        $sub_task = SubTasks::where('task_id', '=',$task_id)->get();
        return view('task/edit',compact('task'), compact('sub_task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
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
                $subtask = new SubTasks();
                $subtask->name = $subtagName;
                $subtask->task_id = $task->id; // Associate with the newly created task
                $subtask->save();
            }
        }

        $id = Auth::user()->id;
        $category = Category::where('user_id', '=', $id)->get();
        $tasks = Task::where('user_id', '=', $id)->get();
        $subTasks = [];

        foreach ($tasks as $task) {
            $subTasks[$task->id] = SubTasks::where('task_id', '=', $task->id)->get();
        }

        return view('dashboard', compact('category', 'tasks', 'subTasks'));
    }


}
