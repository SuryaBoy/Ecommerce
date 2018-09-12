@extends('layouts.app')

@section('title', '| Edit User')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h1><i class='fa fa-user-plus'></i> Edit {{$admin->name}}</h1>
    <hr>

    <form action="{{route('admin.update',$admin->id)}}" method="POST">
        {{method_field('PUT')}}
        {{csrf_field()}}
        @if(!$roles->isEmpty())
            <h4>Assign Roles To Admin</h4>

            @foreach($roles as $role)
                <div class="checkbox">
                  <label><input type="checkbox" name="roles[]" @if($admin->hasRole($role->name)) checked @endif value="{{$role->id}}">{{$role->name}}</label>
                </div>
            @endforeach

            <button class="btn btn-primary" type="submit">Update</button>
        @endif
    </form>

</div>

@endsection