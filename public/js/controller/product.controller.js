app.controller('ProductController', function ($scope, $rootScope, $http, API_URL) {
    $http({
        method: 'GET',
        url: API_URL + "/api/product",
        params: {
            page: 1,
            page_size: 10,
            category_id: null,
            list_subcategory_id: null,
            text_search: null,
            min_price1: null,
            max_price1: null,
            sort: 1
        }
    }).then((res) => {
        $scope.products = res.data.data
        $scope.total_row = res.data.total_row
        console.log($scope.products)
    })
    $scope.changeColor = function (product, color) {
        product.picked = {}
        product.picked.color = color
        console.log(color)
    }
})
