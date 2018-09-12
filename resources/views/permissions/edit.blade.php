@extends('layouts.app')

@section('title', '| Edit Permission')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h1>Add Permission</h1>
    <br>

    <form method="POST" action="{{route('permissions.update',$permission->id)}}">
        {{method_field('PUT')}}
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="name" name="name" value="{{$permission->name}}" class="form-control">
        </div>
        <div>
            <br>
            @if(!$roles->isEmpty())
                <h4>Assign Permission to Roles</h4>

                @foreach($roles as $role)
                    <div class="checkbox">
                      <label><input type="checkbox" @if($role->hasPermissionTo($permission->name)) checked @endif name="roles[]" value="{{$role->id}}">{{$role->name}}</label>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

</div>

@endsection