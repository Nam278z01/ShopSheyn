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
                $scope.orders = res.data;
                $scope.orders.forEach((order) => {
                    order.order_state_current =
                        order.orderstates[order.orderstates.length - 1];
                });
            });

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
        } else if ($location.path() == "/orderdetails") {
            $http({
                method: "GET",
                url: API_URL + "/api/order/" + $routeParams.order_id,
                headers: {
                    "Content-Type": "application/json",
                    Authorization:
                        "Bearer " + customerService.getCurrentToken(),
                },
            }).then((res) => {
                $scope.order = res.data;
            });

            $scope.updateOrderState = function (orderstate_name) {
                $http({
                    method: "PUT",
                    url: API_URL + "/api/order/" + $routeParams.order_id,
                    data: {
                        orderstate_name: orderstate_name
                    },
                    headers: {
                        "Content-Type": "application/json",
                        Authorization:
                            "Bearer " + customerService.getCurrentToken(),
                    },
                }).then((res) => {
                    $scope.order.orderstates.push(res.data);

                    if (orderstate_name == 3) {
                        $rootScope.showSnackbar(
                            "H???y ????n h??ng th??nh c??ng!"
                        );
                    } else {
                        $rootScope.showSnackbar(
                            "Ho??n tr??? ????n h??ng th??nh c??ng!"
                        );
                    }
                });
            }
        } else {
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
                                $rootScope.mapCart();

                                $scope.isPaying = false;
                                $rootScope.recalculateTotalPrice();
                                $rootScope.showSnackbar(
                                    "Kh??ng th??? ?????t h??ng do c?? s???n ph???m c?? s??? l?????ng ?????t v?????t qu?? s??? l?????ng trong kho h??ng"
                                );
                            });
                        }
                    });
                }
                if (!quantity) {
                    $rootScope.showSnackbar(
                        "Vui l??ng ch???n s???n ph???m c???n ?????t h??ng!"
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
    }
);
