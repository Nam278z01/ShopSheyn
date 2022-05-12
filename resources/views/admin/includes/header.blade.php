<header class="main-header">
    <!-- Logo -->
    <a href="~/Administrator/DashBoard/Index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Adidas</b></span>
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
                            ng-src="/image/img/@{{
                                admin.image
                            }}"
                            class="user-image"
                            alt="@{{ admin.admin_name }}"
                        />
                        <span class="hidden-xs">@{{
                            admin.admin_name
                        }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img
                                ng-src="/image/img/@{{
                                    admin.image
                                }}"
                                class="img-circle"
                                alt="@{{ admin.admin_name }}"
                            />

                            <p>
                                @{{ admin.admin_name }}
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
                                    ng-click="logout()"
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
