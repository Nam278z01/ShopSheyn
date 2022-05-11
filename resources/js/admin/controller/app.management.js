myApp.constant("API_URL", "");

myApp.filter("jsDate", function () {
    // return function (x) {
    //     return x.replace("/Date(", "").replace(")/", "");
    // };
    return function (x) {
        return new Date(x)
    };
});

myApp.config(function ($mdThemingProvider) {
    $mdThemingProvider.theme("success-toast");
    $mdThemingProvider.theme("warning-toast");
    $mdThemingProvider.theme("error-toast");
    $mdThemingProvider.theme("info-toast");
});

myApp.filter("cvOrderState", function () {
    return function (x) {
        if (x == 0) {
            return "Đang xử lý";
        } else if (x == 1) {
            return "Đang giao";
        } else if (x == 2) {
            return "Đã giao";
        } else if (x == 3) {
            return "Đã hủy";
        } else {
            return "Hoàn trả";
        }
    };
});

myApp.factory(
    "customerService",
    function ($http, localStorageService, API_URL) {
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
    }
);

myApp.controller(
    "LoginManagementController",
    function (
        $scope,
        $rootScope,
        $http,
        API_URL,
        $mdDialog,
        NgTableParams,
        Upload,
        $timeout,
        customerService,
        $location
    ) {
        $rootScope.login = function () {
            customerService.login(
                $scope.accountname,
                $scope.password,
                function (res) {
                    if (res.data.status_code == 200) {
                        document.location.href = '/admin';
                    }
                },
                function (err) {}
            );
        };
    }
);

myApp.run(function ($rootScope, $http, API_URL, $mdToast, customerService, $window) {

    if (customerService.checkIfLoggedIn()) {
        $http({
            method: "GET",
            url: API_URL + "/api/admin",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.is_login = true;
            $rootScope.admin = res.data;
        });
    }

    $rootScope.logout = function () {
        $http({
            method: "DELETE",
            url: API_URL + "/api/logout",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            if (res.data.status_code == 200) {
                customerService.logout();
                $window.location.reload();
            }
        });
    };

    // Sidebar active
    $rootScope.currentIndex = -1;
    $rootScope.currentSubIndex = -1;
    $rootScope.isActiveNav = function (index) {
        return index == $rootScope.currentIndex;
    };
    $rootScope.isActiveSubNav = function (index) {
        return index == $rootScope.currentSubIndex;
    };
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
});
