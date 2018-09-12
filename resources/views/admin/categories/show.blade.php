@extends('admin.layouts.master')

@section('title', '| Category')

@section('content.header')
	{{$category->name}}

<!--     @if (session('status'))
    <div class="col-xs-12" style="margin-top: 20px;">
    	<div class="alert alert-success alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('status') }}
        </div>
    </div>
    @endif -->

@endsection

@section('content')

	<div class="col-xs-12">
		<a href="#create-sub-cat" data-toggle="collapse" class="btn btn-primary">Add Sub Categories</a>
		<a href="{{ url()->previous() }}" class="btn btn-success pull-right">Back</a>

		<div id="create-sub-cat" class="collapse" style="margin-top: 20px;">
            <form method="post" action="{{route('subcategories.store')}}">
                {{csrf_field()}}
                <input type="hidden" name="category_id" value="{{$category->id}}">

                <div class="form-group">
                    <label>Name of Sub Category</label>
                    <input type="text" name="name" class="form-control"/>
                </div>

                <div class="form-group">
                    <button type="submit" value="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
		</div>
		<h4>Sub Categories</h4>


		<div class="tabel-responsive">
			
			<table class="table table-bordered table-striped">
			<tr style="background-color:#3c8dbc;">
			  <th style="width: 10px">#</th>
			  <th>Name</th>
			  <th style="width:200px;">Action</th>
			</tr>
			@forelse ($category->subcategory as $cat)
				<tr>
				  <td>{{$loop->iteration}}</td>
				  <td>{{$cat->name}}</td>
				  <td>
				  	<a href="#edit-sub-cat{{$cat->id}}" class="btn btn-warning" data-toggle="collapse">
				  		Edit
				  	</a>
				  	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#warningModal{{$cat->id}}">Delete</button>
				  </td>
				</tr>
				<tr>
					<td style="padding:0;">

					</td>
					<td style="padding:0;">
						<div id="edit-sub-cat{{$cat->id}}" class="collapse" style="margin: 10px;">
				            <form class="form-inline" method="post" action="{{route('subcategories.update',$cat->id)}}">
				                {{csrf_field()}}
				                {{method_field('PUT')}}
				                <input type="hidden" name="category_id" value="{{$category->id}}">

				                <div class="form-group">
				                    <label>Name:</label>
				                    <input type="text" name="name" class="form-control"/>
				                </div>

				                <div class="form-group">
				                    <button type="submit" value="submit" class="btn btn-success">Submit</button>
				                </div>
				            </form>
						</div>
					</td>
				</tr>
			@empty
				<tr>
					<td>No Sub Categories</td>
				</tr>
			@endforelse
			</table>

			@forelse($category->subcategory as $cat)

			<!-- warningModal -->
			<div id="warningModal{{$cat->id}}" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Are You Sure You Wanna delete <b style="color:red;">{{$cat->name}}</b> ?</h4>
			      </div>
			      <div class="modal-body">
					<form action="{{route('subcategories.destroy',['id'=>$cat->id])}}" method="POST">

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

@endsection