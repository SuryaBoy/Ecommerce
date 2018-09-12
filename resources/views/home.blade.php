<!-- <html>
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
</html> -->

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>

@endsection