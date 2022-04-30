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
            <div class="pull-left info">
                <p>@{{ admin.PersonName }}</p>
                <a href="#"
                    ><i class="fa fa-circle text-success"></i>
                    Online</a
                >
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Search..."
                />
                <span class="input-group-btn">
                    <button
                        type="submit"
                        name="search"
                        id="search-btn"
                        class="btn btn-flat"
                    >
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
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
                    <i class="fa fa-music"></i>
                    <span>Quản lý</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ng-class="{ active: isActiveSubNav(0) }">
                        <a href="~/Administrator/SongMana/Index"
                            ><i class="fa fa-circle-o"></i>Bài
                            hát</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(1) }">
                        <a
                            href="~/Administrator/PlaylistAdminMana/Index"
                            ><i class="fa fa-circle-o"></i>Playlist
                            Admin</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(2) }">
                        <a href="~/Administrator/AlbumMana/Index"
                            ><i class="fa fa-circle-o"></i>Album</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(3) }">
                        <a href="~/Administrator/ArtistMana/Index"
                            ><i class="fa fa-circle-o"></i>Nghệ
                            sĩ</a
                        >
                    </li>
                    <li ng-class="{ active: isActiveSubNav(4) }">
                        <a
                            href="~/Administrator/CollectionMana/Index"
                            ><i class="fa fa-circle-o"></i>Tuyển
                            tập</a
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
