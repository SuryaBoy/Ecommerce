@extends('admin.layouts.master')

@section('content')

    <form action="{{ route('brand.update', $brands->id) }}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}"><br/>
        {{method_field('PUT')}}

        <div class="container">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name" class="col-form-label">Categories Name</label>
                    <input type="text" name="name" class="form-control" value="{{$brands->name}}">
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