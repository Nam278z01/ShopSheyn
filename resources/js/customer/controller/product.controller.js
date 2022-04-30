myApp.controller(
    "ProductController",
    function ($scope, $rootScope, $http, $routeParams, $location, API_URL) {
        $scope.filter = {
            page: $routeParams.page || 1,
            page_size: $routeParams.page_size || 20,
            category_id: $routeParams.category_id,
            list_subcategory_id: $routeParams.list_subcategory_id,
            text_search: $routeParams.text_search,
            min_price: $routeParams.min_price,
            max_price: $routeParams.max_price,
            sort: Number($routeParams.sort) || 1,
        };

        $scope.pageChanged = function (newPage) {
            $location.search("page", newPage);
        };

        $scope.isLoading = true;
        $http({
            method: "GET",
            url: API_URL + "/api/product",
            params: $scope.filter,
        }).then((res) => {
            $scope.products = res.data.data;
            $scope.total_row = res.data.total_row;

            //Khởi tạo màu
            if ($scope.products) {
                $scope.products.map((product) => {
                    product.picked = {};
                    product.picked.color = product.colors[0];
                    return product;
                });
            }

            $scope.isLoading = false;
        });
        $scope.changeColor = function (product, color) {
            product.picked = {};
            product.picked.color = color;
        };

        $rootScope.changeSort = function (type, value) {
            if (type) {
                return (
                    $scope.filter.sort == value &&
                    $location.path() == "/product"
                );
            } else {
                $scope.filter.page = 1;
                $location.search($scope.filter);
            }
        };

        $scope.subcategories = [];

        $rootScope.changeCategory = function (category_id, type, category) {
            if (type) {
                if (
                    $scope.filter.category_id == category_id &&
                    $location.path() == "/product" &&
                    category
                ) {
                    $scope.subcategories = category.subcategories;
                    $scope.subcategories.map((subcategory) => {
                        if ($scope.filter.list_subcategory_id) {
                            subcategory.checked = JSON.parse(
                                $scope.filter.list_subcategory_id
                            ).includes(subcategory.subcategory_id)
                                ? true
                                : false;
                        } else {
                            subcategory.checked = false;
                        }
                        return subcategory;
                    });
                }
                return (
                    $scope.filter.category_id == category_id &&
                    $location.path() == "/product"
                );
            } else {
                $scope.filter.page = 1;
                $scope.filter.category_id = category_id;
                $scope.filter.list_subcategory_id = undefined;
                $location.search($scope.filter);
            }
        };

        $scope.changeSubCategories = function (subcategory) {
            if (subcategory.checked) {
                let arr = JSON.parse($scope.filter.list_subcategory_id).filter(
                    (subcategory_id) => {
                        return subcategory_id != subcategory.subcategory_id;
                    }
                );
                $scope.filter.list_subcategory_id =
                    arr.length > 0 ? JSON.stringify(arr) : undefined;
            } else {
                let arr = $scope.filter.list_subcategory_id
                    ? JSON.parse($scope.filter.list_subcategory_id)
                    : [];
                $scope.filter.list_subcategory_id = JSON.stringify([
                    ...arr,
                    subcategory.subcategory_id,
                ]);
            }
            $scope.filter.page = 1;
            $location.search($scope.filter);
        };

        $rootScope.changePrice = function () {
            $scope.filter.page = 1;
            $scope.filter.min_price = $scope.filter.min_price
                ? $scope.filter.min_price
                : undefined;
            $scope.filter.max_price = $scope.filter.max_price
                ? $scope.filter.max_price
                : undefined;
            $location.search($scope.filter);
        };
    }
);
