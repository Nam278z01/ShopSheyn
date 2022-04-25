app.controller('ProductDetailsController', function ($scope, $rootScope, $http, $routeParams, API_URL) {
    $scope.isLoading = true;
    $http({
        method: 'GET',
        url: API_URL + "/api/product/" + $routeParams.product_id,
    }).then((res) => {
        $scope.product = res.data.data
        $rootScope.title = $scope.product.product_name
        $scope.product.picked = {}
        $scope.product.picked.quantity = 1
        $scope.changeColor($scope.product, $scope.product.colors[0])

        $scope.isLoading = false;
    })

    $scope.changeColor = function (product, color) {
        //Giữ size
        let index
        if (product.picked.size) {
            index = product.picked.color.sizes.findIndex(size => size.size_id == product.picked.size.size_id)
            product.picked.size = color.sizes[index]
        }
        product.picked.color = color

    }

    $scope.changeSize = function (product, size) {
        product.picked.size = size
    }

    $scope.increase = function () {
        if ($scope.product.picked.quantity < $scope.product.picked.size.quantity) {
            $scope.product.picked.quantity++
        }
    }

    $scope.decrease = function () {
        if ($scope.product.picked.quantity > 1) {
            $scope.product.picked.quantity--
        }
    }

})
