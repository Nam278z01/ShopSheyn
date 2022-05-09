import { ngTableDefaults } from "ng-table/src/core/ngTableDefaults";

myApp.controller('OrderController', function ($scope, $rootScope, $http, $location, $routeParams, API_URL, customerService) {


    if ($location.path() == '/orders') {
        $http({
            method: "GET",
            url: API_URL + "/api/order",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.orders = res.data.data;
        });
    }

    $scope.name = $rootScope.customer.customer_name
    $scope.address = $rootScope.customer.customer_address
    $scope.phone = $rootScope.customer.customer_phone
    $scope.checkout = function () {
        $http({
            method: "POST",
            url: API_URL + "/api/order",
            data: {
                customer_name: $scope.name,
                customer_address: $scope.address,
                customer_phone: $scope.phone,
                note: $scope.note,
            },
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.cart = null;
        });
    }

})
