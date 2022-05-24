myApp.controller(
    "OrderManagementController",
    function ($scope, $rootScope, $http, API_URL, NgTableParams, adminService) {
        $rootScope.currentIndex = 1;
        $rootScope.currentSubIndex = 2;

        function mapOrders(orders) {
            orders.forEach((order) => {
                order.order_state_current =
                    order.orderstates[
                        order.orderstates.length - 1
                    ].orderstate_name;
            });
        }

        function mapOrder(order) {
            order.order_state_current =
                order.orderstates[order.orderstates.length - 1].orderstate_name;
        }

        function findOrder(order) {
            let index = $rootScope.orders.findIndex(
                (o) => o.order_id === order.order_id
            );
            return index;
        }

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
            url: API_URL + "/api/admin/order",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + adminService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.orders = res.data;
            mapOrders($rootScope.orders);

            $scope.tableParams = new NgTableParams(
                {
                    page: 1,
                    count: 10,
                },
                {
                    filterDelay: 0,
                    dataset: $scope.orders,
                }
            );
        });

        $scope.showModalDetails = function (order) {
            $http({
                method: "GET",
                url:
                    API_URL +
                    "/api/admin/order/" +
                    order.order_id,
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + adminService.getCurrentToken(),
                },
            }).then((res) => {
                let index = findOrder(order);
                $rootScope.orders[index] = res.data;
                mapOrder($rootScope.orders[index]);
                $scope.tableParams.reload();

                $rootScope.order = JSON.parse(
                    JSON.stringify($rootScope.orders[index])
                );
                $rootScope.order.order_state_change = $scope.order_states.find(
                    (os) => os.id === $rootScope.order.order_state_current
                );
            });
        };

        $scope.updateOrderState = function () {
            $http({
                method: "PUT",
                url: API_URL + "/api/admin/order/" + $rootScope.order.order_id,
                data: {
                    orderstate_name: $rootScope.order.order_state_change.id,
                },
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + adminService.getCurrentToken(),
                },
            }).then((res) => {
                if (res.data) {
                    $rootScope.order.orderstates.push(res.data);
                    mapOrder($rootScope.order);

                    let index = findOrder($rootScope.order);
                    $rootScope.orders[index].orderstates.push(res.data);
                    mapOrder($rootScope.orders[index]);

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
