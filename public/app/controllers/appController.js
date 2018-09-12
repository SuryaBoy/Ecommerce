
app.controller("appController", function($scope,$cookies, $http, API_URL) {

	// $scope.categories = ['Milk','Tea'];
	// $scope.products = ["Milk", "Bread", "Cheese"];
    $scope.user={id:"",access_token:"",name:"",email:""};
    $scope.cart=[];
    $scope.dataLoaded = false;

    if (!angular.isUndefined($cookies.get('user'))) {

        $scope.user =  $cookies.getObject('user');
        // console.log($scope.user);
    }

    if (!angular.isUndefined($cookies.get('cart'))) {
        // $cookies.remove('cart');
        // console.log($cookies.get('cart'));
        // alert($cookies.get('cart'));
        $scope.cart =  $cookies.getObject('cart');
        // console.log($scope.cart);
    }

	$http.get(API_URL + "category")
    .then(function(response) {
        $scope.categories = response.data;
    });

	$http.get(API_URL + "subcategory")
    .then(function(response) {
        $scope.subcategories = response.data;
    });

    $scope.dataLoaded = true;

    $scope.storePayment = function(obj){
        $scope.dataLoaded = false; 
        var aT="Bearer "+$scope.user.access_token;
        $http({
            method: 'POST',
            url: API_URL +"payment/store",
            data: $.param(obj),
            headers: {'Content-Type': 'application/x-www-form-urlencoded','Authorization' : aT}
        }).then(function(response) {
            console.log(response.data.id);
            $scope.dataLoaded = true;
        },function(response) {
            console.log(response);
        });

    }


    $scope.orderDetails = function(id){
        $scope.dataLoaded = false;
        var aT="Bearer "+$scope.user.access_token;
        $http({
            method: 'GET',
            url: API_URL +"order/orderDetails/"+id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded','Authorization' : aT}
        }).then(function(response) {
            $scope.orderDetail = response.data;
            $scope.toggle('orderDetails');
            console.log(response);
            $scope.dataLoaded = true;
        },function(response) {
            console.log(response);
        });
    }

    if (!angular.isUndefined($cookies.get('payment'))) {

        var payment =  $cookies.getObject('payment');
        payment.status = 1;
        payment.description = "Paid With Paypal";
        $scope.storePayment(payment);
        $scope.orderDetails(payment.order_id);
        alert("Payment SuccessFull");
        $cookies.remove('payment');
        // console.log($scope.user);
    }

    $scope.showProducts = function(s_id){
    	// $scope.products=["milk","cheese","coffee"];
        $scope.dataLoaded = false;
		$http.get(API_URL + "product/" + s_id)
	    .then(function(response) {
	        $scope.products = response.data;
            $scope.dataLoaded = true;
	    });

    }

    $scope.toggle = function(container , id=null, url=null){
        $scope.dataLoaded = false;
        $scope.container = container;

        switch (container) {
            case 'collection':
                var uri = API_URL + "product/" + id;
                if(url=="nxt"){
                    uri = $scope.productsLink.next;
                }
                else if(url=="prv"){
                    uri = $scope.productsLink.prev;   
                }
                $http.get(uri)
                .then(function(response) {
                    $scope.products = response.data.data;
                    $scope.productsLink = response.data.links;
                    $scope.dataLoaded = true;
                    // console.log(response);
                });
                break;
            case 'product':
                // $scope.product_id = id;
                for (i = 0; i < $scope.products.length; i++) {
                    if($scope.products[i].id==id)
                    {
                        $scope.product = $scope.products[i];
                        $scope.dataLoaded = true;
                        // alert($scope.product.description);
                        // console.log($scope.product);
                        break;
                        // console.log($scope.product);
                    }
                }

                $http.get(API_URL + "review/" + id)
                .then(function(response) {
                    $scope.comments = response.data;
                    for (i = 0; i < $scope.comments.length; i++) {
                        if($scope.comments[i].user_id==$scope.user.id)
                        {
                            $scope.comment = $scope.comments[i].comment;
                            $scope.dataLoaded = true;
                            break;
                        }
                        else{
                            $scope.comment = "";
                            $scope.dataLoaded = true;
                        }
                    }
                });

                break;

            case 'cart':
                    $scope.calcualteGrandTotal();
                    $scope.dataLoaded = true;
                break;

            case 'orderDetails':

                break;
            case 'orders':

                break;
            case 'searchResult':

                break;
            default:
                break;
        }
    }

    $scope.postReview = function(p_id){
        $scope.dataLoaded = false;
        var datas = {product_id:p_id,user_id:$scope.user.id,comment:$scope.comment};
        // alert($scope.accessToken);
        if($scope.user.access_token==""||$scope.user.access_token==null){
            $scope.dataLoaded = true;
            $('#loginModal').modal('show');
        }
        else{
            var aT="Bearer "+$scope.user.access_token;
            $http({
                method: 'POST',
                url: API_URL +"review/commentstore",
                data: $.param(datas),
                headers: {'Content-Type': 'application/x-www-form-urlencoded','Authorization' : aT}
            }).then(function(response) {
                // console.log(response);
                alert(response.data);
                $scope.dataLoaded = true;
            },function(response) {
                if(response.status==401){
                     alert("Un Authorized");
                     $scope.dataLoaded = true;
                    // console.log(response);
                    
                    // $scope.getAccessToken();
                }
                else{
                    console.log(response);
                    alert('This is embarassing. An error has occured. Please check the log for details');
                    $scope.dataLoaded = true;
                }
            });
        }

    }

    $scope.getAccessToken = function(){
        $scope.dataLoaded = false;
        var dataObj = {email:$scope.user.email,password:$scope.user.password};
        $http({
            method: 'POST',
            url: API_URL +"accessToken",
            data: $.param(dataObj),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            // console.log(response);
            $('#loginModal').modal('hide');
            $scope.user=response.data;
            $cookies.putObject("user",$scope.user);
            $scope.dataLoaded = true;
            // $scope.accessToken=$scope.user.access_token;
            // console.log($scope.user);
        },function(response) {
            console.log(response);
        });
    }

    $scope.login = function(){
        $('#loginModal').modal('show');
    }

    $scope.logout = function(){
        $cookies.remove('user');
        $scope.user={id:"",access_token:"",name:"",email:""};
    }

    $scope.addToCart = function(){
        //make quantityOrdered default to 1
        $scope.product.quantityOrdered="1";
        $scope.product.total=$scope.product.price;

        $scope.cart.push($scope.product);

        $cookies.putObject("cart",$scope.cart);

        $scope.calcualteGrandTotal();
        // console.log($scope.cart);
    }

    $scope.removeFromCart = function(index){
        $scope.cart.splice(index,1);
        $cookies.putObject("cart",$scope.cart);
        if($scope.cart.length==0){
            $cookies.remove('cart');
        }
        $scope.toggle('cart');
    }

    $scope.range = function(min, max, step) {
        step = step || 1;
        var input = [];
        for (var i = min; i <= max; i += step) {
            input.push(i);
        }
        return input;
    };

    $scope.makeOrder = function(paymentObj){
        var dataObj = {user_id:$scope.user.id,total:$scope.grandTotal};
        if($scope.user.access_token==""||$scope.user.access_token==null){
            $('#loginModal').modal('show');
        }else{
            var aT="Bearer "+$scope.user.access_token;
            $scope.dataLoaded = false;
            $http({
                method: 'POST',
                url: API_URL +"order/store",
                data: $.param(dataObj),
                headers: {'Content-Type': 'application/x-www-form-urlencoded','Authorization' : aT}
            }).then(function(response) {
                // console.log(response.data.id);
                paymentObj.order_id = response.data.id;
                $scope.storeProductDetails(response.data.id);
                //now store the payment
                if(paymentObj.method == 'Cash In Hand'){
                    $scope.storePayment(paymentObj);
                    $scope.grandTotal=0;
                    $scope.orderDetails(o_id);
                } else if(paymentObj.method == 'Paypal') {
                    $scope.paypalPayment(paymentObj);
                }
                // $scope.accessToken=$scope.user.access_token;
            },function(response) {
                console.log(response);
            });
        }
    }

    $scope.storeProductDetails = function(o_id){
        if(o_id!=null&&o_id!=""){
            var aT="Bearer "+$scope.user.access_token;
            for(i=0;i<$scope.cart.length;i++){
                var dataObj = {order_id:o_id,product_id:$scope.cart[i].id,unitPrice:$scope.cart[i].price,quantityOrdered:$scope.cart[i].quantityOrdered}
                $http({
                    method: 'POST',
                    url: API_URL +"orderProduct/store",
                    data: $.param(dataObj),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded','Authorization' : aT}
                }).then(function(response) {
                    console.log(response);
                    // $scope.accessToken=$scope.user.access_token;
                },function(response) {
                    console.log(response);
                    //if this occurs you need to handle carefully.
                });
            }
            
            $scope.cart.splice(0,$scope.cart.length);
            $cookies.remove('cart');
        }
    }

    $scope.totalPrice = function(cartIndex){
        $scope.cart[cartIndex].total=$scope.cart[cartIndex].quantityOrdered*$scope.cart[cartIndex].price;
        $scope.calcualteGrandTotal();
    }

    $scope.calcualteGrandTotal = function(){
        var sum = 0;
        for(i=0;i<$scope.cart.length;i++){
            sum = sum + $scope.cart[i].total;
        }
        $scope.grandTotal = sum;
    }

    $scope.getOrder = function(user_id){
        var aT="Bearer "+$scope.user.access_token;
        $scope.dataLoaded = false;
        $http({
            method: 'GET',
            url: API_URL +"order/"+user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded','Authorization' : aT}
        }).then(function(response) {
            $scope.orders = response.data;
            $scope.toggle('orders');
            $scope.dataLoaded = true;

            // console.log(response);
        },function(response) {
            console.log(response);
            $scope.dataLoaded = true;
        });
    }

    $scope.addToSessionCart = function(id){
        var dataObj = {product_id:id};
        $http({
            method: 'POST',
            url: API_URL +"cart/addItem",
            data: $.param(dataObj),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(response) {
            console.log(response);
            $scope.cart = response.data;
            // location.reload();
            // $scope.accessToken=$scope.user.access_token;
            // console.log($scope.cart);
        },function(response) {
            console.log(response);
        });
    }

    $scope.openDrop = function(){
        $(".bom-drop").mouseover(function(){
            $(this).addClass("open");
        });
        $(".bom-drop").mouseleave(function(){
            $(this).removeClass("open");
        });
    }

    $scope.cashInHand = function(){
        var payment = {method:'Cash In Hand'};
        $scope.makeOrder(payment);
    }

    $scope.payWithPaypal = function(){
        var payment = {method:'Paypal'};
        $scope.makeOrder(payment);
    }

    $scope.paypalPayment = function(obj) {
        // put something in cookie to remember about the payment
        $scope.dataLoaded = false;
        $cookies.putObject('payment', obj);
        // got to the paypal payment route of your app
        $("#paypal-form").submit();
    }

    $scope.searchProduct = function() {
        if($scope.search !=null && $scope.search !="") {
            var dataObj = {string:$scope.search};
            $http({
                method: 'GET',
                url: API_URL +"product/search",
                params: dataObj,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(response) {
                $scope.resultProduct = response.data.data;
                $scope.products = response.data.data;
                console.log($scope.resultProduct)
            },function(response) {
                alert("failure");
                console.log(response);
            });

        }
    }

    $scope.searchSubmit = function() {
        $scope.searchProduct();
        $scope.toggle('searchResult');
        $scope.dataLoaded = true;
    }


});