@extends('layouts.app')

@section('title', '| Create Permission')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h1>Add Permission</h1>
    <br>

    <form method="POST" action="{{route('permissions.store')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="name" name="name" class="form-control">
        </div>
        <div>
            <br>
            @if(!$roles->isEmpty()) //If no roles exist yet
                <h4>Assign Permission to Roles</h4>

                @foreach($roles as $role)
                    <div class="checkbox">
                      <label><input type="checkbox" name="roles[]" value="{{$role->id}}">{{$role->name}}</label>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

</div>

@endsection