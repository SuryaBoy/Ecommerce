@extends('admin.layouts.master')

@section('content')

	<script language="javascript">
		function ConfirmDelete()
		{
			return confirm("Are you sure to delete?") ;
		}
	</script>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<div>
					<a class="btn btn-info	" href="{{route('brand.create')}}">Add New Category</a>

				</div>
				<br>

				<div class="table-responsive">
					<table id="example1" align=center  class='table table-striped table-bordered'>
						<thead>
						<th>Name</th>
						<th>Action</th>
						</thead>

						@foreach($brands as $c)
							<tr>
								<td>{{$c->name}}</td>
								<td><a href=" {{ route('brand.edit', $c->id) }}"><i class="fa fa-edit"></i></a>
									&middot;<a onclick='return ConfirmDelete()' href="{{url('brand/destroy',$c->id)}}" class="text-danger fa fa-remove"></a>  </td>

							</tr>
						@endforeach
					</table>
				</div>


			</div>
		</div>
	</div>

@endsection
