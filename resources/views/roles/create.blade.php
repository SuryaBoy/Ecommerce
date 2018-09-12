@extends('layouts.app')

@section('title', '| Add Role')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h1><i class='fa fa-key'></i> Add Role</h1>
    <hr>

    <form method="POST" action="{{route('roles.store')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="name" name="name" class="form-control">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div>
            <br>
            @if(!$permissions->isEmpty())
                <h4>Assign Permission to Roles</h4>

                @foreach($permissions as $permission)
                    <div class="checkbox">
                      <label><input type="checkbox" name="permissions[]" value="{{$permission->id}}">{{$permission->name}}</label>
                    </div>
                @endforeach
            @endif

            @if ($errors->has('permissions[]'))
                <span class="help-block">
                    <strong>{{ $errors->first('permissions[]') }}</strong>
                </span>
            @endif

        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

</div>

@endsection