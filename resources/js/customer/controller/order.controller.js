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
                $rootScope.orders.forEach((order) => {
                    order.order_state_current =
                        order.orderstates[order.orderstates.length - 1];
                });
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
            let quantity = $rootScope.cart.filter(product => product.chose).length
            if (!$scope.isPaying && quantity) {
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
                    if (res.data.status == "success") {
                        $rootScope.cart = $rootScope.cart.filter(
                            (product) => !product.chose
                        );
                        $scope.isPaying = false;
                        $rootScope.recalculateTotalPrice();
                        $location
                            .path("/orderdetails")
                            .search({ order_id: res.data.order_id });
                    } else {
                        // Get Cart
                        $http({
                            method: "GET",
                            url: API_URL + "/api/cart",
                        }).then((res) => {
                            $rootScope.cart = res.data;
                            $rootScope.cart.forEach((product) => {
                                product.picked = {};
                                product.picked.quantity = product.quantity;
                                product.colors.forEach((color) => {
                                    color.sizes.forEach((size) => {
                                        if (product.size_id == size.size_id) {
                                            product.picked.color = color;
                                            product.picked.size = size;
                                        }
                                    });
                                });
                            });
                            $scope.isPaying = false;
                            $rootScope.recalculateTotalPrice();
                            $rootScope.showSnackbar(
                                "Không thể đặt hàng do có sản phẩm có số lượng đặt vượt quá số lượng trong kho hàng"
                            );
                        });
                    }
                });
            }
            if (!quantity) {
                $rootScope.showSnackbar(
                    "Vui lòng chọn sản phẩm cần đặt hàng!"
                );
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
                    row.order_state_current.orderstate_name ==
                    $scope.order_state
                );
            }
        };

        $scope.chose_all = {
            value:
                $rootScope.cart.filter((product) => {
                    return product.chose;
                }).length == $rootScope.cart.length,
        };

        $scope.choseAll = function () {
            $http({
                method: "PUT",
                url: API_URL + "/api/cart/chose-all",
                data: {
                    value: $scope.chose_all.value,
                },
            }).then((res) => {
            });
            $rootScope.cart.forEach((product) => {
                product.chose = $scope.chose_all.value;
            });
            $rootScope.recalculateTotalPrice();
        };

        $scope.chose = function (product) {
            $http({
                method: "PUT",
                url: API_URL + "/api/cart/chose",
                data: {
                    cart_id: product.cart_id,
                    value: product.chose,
                },
            }).then((res) => {
            });
            $scope.chose_all.value =
                $rootScope.cart.filter((product) => {
                    return product.chose;
                }).length == $rootScope.cart.length;
            $rootScope.recalculateTotalPrice();
        };
    }
);
