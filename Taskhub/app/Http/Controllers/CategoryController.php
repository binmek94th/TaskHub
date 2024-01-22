<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    public function add()
    {
        $id = Auth::user()->id;
        $category = Category::where('user_id','=',$id)->get();
        return view('category/add',compact('category'));
    }

    public function create(Request $request)
    {
        $CategoriesFromDb = Category::all();

        foreach ($CategoriesFromDb as $category){
            if($category->name == $request->name){
                return redirect('add_category');
            }
        }

        $data = new Category();
        $data->name = $request->name;
        $data->user_id = Auth::user()->id;
        $data->save();

        return redirect('dashboard');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $id = Auth::user()->id;
        $categories = Category::where('user_id','=',$id)->get();
        echo "hello";
        return view('category/update',compact('category'),compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $category->name = $request->name;
        $category->save();

        return redirect('dashboard');
    }

    public function delete($id)
    {
        $data = Category::find($id);

        $data->delete();
        return redirect('dashboard');
    }
}
