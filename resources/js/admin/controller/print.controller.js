myApp.controller(
    "PrintController",
    function ($scope, $rootScope, $http, API_URL, adminService) {
        $scope.isLoading = true;
        $http({
            method: "GET",
            url: API_URL + "/api/admin/order/" +  sessionStorage.getItem("order_id"),
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + adminService.getCurrentToken(),
            },
        }).then((res) => {
            $scope.order = res.data;
            $scope.isLoading = false;
        });
    }
);
