<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img
                    src="~/assets/img/admin/@{{ admin.Image }}"
                    class="img-circle"
                    alt="@{{ admin.PersonName }}"
                />
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">ĐIỀU HƯỚNG CHÍNH</li>
            <li class="" ng-class="{ active: isActiveNav(0) }">
                <a href="~/Administrator/DashBoard/Index">
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
                        <a href="~/Administrator/SongMana/Index"
                            ><i class="fa fa-circle-o"></i>Danh mục</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(1) }">
                        <a
                            href="~/Administrator/PlaylistAdminMana/Index"
                            ><i class="fa fa-circle-o"></i>Sản phẩm</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(2) }">
                        <a href="~/Administrator/AlbumMana/Index"
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
                        <a href="~/Administrator/AdminMana/Index"
                            ><i class="fa fa-circle-o"></i>Admin</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(6) }">
                        <a href="~/Administrator/UserMana/Index"
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
