<?php

namespace App\Http\Controllers;
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

        return view('dashboard', compact('category'), compact('tasks'));
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

        return view('/dashboard', compact('category'), compact('tasks'));
    }

    public function edit($id)
    {
        $id = Auth::user()->id;
        $task = Task::where('id', '=', $id)->get();
        $category = Category::find($id);

        return view('task/edit',compact('task'));
    }

}
