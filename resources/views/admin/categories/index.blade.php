@extends('admin.layouts.master')

@section('content.header','Categories')

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				
				<div class="box-header with-border">
					<a class="btn btn-info	" href="{{route('categories.create')}}">Add New Category</a>
				</div>

				<div class="box-body">
					<div class="table-responsive">
						<table id="example1" align=center  class='table table-striped table-bordered'>
							<thead>
							<th>Name</th>
							<th>Action</th>
							</thead>

							@foreach($categories as $c)
								<tr>
									<td>
										<a href="{{route('categories.show',$c->id)}}">
											{{$c->name}}
										</a>
									</td>

									<td>
										<a href=" {{ route('categories.edit', $c->id) }}"><i class="fa fa-edit"></i></a>
										&middot;<a class="text-danger fa fa-remove" href="" data-toggle="modal" data-target="#warningModal{{$c->id}}"></a>
									</td>

								</tr>
							@endforeach
						</table>
					</div>
				</div>

                @forelse($categories as $c)

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
                        <form action="{{route('categories.destroy',['id'=>$c->id])}}" method="POST">

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
