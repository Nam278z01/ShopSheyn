myApp.controller(
    "DashBoardController",
    function ($scope, $rootScope, $http, API_URL, adminService, $filter) {
        $rootScope.currentIndex = 0;
        $rootScope.currentSubIndex = -1;

        $http({
            method: "GET",
            url: API_URL + "/api/admin/statistic/order-state",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + adminService.getCurrentToken(),
            },
        }).then((res) => {
            $scope.quantity_order_new = res.data.quantity_order_new;
            $scope.quantity_the_others = res.data.quantity_the_others;
        });

        $scope.months = [
            {
                id: 1,
                title: "Tháng 1"
            },
            {
                id: 2,
                title: "Tháng 2"
            },
            {
                id: 3,
                title: "Tháng 3"
            },
            {
                id: 4,
                title: "Tháng 4"
            },
            {
                id: 5,
                title: "Tháng 5"
            },
            {
                id: 6,
                title: "Tháng 6"
            },
            {
                id: 7,
                title: "Tháng 7"
            },
            {
                id: 8,
                title: "Tháng 8"
            },
            {
                id: 9,
                title: "Tháng 9"
            },
            {
                id: 10,
                title: "Tháng 10"
            },
            {
                id: 11,
                title: "Tháng 11"
            },
            {
                id: 12,
                title: "Tháng 12"
            }
        ];

        $scope.month = $scope.months[new Date().getMonth()].id;

        function chart(month) {
            $http({
                method: "GET",
                url: API_URL + "/api/admin/statistic/revenue/2022/" + month,
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + adminService.getCurrentToken(),
                },
            }).then((res) => {
                let days = res.data.days.reduce(
                    (results, current) => [
                        ...results,
                        $filter("date")(new Date(current.date_field), "dd-MM"),
                    ],
                    []
                );

                let quantity_of_order_delivered_by_day = []
                let quantity_of_order_canceled_by_day = []
                let quantity_of_order_refund_by_day = []

                res.data.order_state_count.forEach(item => {
                    quantity_of_order_delivered_by_day.push(item.delivered)
                    quantity_of_order_canceled_by_day.push(item.canceled)
                    quantity_of_order_refund_by_day.push(item.refund)
                });


                $scope.sum = 0;
                let total_by_day = res.data.total_by_day.reduce(
                    (results, current) => {
                        $scope.sum += current.total;
                        return [...results, current.total]
                    },
                    []
                );

                $scope.myJson = {
                    type: "mixed",
                    title: {
                        text: `Tổng doanh thu Tháng ${month} (năm ${new Date().getFullYear()}): ${$filter("number")($scope.sum, "0")}₫`,
                        align: "left",
                        marginLeft: "23%",
                        fontSize: "16px",
                    },
                    legend: {
                        adjustLayout: true,
                        verticalAlign: "bottom",
                    },
                    scaleX: {
                        labels: days, // one label for every datapoint
                    },
                    scaleY: {
                        guide: {
                            // dashed lines
                            visible: false,
                        },
                        label: {
                            text: "Số đơn hàng",
                            fontSize: "14px",
                        },
                    },
                    scaleY2: {
                        label: {
                            text: "Doanh thu (VNĐ)",
                            fontSize: "14px",
                        },
                        "thousands-separator": ",",
                        // maxValue: 100,
                        // minValue: 0,
                        // step: 25, // can define scale step values or default
                    },
                    crosshairX: {
                        lineColor: "#424242",
                        lineGapSize: "4px",
                        lineStyle: "dotted",
                        plotLabel: {
                            padding: "15px",
                            backgroundColor: "white",
                            bold: true,
                            borderColor: "#e3e3e3",
                            borderRadius: "5px",
                            fontColor: "#2f2f2f",
                            fontFamily: "Lato",
                            fontSize: "12px",
                            shadow: true,
                            shadowAlpha: 0.2,
                            shadowBlur: 5,
                            shadowColor: "#a1a1a1",
                            shadowDistance: 4,
                            textAlign: "left",
                        },
                        scaleLabel: {
                            backgroundColor: "#424242",
                        },
                    },
                    series: [
                        {
                            type: "bar",
                            text: "Doanh thu (VNĐ)",
                            values: total_by_day,
                            backgroundColor: "#00a65a",
                            scales: "scale-x, scale-y-2",
                            "thousands-separator": ",",
                        },
                        {
                            type: "line",
                            text: "Đã giao",
                            values: quantity_of_order_delivered_by_day,
                            lineColor: "#42a5f5",
                            marker: {
                                type: "square",
                                backgroundColor: "#42a5f5",
                            },
                            scales: "scale-x, scale-y",
                        },
                        {
                            type: "line",
                            text: "Đã hủy",
                            values: quantity_of_order_canceled_by_day,
                            lineColor: "#dd4b39 ",
                            marker: {
                                type: "square",
                                backgroundColor: "#dd4b39 ",
                            },
                            scales: "scale-x, scale-y",
                        },
                        {
                            type: "line",
                            text: "Hoàn trả",
                            values: quantity_of_order_refund_by_day,
                            lineColor: "#ffa726",
                            marker: {
                                type: "square",
                                backgroundColor: "#ffa726",
                            },
                            scales: "scale-x, scale-y",
                        },
                    ],
                };
            });
        }

        chart($scope.month);

        $scope.changeMonth = function () {
            chart($scope.month);
        }
    }
);
