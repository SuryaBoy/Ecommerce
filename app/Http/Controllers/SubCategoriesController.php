<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\DB;


class SubCategoriesController extends Controller
{
    public function index()
    {
//        $subcategory = SubCategory
//        $subcategory = DB::table('sub_categories')
//            ->join('categories','category_id','=','categories.id')
//            ->get();
        $subcategories = SubCategory::all();
        return view('admin.subcategories.index',compact('subcategories'));

    }

    public function create(Request $request)
    {
        $subcategories = Category::all();
        return view('admin.subcategories.create',compact('subcategories'));
    }

    public function store(Request $request)
    {
        $subcategories= new SubCategory();
        $subcategories->category_id = $request->category_id;
        $subcategories->name = $request->name;
        $subcategories->slug = str_replace(" ", "-", $subcategories->name);

//        dd($subcategories);
        $subcategories->save();
        return redirect()->route('subcategories.index');
    }

    public function edit($id)
    {
        $subcategories = SubCategory::findOrFail($id);
        return view('admin.subcategories.edit',compact('subcategories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|min:3|unique:categories',
        ]);

        $subcategories = SubCategory::findOrFail($id);
        $subcategories->name = $request->name;
        $subcategories->save();

        return redirect()->route('subcategories.index');
    }

    public function destroy($id)
    {
        $subcategories = SubCategory::findOrFail($id);
        $destroy = $subcategories->delete();
        if($destroy){
            return redirect()->route('subcategories.index');
        }

    }


}
