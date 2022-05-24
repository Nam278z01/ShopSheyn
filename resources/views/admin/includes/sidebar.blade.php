<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image" style="display: flex; align-items: center">
                <img
                    ng-src="/image/img/@{{ admin.image }}"
                    class="img-circle"
                    alt="@{{ admin.admin_name }}"
                />
            </div>
            <div class="pull-left info">
                <p>@{{admin.admin_name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">ĐIỀU HƯỚNG CHÍNH</li>
            <li class="" ng-class="{ active: isActiveNav(0) }">
                <a href="/admin">
                    <i class="fa fa-dashboard"></i>
                    <span>Bảng điều khiển</span>
                </a>
            </li>
            <li
                class="treeview"
                ng-class="{ active: isActiveNav(1) }"
            >
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Quản lý</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ng-class="{ active: isActiveSubNav(0) }">
                        <a href="/admin/category"
                            ><i class="fa fa-circle-o"></i>Danh mục</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(1) }">
                        <a
                            href="/admin/product"
                            ><i class="fa fa-circle-o"></i>Sản phẩm</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(2) }">
                        <a href="/admin/order"
                            ><i class="fa fa-circle-o"></i>Đơn hàng</a
                        >
                    </li>
                </ul>
            </li>
            <li
                class="treeview"
                ng-class="{ active: isActiveNav(2) }"
            >
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Đối tượng</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ng-class="{ active: isActiveSubNav(5) }">
                        <a href="#"
                            ><i class="fa fa-circle-o"></i>Admin</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(6) }">
                        <a href="#"
                            ><i class="fa fa-circle-o"></i>Người
                            dùng</a
                        >
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
