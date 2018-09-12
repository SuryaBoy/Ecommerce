@extends('admin.layouts.master')

@section('content.header','Sub Categories')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a class="btn btn-info  " href="{{route('subcategories.create')}}">Add Sub Category for Category</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" align=center  class='table table-striped table-bordered'>
                            <thead>
                            <th>Sub Category Name</th>
                            <th>Parent Category</th>
                            <th>Products Quantity</th>
                            <th>Action</th>
                            </thead>

                            @foreach($subcategories as $c)
                                <tr>
                                    <td>{{$c->name}}</td>
                                    <td>{{App\Category::where('id',$c->category_id)->first()->name}}</td>
                                    <td>{{$c->products->count()}}</td>
                                    <td>
                                        <a href="{{route('subcategories.show',$c->id)}}" class="btn btn-primary">Show Related Products</a>
                                        
                                        <a class="btn btn-warning btn-sm" href=" {{ route('subcategories.edit', $c->id) }}">Edit</a>

                                        <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#warningModal{{$c->id}}">Delete</a> 
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                @forelse($subcategories as $c)

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
                        <form action="{{route('subcategories.destroy',['id'=>$c->id])}}" method="POST">

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
