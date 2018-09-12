<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{asset('dashboard/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
<!-- page script -->

<script type="text/javascript">
    $(document).ready(function(){

        $("#q").keyup(function(){
        	var str = $(this).val();
        	if(str.length!=0){
	            $.ajax({
	                /* the route pointing to the post function */
	                url:"{{route('search.suggest')}}",
	                // url:'http://ecommerce.dev/ajax/subcategories/'+c_id,
	                data: { word : str },
	                type: 'GET',

	                success: function (response) {
	                	console.log(response);
	                    var txt="";
	                    for (x in response){
	                    	// alert(response[x].name);
	                        txt +="<option value=\'"+response[x].name+"\'>";
	                    }
	                    $("#suggestions").empty();
	                    $("#suggestions").append(txt);
	                }
	            });
        	}
        });

    });
</script>

@yield('script')

</body>
</html>