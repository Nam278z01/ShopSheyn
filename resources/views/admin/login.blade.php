<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="/image/product/icon.png" />
        <title>Shop Sheyn</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport"
        />
        <link href="/css/admin.css" rel="stylesheet" />
        <!-- Google Font -->
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
        />
    </head>
    <body ng-app="myApp" ng-controller="LoginManagementController">
        <div class="login-box">
            <div class="login-logo">
                <a href="/admin"><b>Shop</b>Sheyn</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <form>
                    <div class="form-group has-feedback">
                        <input
                            ng-model="accountname"
                            type="text"
                            class="form-control"
                            placeholder="Tên tài khoản"
                        />
                        <span
                            class="glyphicon glyphicon-envelope form-control-feedback"
                        ></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input
                            ng-model="password"
                            type="password"
                            class="form-control"
                            placeholder="Mật khẩu"
                        />
                        <span
                            class="glyphicon glyphicon-lock form-control-feedback"
                        ></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="col-xs-8">
                                <label>
                                    <a href="#">Quên mật khẩu?</a><br>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button
                                ng-click="login()"
                                type="submit"
                                class="btn btn-primary btn-block btn-flat"
                            >
                                Đăng nhập
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- ./wrapper -->
        <script src="/js/app.js"></script>
        <script src="/js/admin.js"></script>
    </body>
</html>
