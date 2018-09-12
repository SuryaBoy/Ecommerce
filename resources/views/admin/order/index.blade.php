@extends('admin.layouts.master')

@section('content.header','Orders')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" align=center  class='table table-striped table-bordered'>
                            <thead>
                            <th>Order Id</th>
                            <th>User Id</th>
                            <th>Grand Total</th>
                            <th>State</th>
                            <th>Action</th>
                            </thead>

                            @forelse($orders as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->user_id}}</td>
                                    <td>{{$c->total}}</td>
                                    <td>{{$c->state}}</td>
                                    <td>
                                        <a href="{{route('order.showOrderDetails',$c->id)}}" class="btn btn-sm btn-primary">Show Details</a>
                                    </td>

                                </tr>
                            @empty
                                No Orders Available
                            @endforelse
                        </table>
                    </div>

                </div>
                <div class="box-footer">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
