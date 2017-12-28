@extends('admin.layouts.master')

@section('title', '| Brand')

@section('content.header')
	Brand

    @if (session('status'))
    <div class="col-xs-12" style="margin-top: 20px;">
    	<div class="alert alert-success alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('status') }}
        </div>
    </div>
    @endif

@endsection

@section('content')


	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<div>
					<a class="btn btn-info	" href="{{route('brand.create')}}">Add New Brand</a>
				</div>
				<br>

				<div class="table-responsive">
					<table id="example1" align=center  class='table table-striped table-bordered'>
						<thead>
						<th>Name</th>
						<th>Action</th>
						</thead>

						@forelse($brands as $c)
							<tr>
								<td>{{$c->name}}</td>
								<td><a href=" {{ route('brand.edit', $c->id) }}" class="btn btn-success">Edit</a>
									<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#warningModal{{$c->id}}">Delete</button>
									<a href="{{route('product.create.with.brand', $c->id)}}" class="btn btn-primary">
										Add Product
									</a>
								</td>
							</tr>
						@empty
							<tr>
								<td>No Brands</td>
							</tr>
						@endforelse
					</table>
				</div>

				@forelse($brands as $c)

				<!-- warningModal -->
				<div id="warningModal{{$c->id}}" class="modal fade" role="dialog">
				  <div class="modal-dialog modal-sm">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Are You Sure You Wanna delete <b style="color:red;">{{$c->name}}</b> ?</h4>
				      </div>
				      <div class="modal-body">
						<form action="{{route('brand.destroy',['id'=>$c->id])}}" method="POST">

							{{csrf_field()}}

							{{method_field('DELETE')}}
							<button class="btn btn-danger btn-sm" type="submit">Yes</button>
							<button class="btn btn-sm btn-info" data-dismiss="modal">No</button>
						</form>	
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
