myApp.controller(
    "OrderController",
    function (
        $scope,
        $rootScope,
        $http,
        $location,
        $routeParams,
        API_URL,
        customerService
    ) {
        if ($location.path() == "/orders") {
            $http({
                method: "GET",
                url: API_URL + "/api/order",
                headers: {
                    "Content-Type": "application/json",
                    Authorization:
                        "Bearer " + customerService.getCurrentToken(),
                },
            }).then((res) => {
                $rootScope.orders = res.data;
            });
        }

        if ($location.path() == "/orderdetails") {
            $http({
                method: "GET",
                url: API_URL + "/api/order/" + $routeParams.order_id,
                headers: {
                    "Content-Type": "application/json",
                    Authorization:
                        "Bearer " + customerService.getCurrentToken(),
                },
            }).then((res) => {
                $rootScope.order = res.data;
            });
        }

        if ($rootScope.customer) {
            $scope.name = $rootScope.customer.customer_name;
            $scope.address = $rootScope.customer.customer_address;
            $scope.phone = $rootScope.customer.customer_phone;
        }

        $scope.isPaying = false;
        $scope.checkout = function () {
            if (!$rootScope.is_login) {
                $rootScope.showModalLogin();
                return false;
            }
            if (!$scope.isPaying && $rootScope.cart.length) {
                $scope.isPaying = true;
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
                        Authorization:
                            "Bearer " + customerService.getCurrentToken(),
                    },
                }).then((res) => {
                    $rootScope.cart = [];
                    $scope.isPaying = false;
                    $rootScope.total_price = 0;
                });
            }
        };

        $scope.order_state = -1;
        $scope.setOrderState = function (type) {
            $scope.order_state = type;
        };

        $scope.searchOrderByState = function (row) {
            if ($scope.order_state == -1) {
                return true;
            } else {
                return (
                    row.orderstates[row.orderstates.length - 1]
                        .orderstate_name == $scope.order_state
                );
            }
        };
    }
);
