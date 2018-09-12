<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Load Bootstrap CSS -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('app/css/style.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('dashboard/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <script type="text/javascript" src="{{asset('app/angular/angular.min.js')}}"></script>

    </head>
    <body ng-cloak ng-app="ecommerceApp" ng-controller="appController">
<!--         <div id="loader" class="text-center" style="height:100vh">
            <img src="{{asset('frontend/img/Preloader_3.gif')}}" style="position:absolute; top:50%;">
        </div> -->
        <div ng-hide="dataLoaded" class="text-center" style="height:100vh">
            <img src="{{asset('frontend/img/Preloader_3.gif')}}" style="position:absolute; top:50%;">
        </div>
        <div ng-show="dataLoaded">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <form class="navbar-form navbar-left" ng-submit="searchSubmit()">
                              <div class="input-group">
                                <input list="suggestions" name="search" ng-model="search" type="text" class="form-control" ng-keyup="searchProduct()" placeholder="Search Products">
                                <datalist id="suggestions">
                                    <option ng-repeat="x in resultProduct" value="@{{x.name}}"></option>
                                </datalist>
                                <div class="input-group-btn">
                                  <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                  </button>
                                </div>
                              </div>
                            </form>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            <li ng-show="user.id==''"><a href="" ng-click="login()">Login</a></li>
                            <li ng-show="user.id==''"><a href="{{ route('register') }}">Register</a></li>
                            <li ng-show="user.id!=''" class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    @{{ user.name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="" ng-click="getOrder(user.id)">
                                            My Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" ng-click="logout()">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="cart-li" ng-click="toggle('cart')">
                                <i class="carter fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                                <span class="badge" ng-show="cart.length>0">@{{cart.length}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="container">
                <div class="row">

                    <aside class="col-xs-12 col-sm-2 side-nav">
                        <div class="row">
                            <div class="side-nav-head">
                                <b>Categories</b>
                            </div>
                            <ul class="side-nav-ul">
                                <li ng-repeat="category in categories" ng-mouseenter="openDrop()" class="dropdown bom-drop">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown">@{{category.name}}</a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                      <li ng-repeat="subcategory in subcategories" ng-if="subcategory.category_id==category.id" ng-click="toggle('collection',subcategory.id)">
                                        <a href="#">
                                            @{{subcategory.name}}
                                        </a>
                                      </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </aside>

                    <div class="col-xs-12 col-sm-10">

                        @if ($message = Session::get('success'))

                        <div class="custom-alerts alert alert-success fade in">

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                            {!! $message !!}

                        </div>

                        <?php Session::forget('success');?>

                        @endif

                        @if ($message = Session::get('error'))

                        <div class="custom-alerts alert alert-danger fade in">

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                            {!! $message !!}

                        </div>

                        <?php Session::forget('error');?>

                        @endif

                        <div class="panel panel-default">
                            <div class="panel-heading">Dashboard</div>

                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <div ng-if="container=='collection'" class="row products-wraper">
                                    <div class="col-xs-12 col-sm-3" ng-repeat="x in products">
                                        <div class="product-item text-center" ng-click="toggle('product',x.id)">
                                            <img src="<?php echo asset('{{x.image}}'); ?>">
                                            <div class="product-item-info">
                                                <p>Name : @{{x.name}}</p>
                                                <p>Price : @{{x.price}}</p>
                                                <p>Quantity Available : @{{x.quantity}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <button class="btn btn-success btn-sm pull-right" ng-show="$parent.productsLink.next" ng-click="toggle('collection',subcategory.id,'nxt')">Next</button>

                                        <button class="btn btn-success btn-sm pull-left" ng-show="$parent.productsLink.prev" ng-click="toggle('collection',subcategory.id,'prv')">Prev</button>
                                    </div>
                                </div>
                                <div ng-if="container=='product'" class="row">

                                    <div class="col-xs-12 col-sm-8">
                                        <!-- @{{product}} -->
                                        <div class="product-img-wrap">
                                            <img src="<?php echo asset('{{product.image}}'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="product-dtl-wrap">
                                            <p>Name : @{{product.name}}</p>
                                            <p>Price : @{{product.price}}</p>
                                            <p>Quantity Available : @{{product.quantity}}</p>
                                            <p>Brand : @{{product.brand}}</p>
                                            <p>Sub Category : @{{product.sub_category}}</p>
                                            <p>Description : @{{product.description}}</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="add-to-cart">
                                            <button class="btn btn-primary" ng-click="addToCart()">
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                                Add To Cart
                                            </button>
                                        </div>
                                        <div class="review-wrap">
                                            <form role="form">
                                              <div class="form-group">
                                                <label for="comment">Write Review:</label>
                                                <textarea class="form-control" rows="2" ng-model="$parent.comment" id="comment"></textarea>
                                              </div>
                                              <button type="submit" class="btn btn-default" ng-click="postReview(product.id)"> 
                                                Post
                                              </button>
                                            </form>
                                            <div class="reviews" ng-repeat="c in comments">
                                                <p class="cmt-by">Review By : <b>@{{c.user_name}}</b></p>
                                                <p class="cmt">@{{c.comment}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div ng-show="container=='cart'" class="row cart-items-wrap">
                                    <div class="col-xs-12" ng-repeat="(i,x) in cart">
                                        <div class="row cart-item">
                                            <div class="col-xs-12 col-sm-4">
                                                <div class="cart-item-img-wrap">
                                                    <img src="<?php echo asset('{{x.image}}'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-8">
                                                <div class="cart-item-dtl">
                                                    <p>Name : @{{x.name}}</p>
                                                    <p>Unit Price : @{{x.price}}</p>
                                                    <p>Brand : @{{x.brand}}</p>
                                                    <p>Sub Category : @{{x.sub_category}}</p>
                                                    <p>Description : @{{x.description}}</p>
                                                    <form name="qtFrm" class="form-horizontal">
                                                        
                                                        <label>Quantity : </label>
                                                        <select ng-model="x.quantityOrdered" ng-change="totalPrice(i)" name="quantity" required>
                                                            <option value=@{{n}} ng-repeat="n in range(1,x.quantity)">
                                                                @{{n}}
                                                            </option>
                                                        </select>
                                                       
                                                    </form>
                                                    <p>Total : Rs @{{x.total}}</p>
                                                    <button class="rm-btn btn btn-danger" ng-click="removeFromCart(i)" >Remove From Cart</button>
                                                </div>
                                            </div>
                                            <!-- @{{x}} -->
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="check-out-details">
                                            <p>Grand Total : Rs @{{grandTotal}}</p>
                                        </div>
                                        <button class="btn btn-primary" data-toggle="collapse" data-target="#payment" ng-disabled="qtFrm.$invalid" >Check Out</button>
                                        <div id="payment" class="collapse">
                                            <p>Select A Payment Method</p>
                                            <button class="btn btn-success" ng-click="cashInHand()">
                                                Cash In Hand
                                            </button>
                                            <button class="btn btn-primary" ng-click="payWithPaypal()">
                                                Paypal
                                            </button>
                                            <form id="paypal-form" action="{{route('api.post.paypal')}}" method="post">
                                                {{csrf_field()}}
                                                <input type="hidden" name="amount" value="@{{grandTotal}}">
                                                <input type="hidden" name="user_name" value="@{{user.name}}">
                                                <input type="hidden" name="user_id" value="@{{user.id}}">
                                                <input type="hidden" name="user_email" value="@{{user.email}}">
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div ng-show="container=='orderDetails'" class="row order-details-wrap">
                                    <div class="col-xs-12">
                                        <div class="general-wraper">
                                            <p><b>Order Details</b></p>
                                            <p>Order Id : @{{orderDetail.id}}</p>
                                            <p>Ordered By : @{{orderDetail.user.name}}</p>
                                            <p>Orderer Email : @{{orderDetail.user.email}}</p>
                                            <p>Ordered Date : @{{orderDetail.created_at}}</p>
                                            <table class='table table-striped table-bordered'>
                                                <thead>
                                                    <th>Product Name</th>
                                                    <th>Quantity Ordered</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </thead>
                                                <tr ng-repeat="o in orderDetail.products">
                                                    <td>@{{o.name}}</td>
                                                    <td>@{{o.pivot.quantityOrdered}}</td>
                                                    <td>Rs @{{o.price}}</td>
                                                    <td>Rs @{{o.price*o.pivot.quantityOrdered}}</td>
                                                </tr>
                                            </table>
                                            <p>Grand Total : Rs @{{orderDetail.total}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div ng-show="container=='orders'" class="row order-details-wrap">
                                    <div class="col-xs-12">
                                        <div class="orders-wrap general-wraper" ng-repeat="o in orders">
                                            <p>Order Id : @{{o.id}}</p>
                                            <p>Ordered Date : @{{o.created_at}}</p>
                                            <button class="btn btn-primary btn-sm" ng-click="orderDetails(o.id)">View Details</button>
                                        </div>
                                    </div>
                                </div>

                                <div ng-show="container=='searchResult'" class="row products-wraper">
                                    <div class="col-xs-12">
                                        <h3>Search Result for "<b>@{{search}}</b>"</h3>
                                        <h5 ng-if="resultProduct.length == 0">No Match Found</h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-3" ng-repeat="x in resultProduct">
                                        <div class="product-item text-center" ng-click="toggle('product',x.id)">
                                            <img src="<?php echo asset('{{x.image}}'); ?>">
                                            <div class="product-item-info">
                                                <p>Name : @{{x.name}}</p>
                                                <p>Price : @{{x.price}}</p>
                                                <p>Quantity Available : @{{x.quantity}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="loginModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Please Login First</h4>
                          </div>
                          <div class="modal-body">
                            <form name="lgnFrm" class="form-horizontal lgn-frm">

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus ng-model="user.email">

                                        <span class="help-block" ng-show="lgnFrm.email.$invalid && lgnFrm.email.$touched">
                                            <strong>Enter Valid Email Address</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required ng-model="user.password">

                                    </div>
                                </div>

                                <!--<div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button class="btn btn-primary" ng-click="getAccessToken()"  ng-disabled="lgnFrm.$invalid">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
        <!-- <script src=" asset('app/lib/angular/angular.min.js') "></script> -->
        <!-- <script src="{{asset('js/app.js')}}"></script> -->
        <script src="{{asset('js/jquery-3.2.0.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>

        <!-- AngularJS Application Scripts -->
        <script type="text/javascript" src="{{asset('app/app.js')}}"></script>
        <script type="text/javascript" src="{{asset('app/controllers/appController.js')}}"></script>
        <script src="{{asset('app/angular/angular-cookies.min.js')}}"></script>       

<!--         <script type="text/javascript">
            $('#loader').show();
            $(document).ready(function(){
                $('#loader').hide();
            });
        </script>  -->

    </body>
</html>
