<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('admin.product.index',compact('products'));

    }

    public function create(Request $request)
    {
        $brands = Brand::all();
        return view('admin.product.create',compact('brands'));
    }

    public function store(Request $request)
    {
        $file_name = $request->image->getClientOriginalName();
        $destination = public_path('dashboard/img/products');
        $request->image->move($destination, $file_name);

        $products = new Product();
        $products-> brand_id = $request-> brand_id;
        $products->name= $request->name;
        $products->price= $request->price;
        $products->image = $file_name;
        $products->save();

        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $products = Product::find($id);
        return view("admin.product.edit",compact('products'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
        ]);

        $products = Product::findOrFail($id);
        $products->name = $request->name;
        $products->price = $request->price;

        if($request->hasFile('image'))
        {
            //add the new photo
            $image= $request->file('image');
            $filename= time().'.'.$image->getClientOriginalName();
            $destination = public_path('dashboard/img/products/'.$filename);
            Image::make($image)->resize(800,400)->save($destination);
            $oldPhoto = $products->image;

            //update
            $products->image= $filename;


            //delete the old photo
            Storage::delete($oldPhoto);
        }
        $products->save();

        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $destroy = $products->delete();
        if($destroy){
            return redirect()->route('product.index');
        }

    }



}
