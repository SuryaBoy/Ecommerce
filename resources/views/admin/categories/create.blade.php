@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('categories.store')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group">
                        <label>Name of Category</label>
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
