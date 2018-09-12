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
use Auth;


class ProductController extends ExtendController
{

    public function index()
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('View Product')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Product'=>route('product.index'),'active'=>'List']);
        $user = Auth::guard('admin')->user();
        if($user->hasRole('Vendor')){
            $this->website['products'] = Product::where('admin_id',$user->id)->latest('created_at')->paginate($this->default_pagination_limit);
            return view('admin.product.index',$this->website);
        }
        $this->website['products'] = Product::latest('created_at')->paginate($this->default_pagination_limit);
        return view('admin.product.index',$this->website);
    }

    public function create(Request $request)
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('Create Product')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        Session::push('breadcrumb',['Add Product'=>route('product.create'),'active'=>'Create']);
        $this->website['brands'] = Brand::all();
        $this->website['sub_categories'] = SubCategory::all();
        return view('admin.product.create',$this->website);
    }

    public function create_with_brand(Request $request,$b_id)
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('Create Product')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        Session::push('breadcrumb',['Add Product'=>route('product.create'),'active'=>'Create']);
        $this->website['categories'] = Category::all();
        $this->website['b_id'] = $b_id;
        return view('admin.product.create-with-brand',$this->website); 
    }

    public function store(Request $request)
    {

        if(!Auth::guard('admin')->user()->hasPermissionTo('Create Product')){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required|min:2|max:191|unique:products',
            'price' => 'required|integer',
            'image' => 'required|image',
            'brand_id' => 'required|exists:brands,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'description' => 'nullable',
            'quantity' => 'required|numeric',
        ]);


        $file_name = $request->image->getClientOriginalName();
        $destination = 'files';
        $product = new Product();

        if(Auth::guard('admin')->user()->hasRole('Vendor')){
            $product->admin_id = Auth::guard('admin')->user()->id;
        }

        $product->brand_id = $request->brand_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->name= $request->name;
        $product->slug = str_replace(" ", "-", $product->name);
        $product->price= $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;

        $image_path = upload_file($request->image,$destination,'files','prod');
        $product->image = $image_path;

        $product->save();
        Session::flash('status', "New Product $request->name successfully Created !");
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $this->website['product'] = Product::find($id);
        $user = Auth::guard('admin')->user();

        if(!$user->hasPermissionTo('Edit Product') && $user->id != $this->website['product']->admin_id){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        Session::push('breadcrumb',['Edit Product'=>route('product.edit',$id),'active'=>'Edit']);
        
        $this->website['brands'] = Brand::all();
        $this->website['sub_categories'] = SubCategory::all();
        return view("admin.product.edit",$this->website);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::guard('admin')->user();

        if(!$user->hasPermissionTo('Edit Product') && $user->id != $product->admin_id){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => ['required','min:2','max:191',
                        Rule::unique('products')->ignore($product->id),],
            'price' => 'required|integer',
            'image' => 'nullable|image',
            'brand_id' => 'required|exists:brands,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'quantity' => 'required|numeric',
            'description' => 'nullable',
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

        $user = Auth::guard('admin')->user();
        if(!$user->hasPermissionTo('Delete Product') && $user->id != $product->admin_id){
            Session::flash('failure',"You Do Not Have Correct Permission");
            return redirect()->back();
        }

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
