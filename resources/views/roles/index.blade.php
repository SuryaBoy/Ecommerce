@extends('layouts.app')

@section('title', '| Roles')

@section('content')

  @if (session('status'))
  <div class="col-xs-12" style="margin-top: 20px;">
    <div class="alert alert-success alert-dismissable fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('status') }}
      </div>
  </div>
  @endif

<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-key"></i> Roles

    <a href="{{ route('admin.show') }}" class="btn btn-default pull-right">Admins</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Operation</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                    <td>
                    <a href="{{ route('roles.edit', $role->id)}}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#warningModal{{$role->id}}">Delete</button>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        @foreach ($roles as $role)
            <!-- Modal -->
            <div id="warningModal{{$role->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are You Sure You Wanna delete {{$role->name}} ?</h4>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('roles.destroy', $role->id)}}" method="POST">

                        {{csrf_field()}}

                        {{method_field('DELETE')}}
                        <button class="btn btn-danger btn-sm">Yes</button>
                    </form>

                    <button class="btn btn-sm btn-info" data-dismiss="modal">No</button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
        @endforeach

    </div>

    <a href="{{route('roles.create')}}" class="btn btn-success">Add Role</a>

</div>

@endsection