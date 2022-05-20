myApp.controller(
    "OrderManagementController",
    function (
        $scope,
        $rootScope,
        $http,
        API_URL,
        $mdDialog,
        NgTableParams,
        Upload,
        customerService,
        $timeout
    ) {
        $rootScope.currentIndex = 1;
        $rootScope.currentSubIndex = 2;

        $scope.order_states = [
            { id: "", title: "" },
            { id: 0, title: "Đơn hàng Đang xử lý" },
            { id: 1, title: "Đơn hàng Đang giao" },
            { id: 2, title: "Đơn hàng Đã giao" },
            { id: 3, title: "Đơn hàng Đã hủy" },
            { id: 4, title: "Đơn hàng Hoàn trả" },
        ];

        $http({
            method: "GET",
            url: API_URL + "/api/order/get-all",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.orders = res.data;
            $rootScope.orders.forEach((order) => {
                order.order_state_current =
                    order.orderstates[
                        order.orderstates.length - 1
                    ].orderstate_name;
            });

            $scope.tableParams = new NgTableParams(
                {
                    page: 1, // show first page
                    count: 10, // count per page
                },
                {
                    filterDelay: 0,
                    dataset: $scope.orders,
                }
            );
        });

        $scope.showModalDetails = function (order) {
            $rootScope.order = JSON.parse(JSON.stringify(order));
            $rootScope.order.order_state_change = $scope.order_states.find(
                (os) => os.id === $rootScope.order.order_state_current
            );
        };

        $scope.updateOrderState = function () {
            $http({
                method: "POST",
                url: API_URL + "/api/order/update-order-state",
                data: {
                    order_id: $rootScope.order.order_id,
                    orderstate_name: $rootScope.order.order_state_change.id,
                },
                headers: {
                    "Content-Type": "application/json",
                    Authorization:
                        "Bearer " + customerService.getCurrentToken(),
                },
            }).then((res) => {
                if (res.data) {
                    let index = $rootScope.orders.findIndex(
                        (o) => o.order_id === $rootScope.order.order_id
                    );
                    $rootScope.orders[index].orderstates.push(res.data);
                    $rootScope.orders[index].order_state_current = res.data.orderstate_name

                    $scope.showModalDetails($rootScope.orders[index])

                    $scope.tableParams.reload();

                    $rootScope.showSimpleToast(
                        "Cập nhập trạng thái đơn hàng thành công!",
                        "success"
                    );
                } else {
                    $rootScope.showSimpleToast(
                        "Đơn hàng đang ở trạng thái này!",
                        "warning"
                    );
                }
            });
        };
    }
);
