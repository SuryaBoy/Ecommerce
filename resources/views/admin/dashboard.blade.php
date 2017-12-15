@extends('admin.layouts.master')

@section('content.header','DashBoard')

@section('content')

	<div class="row">

        @if (session('status'))
        <div class="col-xs-12">
        	<div class="alert alert-success alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        </div>
        @endif

        <div class="col-xs-12">
            <h1>ECommerce</h1>
        </div>
	</div>

@endsection
