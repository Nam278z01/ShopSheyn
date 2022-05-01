myApp.controller(
    "ProductManagementController",
    function (
        $scope,
        $rootScope,
        $http,
        API_URL,
        $mdDialog,
        NgTableParams,
        Upload
    ) {
        $rootScope.currentIndex = 1;
        $rootScope.currentSubIndex = 1;

        $http({
            method: "GET",
            url: API_URL + "/api/product",
        }).then((res) => {
            $scope.products = res.data.data;

            $scope.tableParams = new NgTableParams(
                {
                    page: 1, // show first page
                    count: 10, // count per page
                },
                {
                    filterDelay: 0,
                    dataset: $scope.products,
                }
            );
        });

        $http({
            method: "GET",
            url: API_URL + "/api/category",
        }).then((res) => {
            $scope.categories = res.data.data;
        });
    }
);
