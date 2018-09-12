@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-xs-12">

	      @if (session('status'))
	      <div class="col-xs-12" style="margin-top: 20px;">
	        <div class="alert alert-success alert-dismissable fade in">
	              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	              {{ session('status') }}
	          </div>
	      </div>
	      @endif

	    <h1>User Administration <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
	    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
			
			<table class="table table-striped table-responsive">
			    <thead>
			      <tr>
			        <th>Name</th>
			        <th>Email</th>
			        <th>Roles</th>
			        <th>Action</th>
			      </tr>
			    </thead>
			    @forelse($admins as $admin)
			    <tbody>
			      <tr>
			        <td>{{$admin->name}}</td>
			        <td>{{$admin->email}}</td>
			        <td>{{$admin->roles()->pluck('name')->implode(' ') }}</td>
					<td>
						<a href="{{ route('admin.edit',$admin->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit Role</a>						
							<!-- Trigger the modal with a button -->
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#warningModal{{$admin->id}}">Delete</button>
					</td>
			      </tr>
			    </tbody>


				@empty
					No Admins Found

				@endforelse		

			  </table>

			  @forelse($admins as $admin)

			    <!-- Modal -->
				<div id="warningModal{{$admin->id}}" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Are You Sure You Wanna delete {{$admin->name}} ?</h4>
				      </div>
				      <div class="modal-body">
						<form action="{{route('admin.destroy',['id'=>$admin->id])}}" method="POST">

							{{csrf_field()}}

							{{method_field('DELETE')}}
							<button class="btn btn-danger btn-sm" type="submit">Yes</button>
						</form>

						<button class="btn btn-sm btn-info" data-dismiss="modal">No</button>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>

				@empty

			  @endforelse

		</div>
	</div>
</div>

@endsection