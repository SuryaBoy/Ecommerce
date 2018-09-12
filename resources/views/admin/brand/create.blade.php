@extends('admin.layouts.master')

@section('content.header','Create Brand')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h1 class="box-title">Create Brand</h1>
                </div>
                <div class="box-body">
                    <form method="post" action="{{route('brand.store')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>Name of Brand</label>
                            <input type="text" name="name" class="form-control"/>
                            @if($errors->first('name'))
                                <label class="help-block">
                                    <strong>{{$errors->first('name')}}</strong>
                                </label>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" value="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>

@endsection
