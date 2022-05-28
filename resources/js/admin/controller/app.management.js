myApp.constant("API_URL", "");

myApp.filter("jsDate", function () {
    return function (x) {
        return new Date(x);
    };
});

myApp.config(function ($mdThemingProvider) {
    $mdThemingProvider.theme("success-toast");
    $mdThemingProvider.theme("warning-toast");
    $mdThemingProvider.theme("error-toast");
    $mdThemingProvider.theme("info-toast");
});

myApp.filter("cvOrderState", function () {
    return function (name) {
        switch (name) {
            case 0:
                return "Đang xử lý";
            case 1:
                return "Đang giao";
            case 2:
                return "Đã giao";
            case 3:
                return "Đã hủy";
            default:
                return "Hoàn trả";
        }
    };
});

myApp.factory("adminService", function ($http, localStorageService, API_URL) {
    function checkIfLoggedIn() {
        if (localStorageService.get("authTokenAdmin")) return true;
        else return false;
    }
    function login(email, password, onSuccess, onError) {
        $http({
            method: "POST",
            url: API_URL + "/api/login/admin",
            data: {
                accountname: email,
                password: password,
            },
            "Content-Type": "application/json",
        }).then(
            function (response) {
                localStorageService.set(
                    "authTokenAdmin",
                    response.data.access_token
                );
                onSuccess(response);
            },
            function (response) {
                onError(response);
            }
        );
    }

    function logout() {
        localStorageService.remove("authTokenAdmin");
    }

    function getCurrentToken() {
        return localStorageService.get("authTokenAdmin");
    }

    return {
        checkIfLoggedIn: checkIfLoggedIn,
        login: login,
        logout: logout,
        getCurrentToken: getCurrentToken,
    };
});

myApp.controller(
    "LoginManagementController",
    function ($scope, $rootScope, adminService) {
        $rootScope.login = function () {
            adminService.login(
                $scope.accountname,
                $scope.password,
                function (res) {
                    if (res.data.status_code == 200) {
                        document.location.href = "/admin";
                    }
                },
                function (err) {}
            );
        };

        if (adminService.checkIfLoggedIn()) {
            document.location.href = "/admin";
        }
    }
);

myApp.run(function (
    $rootScope,
    $http,
    API_URL,
    $mdToast,
    adminService,
    $window
) {
    // Sidebar active
    $rootScope.currentIndex = -1;
    $rootScope.currentSubIndex = -1;
    $rootScope.isActiveNav = function (index) {
        return index == $rootScope.currentIndex;
    };
    $rootScope.isActiveSubNav = function (index) {
        return index == $rootScope.currentSubIndex;
    };

    $rootScope.$on("$routeChangeStart", function (evt, absNewUrl, absOldUrl) {
        $window.scrollTo(0, 0);
    });

    // Toast
    $rootScope.showSimpleToast = function (toast_name, type) {
        $mdToast.show(
            $mdToast
                .simple()
                .parent(document.querySelectorAll("#toaster"))
                .position("top right")
                .textContent(toast_name)
                .hideDelay(3000)
                .theme(type + "-toast")
        );
    };

    //Check login
    if (adminService.checkIfLoggedIn()) {
        $http({
            method: "GET",
            url: API_URL + "/api/admin",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + adminService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.is_login = true;
            $rootScope.admin = res.data;
        });
    } else {
        var restrictedPage =
            $.inArray(document.location.pathname, [
                "/admin",
                "/admin/order",
                "/admin/product",
                "/admin/category",
                "/admin/print",
            ]) != -1;
        if (restrictedPage) {
            document.location.href = "/admin/login";
        }
    }

    $rootScope.logout = function () {
        $http({
            method: "DELETE",
            url: API_URL + "/api/logout",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + adminService.getCurrentToken(),
            },
        }).then((res) => {
            if (res.data.status_code == 200) {
                adminService.logout();
                document.location.href = "/admin/login";
            }
        });
    };

    $rootScope.validateNumber = function (e) {
        const pattern = /^[0-9]$/;
        if (!pattern.test(e.key)) {
            e.preventDefault();
        }
    };
});

myApp.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/admin", {
            templateUrl: "/html/admin/dashboard.html",
            controller: "DashBoardController",
        })
        .when("/admin/login", {
        })
        .when("/admin/print", {
        })
        .when("/admin/product", {
            templateUrl: "/html/admin/product-management.html",
            controller: "ProductManagementController",
        })
        .when("/admin/order", {
            templateUrl: "/html/admin/order-management.html",
            controller: "OrderManagementController",
        })
        .when("/admin/category", {
            templateUrl: "/html/admin/category-management.html",
            controller: "OrderManagementController",
        })
        .otherwise({
            redirectTo: "/admin",
        });
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false,
    });
});
