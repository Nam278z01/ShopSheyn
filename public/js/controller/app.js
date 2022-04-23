var app = angular.module("myApp", ['angularUtils.directives.dirPagination', 'ngRoute', 'ngSanitize'])

app.constant('API_URL', '');

app.filter("jsDate", function () {
    return function (x) {
        return x.replace('/Date(', '').replace(')/', '');
    };
});

app.run(function ($rootScope, $http, $routeParams, $location, API_URL) {
    $http({
        method: 'GET',
        url: API_URL + "/api/category",
    }).then((res) => {
        $rootScope.categories = res.data.data
    })

    $rootScope.title = 'shop'

    $rootScope.search = function () {
        $rootScope.text_search = $rootScope.text_search ? $rootScope.text_search : undefined
        if ($location.path() == '/product') {
            $location.path('/product').search('text_search', $rootScope.text_search);
        } else {
            $location.path('/product').search({text_search: $rootScope.text_search});
        }
    }

    $rootScope.activeNavigation = function (path) {
        return $location.path() == path
    }
})

app.config(function ($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "html/home.html"
        })
        .when("/product", {
            templateUrl: "html/product.html",
            controller: "ProductController"
        })
        .when("/cart", {
            templateUrl: "html/cart.html"
        })
        .when("/details", {
            templateUrl: "html/details.html",
            controller: "ProductDetailsController"
        })
});
