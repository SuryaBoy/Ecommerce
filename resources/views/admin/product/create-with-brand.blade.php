@extends('admin.layouts.master')

@section('content.header','Create Product')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2>Fill In The Form Below:</h2>
            </div>
            <div class="box-body">
                <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="brand_id" value="{{$b_id}}">
                    @if($errors->first('brand_id'))
                        <label class="help-block">
                            <strong>{{$errors->first('brand_id')}}</strong>
                        </label>
                    @endif

                    <div class="form-group">
                        <label for="sub_category_id">
                            Category
                        </label>
                        <select id="category" name="category" class="form-control">
                            <option selected disabled>Select Category</option>
                            @foreach($categories as $c)
                                <option  value="{{$c->id}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sub_category_id">
                            Sub Category
                        </label>
                        <select id="sub-cat" name="sub_category_id" class="form-control">
                            <option id="sub-dis" disabled selected>Select Sub Categories</option>
                        </select>
                        @if($errors->first('sub_category_id'))
                            <label class="help-block">
                                <strong>{{$errors->first('sub_category_id')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Product Name/Model</label>
                        <input type="text" name="name" class="form-control"/>
                        @if($errors->first('name'))
                            <label class="help-block">
                                <strong>{{$errors->first('name')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image">
                        @if($errors->first('image'))
                            <label class="help-block">
                                <strong>{{$errors->first('image')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control"/>
                        @if($errors->first('price'))
                            <label class="help-block">
                                <strong>{{$errors->first('price')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control"/>
                        @if($errors->first('quantity'))
                            <label class="help-block">
                                <strong>{{$errors->first('quantity')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description"></textarea>
                        @if($errors->first('description'))
                            <label class="help-block">
                                <strong>{{$errors->first('description')}}</strong>
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" value="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    
    $(document).ready(function(){
        //check if the selected option in category is not disabled option
        if(!$("#category").val()==""){
            var c_id = $("#category").val();
            $.ajax({
                /* the route pointing to the post function */
                url:'{{route('ajax.subcategories',"")}}/'+c_id,
                // url:'http://ecommerce.dev/ajax/subcategories/'+c_id,
                type: 'GET',

                success: function (response) {
                    var txt="";
                    for (x in response){
                        // alert(response[x].id);
                        // console.log(response);
                        txt +="<option value="+response[x].id+">"+response[x].name+"</option>"
                    }
                    $("#sub-cat").empty();
                    $("#sub-cat").append(txt);
                }
            });
        }
        // if the category option is changed then accordingly change the sub category options
        $("#category").change(function(){
            var c_id = $("#category").val();
           $.ajax({
                /* the route pointing to the post function */
                url:'{{route('ajax.subcategories',"")}}/'+c_id,
                // url:'http://ecommerce.dev/ajax/subcategories/'+c_id,
                type: 'GET',

                success: function (response) {
                    var txt="";
                    for (x in response){
                        // alert(response[x].id);
                        // console.log(response);
                        txt +="<option value="+response[x].id+">"+response[x].name+"</option>"
                    }
                    $("#sub-cat").empty();
                    $("#sub-cat").append(txt);
                }
            });

        });
    });

</script>

@endsection