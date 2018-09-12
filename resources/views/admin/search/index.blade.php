@extends('admin.layouts.master')

@section('content.header','Search Results')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title">{{ count($products)}}  Results Found For Search Word <b>"{{$search_word}}"</b></h1>
                </div>
                <div class="box-body">
                    @foreach($products as $product)
                    <div class="sch-prod-wrap">
                        <img src="{{$product->image()}}" class="prod-img">
                        <div class="desc-prod">
                            <p>Product Name : {{$product->name}}</p>
                            <p>Product Id : {{$product->id}}</p>
                            <p>Product Description : {{$product->description}}</p>
                            <p>Product Price : {{$product->price}}</p>
                            <p>Brand : {{$product->brand->name}}</p>
                            <p>Sub Category : {{$product->sub_category->name}}</p>
                            <p>Quantity Available : {{$product->quantity}}</p>

                            <a href="{{route('product.edit',$product->id)}}" class="btn btn-danger btn-sm">Edit</a>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

@endsection
