<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use Session;


class SubCategoriesController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('admin.subcategories.index',compact('subcategories'));
    }

    public function create(Request $request)
    {
        $subcategories = Category::all();
        return view('admin.subcategories.create',compact('subcategories'));
    }

    public function show($id)
    {
        
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|min:3|max:191|unique:sub_categories',
        ]);

        $subcategories= new SubCategory();
        $subcategories->category_id = $request->category_id;
        $subcategories->name = $request->name;
        $subcategories->slug = str_replace(" ", "-", $subcategories->name);
        $subcategories->save();
        Session::flash('status', "New Sub Category $request->name successfully Created !");
        return redirect()->back();
    }

    public function edit($id)
    {
        $subcategories = SubCategory::findOrFail($id);
        return view('admin.subcategories.edit',compact('subcategories'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'name'=>'required|min:3|max:191|unique:sub_categories',
        ]);

        $subcategories = SubCategory::findOrFail($id);
        $subcategories->name = $request->name;
        $subcategories->slug = str_replace(" ", "-", $subcategories->name);
        $subcategories->save();
        Session::flash('status', "Sub Category $request->name successfully Updated !");
        return redirect()->back();
    }

    public function destroy($id)
    {
        $subcategories = SubCategory::findOrFail($id);
        Session::flash('status', "Sub Category $subcategories->name successfully Deleted !");
        $subcategories->delete();
        return redirect()->back();
    }

}
