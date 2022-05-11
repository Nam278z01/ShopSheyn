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
            { id: 0, title: "Đang xử lý" },
            { id: 1, title: "Đang giao" },
            { id: 2, title: "Đã giao" },
            { id: 3, title: "Đã hủy" },
            { id: 4, title: "Hoàn trả" },
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
    }
);
