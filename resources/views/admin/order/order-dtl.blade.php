@extends('admin.layouts.master')

@section('link')
    
    <style type="text/css">
        .box-header p{
            margin-bottom: 2px;
        }
    </style>

@endsection

@section('content.header','Order Detail')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <p>Order Id : {{$order->id}}</p>
                            <p>User Id : {{$order->user_id}}</p>
                            <p>User Name : {{$order->user->name}}</p>
                            <p>User Email : {{$order->user->email}}</p>
                            <p>Order Created At : {{$order->created_at->format('M d Y')}}</p>
                            @isset($order->payment->method)
                            <p>Payment Method : {{$order->payment->method}}</p>
                            <p>Payment Status : {{$order->payment->status()}}</p>
                            <p>Payment Description: {{$order->payment->description}}</p>
                            @endisset
                        </div>

                        @if($order->state != "processing")
                        <div class="col-xs-12 col-sm-6">
                            <button data-toggle="collapse" data-target="#editPayment" class="btn btn-primary">Update Payment</button>
                            <div id="editPayment" class="collapse">
                                @isset($order->payment->method)
                                <form role="form" action="{{route('payment.update', $order->payment)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{method_field('PUT')}}
                                    <div class="form-group">
                                        <label for="description">Payment Description:</label>
                                        <input type="text" value="{{$order->payment->description}}" class="form-control" name="description">
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="status">Payment Status:</label>    
                                        </div>
                                        <label class="radio-inline">
                                          <input type="radio" @if($order->payment->status ==1) checked @endif name="status" value=1>Paid
                                        </label>
                                        <label class="radio-inline">
                                          <input type="radio" @if($order->payment->status ==0) checked @endif name="status" value=0>Pending
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Submit</button>
                                </form>
                                @endisset
                            </div>
                        </div>
                        @endif
                    </div>
                    @php
                        $order->total=0;
                    @endphp
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" align=center  class='table table-striped table-bordered'>
                            <thead>
                                <th>Product Name</th>
                                <th>Product Owner</th>
                                <th>Quantity Ordered</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </thead>

                            @forelse($order->products as $c)
                                <tr>
                                    <td>{{$c->name}}</td>
                                    <td>
                                        @isset($c->admin)
                                            {{$c->admin->name}}
                                        @else
                                            Admin
                                        @endisset
                                    </td>
                                    <td>{{$c->pivot->quantityOrdered}}</td>
                                    <td>{{$c->price}}</td>
                                    <td>{{$c->total=$c->price * $c->pivot->quantityOrdered}}</td>
                                    @php
                                        $order->total+=$c->total;
                                    @endphp
                                </tr>
                            @empty
                                No Order Details Available
                            @endforelse
                        </table>
                    </div>
                    <div>
                        <p>Grand Total : {{$order->total}}</p>
                    </div>

                </div>
                <div class="box-footer">
                    <form method="post" action="{{route('order.update',$order->id)}}">
                        {{method_field('PUT')}}
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <label>Check on any of the states to update the state of order</label>
                        <div class="form-group">
                            <label class="radio-inline">
                              <input type="radio" name="state" value="processing" @if($order->state=='processing') checked @endif>Processing
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="state" value="shipping" @if($order->state=='shipping') checked @endif>Shipping
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="state" value="delivered" @if($order->state=='delivered') checked @endif>Delivered
                            </label>
                            @if($errors->first('state'))
                                <label class="help-block">
                                    <strong>{{$errors->first('state')}}</strong>
                                </label>
                            @endif
                            @if($errors->first('skip'))
                                <label class="help-block">
                                    <strong>{{$errors->first('skip')}}</strong>
                                </label>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" value="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                    @if($order->state=='processing')
                        <button class="btn btn-danger btn-sm pull-right" data-toggle="modal" data-target="#warningModal{{$order->id}}">Cancel Order</button>
                    @endif
                </div>

                @if($order->state=='processing')
                    <!-- warningModal -->
                    <div id="warningModal{{$order->id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Are You Sure You Wanna delete Order <b style="color:red;">{{$order->id}}</b> ?</h4>
                          </div>
                          <div class="modal-body">
                            <form action="{{route('order.destroy',$order->id)}}" method="POST">

                                {{csrf_field()}}

                                {{method_field('DELETE')}}
                                <button class="btn btn-danger btn-sm" type="submit">Yes</button>
                                <button class="btn btn-sm btn-info" data-dismiss="modal">No</button>
                            </form> 
                          </div>
                        </div>

                      </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
