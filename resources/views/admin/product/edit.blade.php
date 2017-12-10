@extends('admin.layouts.master')

@section('content')

    <form action="{{ route('product.update', $products->id) }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}"><br/>
        {{method_field('PUT')}}

        <div class="container-fluid">
            <div class="row">
                <div class="form-group">
                    <label for="name" class="col-form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{$products->name}}">
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" value="image" >
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Product Price</label>
                    <input type="text" name="price" class="form-control" value="{{$products->price}}">
                </div>


                <div class="form-group">
                    <label class="col-md-12"></label>
                    <div class="col-md-6">
                        <button type="submit" value="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection