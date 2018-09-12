@extends('admin.layouts.master')

@section('content.header','Product Upadate')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('product.update', $product->id)}}" enctype="multipart/form-data">
                    {{method_field('PUT')}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">


                    <div class="form-group">
                        <label for="brand_id">
                            Brands
                        </label>
                        <select name="brand_id" class="form-control select2">
                            @foreach($brands as $b)
                                <option  value="{{$b->id}}" @if($b->id == $product->brand_id) selected @endif>
                                    {{$b->name}}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->first('brand_id'))
                            <label class="help-block">
                                <strong>{{$errors->first('brand_id')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="sub_category_id">
                            Sub Category
                        </label>
                        <select name="sub_category_id" class="form-control select2">
                            @foreach($sub_categories as $c)
                                <option  value="{{$c->id}}" @if($c->id == $product->sub_category_id) selected @endif>
                                    {{$c->name}}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->first('sub_category_id'))
                            <label class="help-block">
                                <strong>{{$errors->first('sub_category_id')}}</strong>
                            </label>
                        @endif
                    </div>



                    <div class="form-group">
                        <label>Product Name/Model</label>
                        <input type="text" name="name" class="form-control" value="{{$product->name}}" />
                        @if($errors->first('name'))
                            <label class="help-block">
                                <strong>{{$errors->first('name')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image">
                        @if($errors->first('image'))
                            <label class="help-block">
                                <strong>{{$errors->first('image')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" value="{{$product->price}}"/>
                        @if($errors->first('price'))
                            <label class="help-block">
                                <strong>{{$errors->first('price')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control" value="{{$product->quantity}}" />
                        @if($errors->first('quantity'))
                            <label class="help-block">
                                <strong>{{$errors->first('quantity')}}</strong>
                            </label>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description">{{$product->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" value="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
