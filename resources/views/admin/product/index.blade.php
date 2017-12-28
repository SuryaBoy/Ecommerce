@extends('admin.layouts.master')

@section('content.header','Products')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a class="btn btn-info  " href="{{route('product.create')}}">Add New Product</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" align=center  class='table table-striped table-bordered'>
                            <thead>
                            <th>Brand</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Action</th>
                            </thead>

                            @forelse($products as $c)
                                <tr>
                                    <td>{{App\Brand::where('id',$c-> brand_id)->first()->name}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->price}}</td>
                                    <td>{{$c->quantity}}</td>
                                    <td><img src=" {{$c->image()}} " alt="Images" width="150px" ></td>
                                    <td>
                                        <a  href=" {{ route('product.edit', $c->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        &middot;
                                        <a class="text-danger fa fa-remove" href="" data-toggle="modal" data-target="#warningModal{{$c->id}}"></a> 
                                    </td>

                                </tr>
                            @empty
                                No Products
                            @endforelse
                        </table>
                    </div>

                    @forelse($products as $c)

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
    </div>

@endsection
