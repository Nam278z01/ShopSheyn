myApp.controller(
    "ProductDetailsController",
    function ($scope, $rootScope, $http, $routeParams, API_URL) {
        $scope.isLoading = true;
        $scope.isLoadingSub = true;
        $scope.show_warning = {
            size: false,
        };

        $http({
            method: "GET",
            url: API_URL + "/api/product/get-detail/" + $routeParams.product_id,
        })
            .then((res) => {
                $scope.product = res.data;
                $rootScope.title = $scope.product.product_name;
                $scope.product.picked = {};
                $scope.product.picked.quantity = 1;
                $scope.changeColor($scope.product, $scope.product.colors[0]);
                console.log($scope.product)
                $scope.isLoading = false;

                return $http({
                    method: "GET",
                    url:
                        API_URL +
                        "/api/product/get-by-subcategory/" +
                        $scope.product.subcategory_id + "/" + $scope.product.product_id,
                });
            })
            .then((res) => {
                $scope.products = res.data;

                //Khởi tạo màu
                if ($scope.products) {
                    $scope.products.map((product) => {
                        product.picked = {};
                        product.picked.color = product.colors[0];
                        return product;
                    });
                }

                $scope.isLoadingSub = false;
            });

        $scope.addToCartInDetailsPage = function (product) {
            let product_new = JSON.parse(JSON.stringify(product));
            product_new.cart_id = Math.floor(Date.now() * Math.random());
            if (product_new.picked.size) {
                if (product_new.picked.size.quantity != 0) {
                    $http({
                        method: "POST",
                        url: API_URL + "/api/cart",
                        data: {
                            cart_id: product_new.cart_id,
                            product_id: product_new.product_id,
                            size_id: product_new.picked.size.size_id,
                            quantity: product_new.picked.quantity,
                        },
                    }).then((res) => {
                        if (res.data.status == "success") {
                            let index = $rootScope.cart.findIndex(
                                (p) =>
                                    p.picked.size.size_id ==
                                    product_new.picked.size.size_id
                            );
                            index != -1
                                ? ($rootScope.cart[index].picked.quantity +=
                                      product_new.picked.quantity)
                                : $rootScope.cart.unshift(product_new);

                            $rootScope.showCart();
                            $rootScope.recalculateTotalPrice();
                        } else {
                            $rootScope.showSnackbar(`Bạn đã có ${res.data.quantity_in_cart} sản phẩm trong này giỏ hàng. Không thể thêm số lượng đã chọn vào giỏ hàng vì sẽ vượt quá giới hạn mua hàng của bạn.`);
                        }
                        product.picked.size.quantity = res.data.quantity_in_stock
                    });
                }
                else {
                    $rootScope.showSnackbar("Sản phẩm đã hết hàng!");
                }
            } else {
                $scope.show_warning.size = true;
            }
        };

        $scope.changeColor = function (product, color) {
            //Giữ size
            let index;
            if (product.picked.size) {
                index = product.picked.color.sizes.findIndex(
                    (size) => size.size_id == product.picked.size.size_id
                );
                $scope.changeSize(product, color.sizes[index]);
            }
            product.picked.color = color;
        };

        $scope.changeSize = function (product, size) {
            product.picked.quantity = 1;
            product.picked.size = size;
            $rootScope.validateQuantity($scope.product);
        };

        $scope.increase = function () {
            if (!$scope.product.picked.size) {
                $scope.show_warning.size = true;
                return false;
            }
            if (
                $scope.product.picked.quantity <
                $scope.product.picked.size.quantity
            ) {
                $scope.product.picked.quantity++;
                $rootScope.validateQuantity($scope.product);
            }
        };

        $scope.decrease = function () {
            if (!$scope.product.picked.size) {
                $scope.show_warning.size = true;
                return false;
            }
            if ($scope.product.picked.quantity > 1) {
                $scope.product.picked.quantity--;
                $rootScope.validateQuantity($scope.product);
            }
        };
    }
);
