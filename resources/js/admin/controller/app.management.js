myApp.constant("API_URL", "");

myApp.filter("jsDate", function () {
    return function (x) {
        return x.replace("/Date(", "").replace(")/", "");
    };
});

myApp.config(function ($mdThemingProvider) {
    $mdThemingProvider
        .theme("success-toast");
    $mdThemingProvider
        .theme("warning-toast");
    $mdThemingProvider
        .theme("error-toast");
    $mdThemingProvider
        .theme("info-toast");
});

myApp.run(function ($rootScope, $http, API_URL, $mdToast) {
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
