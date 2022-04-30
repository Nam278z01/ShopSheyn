<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="/image/icon.png" />
        <title>Shop Sheyn</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport"
        />
        <!-- Bootstrap 3.3.7 -->
        <link
            href="/admin2/bower_components/bootstrap/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <!-- Font Awesome -->
        <link
            href="/admin2/bower_components/font-awesome/css/font-awesome.min.css"
            rel="stylesheet"
        />
        <!-- Ionicons -->
        <link
            href="/admin2/bower_components/Ionicons/css/ionicons.min.css"
            rel="stylesheet"
        />
        <!-- Theme style -->
        <link
            href="/admin2/dist/css/AdminLTE.min.css"
            rel="stylesheet"
        />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link
            href="/admin2/dist/css/skins/_all-skins.min.css"
            rel="stylesheet"
        />

        <link href="~/Content/ng-table.min.css" rel="stylesheet" />
        <link href="~/Content/select.min.css" rel="stylesheet" />
        <!-- Select2 ui-->
        <link
            href="/admin2/bower_components/select2/dist/css/select2.css"
            rel="stylesheet"
        />
        <!-- Google Font -->
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
        />
        <!-- jQuery 3 -->
        <script src="/admin2/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Angularjs -->
        <script src="~/Scripts/angular.min.js"></script>
        <script src="~/Scripts/angular-sanitize.min.js"></script>
        <script src="~/Scripts/ng-table.min.js"></script>
        <script src="~/Scripts/select.min.js"></script>
        <script src="~/Scripts/ng-file-upload.min.js"></script>
        <script src="~/Scripts/dirPagination.js"></script>
        <script src="~/Scripts/AdminController/app.management.js"></script>
        <style>
            /*Table sticky 2 cột (đầu và cuối)*/
            table.stickytb > thead > tr > th:last-child {
                position: sticky;
                right: 0;
                background-color: rgb(236 240 245);
            }

            table.stickytb > thead > tr > th:first-child {
                position: sticky;
                left: 0;
                background-color: rgb(236 240 245);
            }

            table.stickytb > tbody > tr > td:last-child {
                position: sticky;
                right: 0;
                background-color: rgb(236 240 245);
            }

            table.stickytb > tbody > tr > td:first-child {
                position: sticky;
                left: 0;
                background-color: rgb(236 240 245);
            }

            table.stickytb > tbody > tr:nth-child(2n + 1) > td {
                background-color: rgb(236 240 245);
            }

            table.stickytb > tbody > tr:nth-child(2n) > td {
                background-color: #f9f9f9;
            }

            table > tbody > tr > td > span + span:before {
                content: ",";
                display: inline;
                position: relative;
                padding-right: 2px;
            }

            table td img {
                width: 36px;
                height: 36px;
                border-radius: 100%;
                object-fit: cover;
            }

            /*Toast / Snackbar*/
            #snackbar {
                min-width: 250px;
                margin-left: -125px;
                color: #fff;
                text-align: center;
                border-radius: 2px;
                padding: 16px;
                position: fixed;
                z-index: 9999;
                left: 50%;
                top: -60px;
                font-size: 17px;
                opacity: 0;
            }

            #snackbar.show {
                top: 30px;
                opacity: 1;
                transition: top linear 0.2s, opacity linear 0.2s;
            }

            .artist-mana + .artist-mana::before {
                content: ", ";
            }
        </style>
    </head>
    <body
        ng-app="myApp"
        class="hold-transition skin-blue sidebar-mini fixed"
    >
        <!-- Toast / Snackbar -->
        <div id="snackbar">@{{ snackbarContent }}</div>
        <!-- Site wrapper -->
        <div class="wrapper">
            @include('admin.includes.header')

            <!-- Left side column. contains the sidebar -->
            @include('admin.includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li>
                        <a href="#control-sidebar-home-tab" data-toggle="tab"
                            ><i class="fa fa-home"></i
                        ></a>
                    </li>

                    <li>
                        <a
                            href="#control-sidebar-settings-tab"
                            data-toggle="tab"
                            ><i class="fa fa-gears"></i
                        ></a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>

            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Bootstrap 3.3.7 -->
        <script src="/admin2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="/admin2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="/admin2/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="/admin2/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/admin2/dist/js/demo.js"></script>

        <script>
            $(document).ready(function () {
                $(".sidebar-menu").tree();
            });
        </script>
    </body>
</html>
