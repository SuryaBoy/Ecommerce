  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('dashboard/dist/img/avatar.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::guard('admin')->user()->name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="{{route('search')}}" method="get" class="sidebar-form" autocomplete="off">
        <div class="input-group">
          <input list="suggestions" id="q" type="text" name="q" class="form-control" placeholder="Search Product...">
          <datalist id="suggestions">

          </datalist>
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li>
          <a href="{{route('admin.dashboard')}}">
            <i class="glyphicon glyphicon-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="{{route('categories.index')}}">
            <i class="glyphicon glyphicon-th-large"></i><span>Categories</span>
          </a>
        </li>

        <li>
          <a href="{{route('subcategories.index')}}">
            <i class="fa fa-bars"></i><span>Sub Categories</span>
          </a>
        </li>

        <li>
          <a href="{{route('brand.index')}}">
            <i class="glyphicon glyphicon-star"></i><span>Brand</span>
          </a>
        </li>

        <li>
          <a href="{{route('product.index')}}">
            <i class="fa fa-bars"></i><span>Products</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-record"></i><span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{route('order.showProcessingOrders')}}">
                <i class="fa fa-circle-o"></i><span>Processing Orders</span>
              </a>
            </li>
            <li>
              <a href="{{route('order.showShippingOrders')}}">
                <i class="fa fa-circle-o"></i><span>Shipping Orders</span>
              </a>
            </li>
            <li>
              <a href="{{route('order.showDeliveredOrders')}}">
                <i class="fa fa-circle-o"></i><span>Delivered Orders</span>
              </a>
            </li>
          </ul>
        </li>

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>