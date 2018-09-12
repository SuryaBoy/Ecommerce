@extends('admin.layouts.master')

@section('content.header','Sub Category Details')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title">Sub Category : <b>{{$subcategory->name}}</b></h1>
                </div>
                <div class="box-body">
                    <p>Products Related To Sub Category : {{$subcategory->name}} are tabulated Below :</p>
                    <div class="table-responsive">
                        <table id="example1" align=center  class='table table-striped table-bordered'>
                            <thead>
                                <th>##</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Image</th>
                                <th>Action</th>
                            </thead>

                            @foreach($products as $c)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->brand->name}}</td>
                                    <td>{{$c->price}}</td>
                                    <td>{{$c->quantity}}</td>
                                    <td>
                                        <img src="{{$c->image()}}" style="width:70px;">
                                    </td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href=" {{ route('product.edit', $c->id) }}">Edit</a>

                                        <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#warningModal{{$c->id}}">Delete</a> 
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="box-footer with-border text-center">
                    {{ $products->links() }}
                </div>

                @forelse($subcategory->products as $c)

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
                        <form action="{{route('product.destroy',['id'=>$c->id])}}" method="POST">

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
