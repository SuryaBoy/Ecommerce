<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubCategory;
use App\Brand;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('admin.product.index',compact('products'));

    }

    public function create(Request $request)
    {
        $subcategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.product.create',compact('subcategories','brands'));
    }

    public function store(Request $request)
    {
        $file_name = $request->image->getClientOriginalName();
        $destination = public_path('dashboard/img/products');
        $request->image->move($destination, $file_name);

        $products = new Product();
        $products->subcategory_id = $request->subcategory_id;
        $products->brand_id = $request->brand_id;

        $products->name= $request->name;
        $products->price= $request->price;
        $products->image = $file_name;

        $products->save();

        return redirect()->route('slider.index');
    }

}
