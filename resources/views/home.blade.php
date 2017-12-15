{{--@extends('layouts.app')--}}
{{--@section('css')--}}
    {{--<link rel="stylesheet" href="{{asset('dashboard/bower_components/font-awesome/css/font-awesome.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">    @stop--}}
{{--@section('content')--}}
{{--<div class="container-fluid">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<button class="btn btn-info" id="category">Categories</button>--}}

            {{--<div id="subcategory"></div>--}}




        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

    {{--@section('script')--}}
        {{--<script src="{{asset('dashboard/bower_components/jquery/dist/jquery.min.js')}}"></script>--}}
        {{--<script src="{{asset('dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>--}}


        {{--<script>--}}
            {{--$(document).ready(function(){--}}
                {{--$("#category").click(function()--}}
                {{--{--}}
                    {{--$.ajaxSetup({--}}
                        {{--headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }--}}
                    {{--});--}}
                    {{--$.ajax({--}}
                        {{--type:"GET",--}}
{{--//                        data: {id:data},--}}
                        {{--url:"/getCat",--}}
                        {{--success:function(data)--}}
                        {{--{--}}
                            {{--if (data=="success")--}}
                                    {{--alert(data);--}}
{{--//                            $("#subcategory").append(data);--}}
                        {{--},--}}
                        {{--error: function(response){--}}
                            {{--alert('Error'+response);--}}
                        {{--}--}}
                    {{--});--}}
                {{--});--}}
            {{--});--}}
        {{--</script>--}}

    {{--@stop--}}



    {{--@endsection--}}

<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .navbar {
            overflow: hidden;
            background-color: #333;
            font-family: Arial;
        }
        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: brown;
            padding: 14px 16px;
            background-color: inherit;
        }

        .navbar a:hover, .dropdown:hover .dropbtn {
            background-color: red;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="dropdown">
        <button class="dropbtn" id="category">Category
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <ul href="#">
                <li id="subcategory"></li>
            </ul>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#category").hover(function () {
        var subcategory = $('#subcategory').val();

        $.ajaxSetup({
                       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                   });
       $.ajax({
            type: "GET",
            data: { 'id' : subcategory, },
            url: "/getCat",
            success: function (data) {
                console.log(data);
                $("#subcategory").append(data);
            }
        });

    });
});
</script>


</body>
</html>