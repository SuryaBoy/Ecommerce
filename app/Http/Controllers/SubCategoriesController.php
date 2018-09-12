<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Product;
use Illuminate\Support\Facades\DB;
use Session;


class SubCategoriesController extends ExtendController
{
    public function index()
    {
        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Sub Category'=>route('subcategories.index'),'active'=>'List']);
        $this->website['subcategories'] = SubCategory::all();
        return view('admin.subcategories.index',$this->website);
    }

    public function create(Request $request)
    {
        Session::push('breadcrumb',['Create'=>route('subcategories.create'),'active'=>'Create']);
        $this->website['subcategories'] = Category::all();
        return view('admin.subcategories.create',$this->website);
    }

    public function show($id)
    {
        Session::push('breadcrumb',['Show'=>route('subcategories.show', $id),'active'=>'Show']);
        $this->website['subcategory'] = SubCategory::find($id);
        $this->website['products'] = Product::where('sub_category_id',$id)->paginate($this->default_pagination_limit);
        return view('admin.subcategories.show',$this->website);
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
        Session::push('breadcrumb',['Edit'=>route('subcategories.edit',$id),'active'=>'Edit']);
        $this->website['subcategories'] = SubCategory::findOrFail($id);
        return view('admin.subcategories.edit',$this->website);
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
