<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function show($id){
        $category = Category::findOrFail($id);
        return view ('admin.categories.show',compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:categories',
        ]);
        $categories= new Category();
        $categories->name = $request->name;
        $categories->slug = str_replace(" ", "-", $categories->name);
        $categories->save();
        return redirect()->route('categories.index');
    }


    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('admin.categories.edit',compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|min:3|unique:categories',
        ]);

        $categories = Category::findOrFail($id);
        $categories->name = $request->name;
        $categories->save();

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $categories = Category::findOrFail($id);

        // Finally, delete this category...
        $destroy = $categories->delete();
        return redirect()->route('categories.index');
    }
}


