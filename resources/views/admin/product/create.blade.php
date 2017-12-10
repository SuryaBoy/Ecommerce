@extends('admin.layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">


                    <div class="form-group">
                        <label for="brand_id">
                            Brands
                        </label>
                        <select name="brand_id" class="form-control select2" style="width: 100%;">
                            @foreach($brands as $b)
                                <option  value="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--<div class="form-group">--}}
                        {{--<label for="subcategory_id">--}}
                            {{--Sub Category--}}
                        {{--</label>--}}
                        {{--<select name="subcategory_id" class="form-control select2" style="width: 100%;">--}}
                            {{--@foreach($subcategories as $c)--}}
                                {{--<option  value="{{$c->id}}">{{$c->name}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}



                    <div class="form-group">
                        <label>Product Name/Model</label>
                        <input type="text" name="name" class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control"/>
                    </div>

                    <div class="form-group">
                        <button type="submit" value="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
