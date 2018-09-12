@extends('layouts.app')

@section('title', '| Permissions')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-key"></i>Available Permissions

    <a href="{{ route('admin.show') }}" class="btn btn-default pull-right">Admins</a>
    <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a></h1>
    <hr>

    <a href="{{ route('permissions.create') }}" class="btn btn-success">Add Permission</a>
    <br><br>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Permissions</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td> 
                    <td>
                    <a href="{{route('permissions.edit',$permission->id)}}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#warningModal{{$permission->id}}">Delete</button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

		@foreach ($permissions as $permission)
		    <!-- Modal -->
			<div id="warningModal{{$permission->id}}" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Are You Sure You Wanna delete {{$permission->name}} ?</h4>
			      </div>
			      <div class="modal-body">
					<form action="{{route('permissions.destroy', $permission->id)}}" method="POST">

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

</div>

@endsection
