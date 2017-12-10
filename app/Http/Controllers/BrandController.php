<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

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
            'name' => 'required',
        ]);
        $brands= new Brand();
        $brands->name = $request->name;
        $brands->slug = str_replace(" ", "-", $brands->name);
        $brands->save();
        return redirect()->route('brand.index');
    }

    public function edit($id)
    {
        $brands = Brand::findOrFail($id);
        return view('admin.brand.edit',compact('brands'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|min:3|unique:brands',
        ]);

        $brands = Brand::findOrFail($id);
        $brands->name = $request->name;
        $brands->save();

        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        $brands = Brand::findOrFail($id);

        // Finally, delete this category...
        $destroy = $brands->delete();
        if($destroy){
            return redirect()->route('brand.index');
        }
    }
}
