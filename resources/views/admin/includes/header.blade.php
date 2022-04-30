<header class="main-header">
    <!-- Logo -->
    <a href="~/Administrator/DashBoard/Index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Shop</b>Sheyn</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a
            href="#"
            class="sidebar-toggle"
            data-toggle="push-menu"
            role="button"
        >
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a
                        href="#"
                        class="dropdown-toggle"
                        data-toggle="dropdown"
                    >
                        <img
                            src="~/assets/img/admin/@{{
                                admin.Image
                            }}"
                            class="user-image"
                            alt="@{{ admin.PersonName }}"
                        />
                        <span class="hidden-xs">@{{
                            admin.PersonName
                        }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img
                                src="/admin2/dist/img/user2-160x160.jpg"
                                class="img-circle"
                                alt="User Image"
                            />

                            <p>
                                Alexander Pierce
                                <small
                                    >Member since Nov. 2012</small
                                >
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a
                                    href="#"
                                    class="btn btn-default btn-flat"
                                    >Hồ sơ</a
                                >
                            </div>
                            <div class="pull-right">
                                <a
                                    href="#"
                                    class="btn btn-default btn-flat"
                                    ng-click="Logout()"
                                    >Đăng xuất</a
                                >
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"
                        ><i class="fa fa-gears"></i
                    ></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
