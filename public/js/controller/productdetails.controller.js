app.controller('ProductDetailsController', function ($scope, $rootScope, $http) {
    $http({
        method: 'GET',
        url: "../api/productdetails.json"
    }).then((res) => {
        $scope.product = res.data
        $scope.product.picked = {}
        $scope.product.picked.quantity = 0
        $scope.changeColor($scope.product, $scope.product.colors[0])
        console.log($scope.product)
    })

    $scope.changeColor = function (product, color) {
        product.picked.color = color
        console.log(color)
    }

    $scope.changeSize = function (product, size) {
        product.picked.size = size
        console.log(size)
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