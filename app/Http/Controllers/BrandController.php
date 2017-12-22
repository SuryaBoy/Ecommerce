<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brand.index',compact('brands'));
    }


    public function create()
    {
        return view('admin.brand.create');
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
        $brands = Brand::findOrFail($id);
        return view('admin.brand.edit',compact('brands'));
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
