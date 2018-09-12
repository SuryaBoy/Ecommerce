<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Facebook Plugin</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>

	<style type="text/css">
		.o-img{
			height:200px;
			max-width:100%;
			margin-bottom: 20px;
		}
	</style>
<!-- facebook javascript initialize -->
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId            : '1776865875950021',
	      autoLogAppEvents : true,
	      xfbml            : true,
	      version          : 'v2.11'
	    });

	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "https://connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
	<h1 class="text-center">This is great</h1>
	<div class="container text-center" id="btn-ctr">
		<button class="btn btn-primary" onclick="importFromFacebook()">Import From Facebook</button>
	</div>
	<div class="container">
		<div class="row" id="photos-container">

		</div>
	</div>


	<script src="{{asset('js/app.js')}}"></script>
	<script type="text/javascript">
		// function to import Photos From Facebook
	    function importFromFacebook(afte="not",befor="not"){
	    	// first try to login
	    	

			FB.login(function(response) {
				//if already logged in 
			    if (response.status === 'connected') {
			    	//save the access token
				  	var tok = response.authResponse.accessToken;
				  	// initialize the paramObj
				  	var paramObj = {access_token:tok,limit:10,fields:'id,source,album'};
				  	// if afte not equal to not then user has clicked nxt button so include after parameter
				  	if(afte!="not"){
						paramObj = {access_token:tok,limit:10,fields:'id,source,album',after:afte};
				  	}
				  	// if befor not equal to not then user has clicked prv button so include before parameter
				  	if(befor!="not"){
						paramObj = {access_token:tok,limit:10,fields:'id,source,album',before:befor};
				  	}
				  	//now call the graph facebook api
				  	FB.api('/me/photos','get',paramObj,function (response) {
				      if (response && !response.error) {
				        console.log(response);
				        var nxt = "<a class='btn btn-success btn-sm pull-right' onclick=importFromFacebook('"+response.paging.cursors.after+"')>Next</a>";
				        var prv = "<a class='btn btn-success btn-sm pull-left' onclick=importFromFacebook(\"not\",'"+response.paging.cursors.before+"')>Prev</a>";
				        $("#btn-ctr").empty();
				        $("#btn-ctr").append(nxt);
				        $("#btn-ctr").append(prv);
				        $("#photos-container").empty();
				        for(i=0;i<response.data.length;i++){
				        	var txt="<div class='col-xs-12 col-sm-3'><img src="+response.data[i].source+" class='o-img'></div>";
				        	// console.log(response.data[i].source);
				        	$("#photos-container").append(txt);
				        }
				      }
				    });
				    console.log('Logged in.');
				} else {
				    FB.login();
				}
			}, {scope: 'public_profile,user_photos'});
			// scope must have user_photos parameter to be able to access photos
	    }
	</script>
</body>
</html>