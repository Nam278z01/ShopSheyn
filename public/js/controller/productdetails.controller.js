app.controller('ProductDetailsController', function ($scope, $rootScope, $http, $routeParams, API_URL) {
    $http({
        method: 'GET',
        url: API_URL + "/api/product/" + $routeParams.product_id,
    }).then((res) => {
        $scope.product = res.data.data
        $scope.product.picked = {}
        $scope.product.picked.quantity = 0
        $scope.changeColor($scope.product, $scope.product.colors[0])
    })

    $scope.changeColor = function (product, color) {
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
        if ($scope.product.picked.quantity > 0) {
            $scope.product.picked.quantity--
        }
    }
})
