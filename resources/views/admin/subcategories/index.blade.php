@extends('admin.layouts.master')

@section('content')

    <script language="javascript">
        function ConfirmDelete()
        {
            return confirm("Are you sure to delete?") ;
        }
    </script>

    <div>
        <a class="btn btn-info	" href="{{route('subcategories.create')}}">Add Sub Category for Category</a>

    </div>
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table id="example1" align=center  class='table table-striped table-bordered'>
                        <thead>
                        <th>Parent Category</th>
                        <th>Name</th>
                        <th>Action</th>
                        </thead>

                        @foreach($subcategories as $c)
                            <tr>
                                <td>{{App\Category::where('id',$c->category_id)->first()->name}}</td>

                                <td>{{$c->name}}</td>
                                <td><a  href="edit/{{$c->id}}"><i class="fa fa-edit"></i></a>

                                    &middot;<a onclick='return ConfirmDelete()' href="{{url('subcategories/destroy',$c->id)}}" class="text-danger fa fa-remove"></a> </td>

                            </tr>
                        @endforeach
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection
