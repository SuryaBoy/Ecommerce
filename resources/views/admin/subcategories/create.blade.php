@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('subcategories.store')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="form-group">
                                <label for="category_id">
                                    Category
                                </label>
                                <select name="category_id" class="form-control select2" style="width: 100%;">
                                    @foreach($subcategories as $c)
                                    <option  value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                    <div class="form-group">
                        <label>Name of Sub Category</label>
                        <input type="text" name="name" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" value="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
