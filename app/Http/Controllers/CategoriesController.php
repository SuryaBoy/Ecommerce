<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;
use Auth;

class CategoriesController extends ExtendController
{
    public function index()
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('View Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        $this->website['categories'] = Category::all();
        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Category'=>route('categories.index'),'active'=>'List']);
        return view('admin.categories.index',$this->website);
    }

    public function create()
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('Create Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        Session::push('breadcrumb',['Create'=>route('categories.create'),'active'=>'Create']);
        return view('admin.categories.create',$this->website);
    }

    public function show($id){

        if(!Auth::guard('admin')->user()->hasPermissionTo('View Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        Session::push('breadcrumb',['Show'=>route('categories.show',$id),'active'=>'Show']);
        $this->website['category'] = Category::find($id);
        if(!$this->website['category']==null)
        return view ('admin.categories.show',$this->website);
        else
        return "category id $id not found";
    }

    public function store(Request $request)
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('Create Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

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
        $user = Auth::guard('admin')->user();

        if(!$user->hasPermissionTo('Edit Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        Session::push('breadcrumb',['Edit'=>route('categories.edit',$id),'active'=>'Edit']);
        $this->website['categories'] = Category::findOrFail($id);
        return view('admin.categories.edit',$this->website);
    }

    public function update(Request $request, $id)
    {

        $user = Auth::guard('admin')->user();

        if(!$user->hasPermissionTo('Edit Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

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

        if(!Auth::guard('admin')->user()->hasPermissionTo('Delete Category')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        $categories = Category::findOrFail($id);

        // Finally, delete this category...
        $destroy = $categories->delete();
        return redirect()->route('categories.index');
    }
}


