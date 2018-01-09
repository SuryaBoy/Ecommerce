<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\SubCategory;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use Illuminate\Validation\Rule;


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
        $sub_categories = SubCategory::all();
        return view('admin.product.create',compact('brands','sub_categories'));
    }

    public function create_with_brand(Request $request,$b_id)
    {
        $categories = Category::all();
        return view('admin.product.create-with-brand',compact('b_id','categories')); 
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:2|max:191|unique:products',
            'price' => 'required|max:191',
            'image' => 'required|image',
            'brand_id' => 'required|exists:brands,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'description' => 'nullable|alpha_dash',
            'quantity' => 'required|numeric',
        ]);


        $file_name = $request->image->getClientOriginalName();
        $destination = 'files';
        $product = new Product();

        $product->brand_id = $request->brand_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->name= $request->name;
        $product->slug = str_replace(" ", "-", $product->name);
        $product->price= $request->price;
        $product->quantity = $request->quantity;

        $image_path = upload_file($request->image,$destination,'files','prod');
        $product->image = $image_path;

        $product->save();
        Session::flash('status', "New Product $request->name successfully Created !");
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::all();
        $sub_categories = SubCategory::all();
        return view("admin.product.edit",compact('product','brands','sub_categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'name' => ['required','min:2','max:191',
                        Rule::unique('products')->ignore($product->id),],
            'price' => 'required|max:191',
            'image' => 'nullable|image',
            'brand_id' => 'required|exists:brands,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);
        
        $product->brand_id = $request->brand_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->name= $request->name;
        $product->description = $request->description;
        $product->slug = str_replace(" ", "-", $product->name);
        $product->price= $request->price;
        $product->quantity = $request->quantity;

        if($request->hasFile('image'))
        {
            $destination = 'files';
            $image_path = upload_file($request->image,$destination,'files','prod');
            
            // then delete the previous image file
            if(delete_file($product->image,'files')){
            }
            else{
                Session::flash('failure',"Old Image couldn't be deleted from storage!!");
            }

            $product->image = $image_path;
            // Image::make($image)->resize(800,400)->save($destination);

        }
        $product->save();
        
        Session::flash('status', "Product $request->name successfully Updated !");

        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $deletedName = $product->name;
        // then delete the image file too
        if(delete_file($product->image,'files')){
        }
        else{
            Session::flash('failure',"Unable to delete image from storage if any!!");
        }
        $product->delete();
        Session::flash('status', "Product $deletedName successfully Deleted From Database !");
        return redirect()->back();
    }
}
