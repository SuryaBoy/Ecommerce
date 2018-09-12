<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends ExtendController
{
    public function index()
    {
        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Brands'=>route('brand.index'),'active'=>'List']);
        $this->website['brands'] = Brand::all();
        return view('admin.brand.index',$this->website);
    }


    public function create()
    {
        Session::push('breadcrumb',['Create'=>route('brand.create'),'active'=>'Create']);
        return view('admin.brand.create',$this->website);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:191|unique:brands',
        ]);
        $brands= new Brand();
        $brands->name = $request->name;
        $brands->slug = str_replace(" ", "-", $brands->name);
        $brands->save();
        Session::flash('status', "New Brand $request->name successfully Created !");
        return redirect()->route('brand.index');
    }

    public function edit($id)
    {
        Session::push('breadcrumb',['Edit'=>route('brand.edit',$id),'active'=>'Edit']);
        $this->website['brands'] = Brand::findOrFail($id);
        return view('admin.brand.edit',$this->website);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $this->validate($request,[
            'name' => ['required','min:2','max:191',
                        Rule::unique('brands')->ignore($brand->id),],
        ],
        [
            'name.unique' => "The name $request->name has already been used. Please use another name",
        ]);

        
        $brand->name = $request->name;
        $brand->save();
        Session::flash('status', "Brand $request->name successfully Updated !");
        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        $brands = Brand::findOrFail($id);

        Session::flash('status', "Brand $subcategories->name successfully Deleted !");
        // Finally, delete this category...
        $brands->delete();
        return redirect()->route('brand.index');
    }
}
