<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> Thống kê</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-cube fa-fw"></i> Danh mục sản phẩm<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('category.list') }}">Danh sách</a>
                    </li>
                    <li>
                        <a href="{{ route('category.add.form') }}">Thêm mới</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Nhà cung cấp<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('supplier.list') }}">Danh sách</a>
                    </li>
                    <li>
                        <a href="{{ route('supplier.add.form') }}">Thêm mới</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-adjust" aria-hidden="true"></i> Màu sắc<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('color.list') }}">Danh sách</a>
                    </li>
                    <li>
                        <a href="{{ route('color.add.form') }}">Thêm mới</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-list" aria-hidden="true"></i> Size<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('size.list') }}">Danh sách</a>
                    </li>
                    <li>
                        <a href="{{ route('size.add.form') }}">Thêm mới</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-dropbox" aria-hidden="true"></i> Sản phẩm<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('product.list') }}">Danh sách</a>
                    </li>
                    <li>
                        <a href="{{ route('product.add.form') }}">Thêm mới</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Người dùng<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('customer.list') }}">Danh sách</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-usd" aria-hidden="true"></i> Đơn hàng<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('order.list') }}">Danh sách</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ route('setting') }}"><i class="fa fa-cogs" aria-hidden="true"></i> Thiết lập trang web</a>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>