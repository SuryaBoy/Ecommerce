@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			
			<table class="table table-striped table-responsive">
			    <thead>
			      <tr>
			        <th>Name</th>
			        <th>Email</th>
			        <th>Role_Id</th>
			        <th>Action</th>
			      </tr>
			    </thead>
			    @forelse($admins as $admin)
			    <tbody>
			      <tr>
			        <td>{{$admin->name}}</td>
			        <td>{{$admin->email}}</td>
			        <td>{{$admin->role_id}}</td>
					<td>						<!-- Trigger the modal with a button -->
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