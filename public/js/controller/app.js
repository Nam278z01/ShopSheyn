var app = angular.module("myApp", ['angularUtils.directives.dirPagination', 'ngRoute', 'ngSanitize'])

app.constant('API_URL', '');

app.filter("jsDate", function () {
    return function (x) {
        return x.replace('/Date(', '').replace(')/', '');
    };
});

app.run(function ($rootScope, $http, $routeParams, $location, $window, API_URL) {
    $http({
        method: 'GET',
        url: API_URL + "/api/category",
    }).then((res) => {
        $rootScope.categories = res.data.data
    })

    $http({
        method: 'GET',
        url: API_URL + "/fakeapi/cart.json",
    }).then((res) => {
        $rootScope.cart = res.data.data
        $rootScope.cart.map((product) => {
            product.picked = {}
            product.picked.quantity = product.quantity
            product.colors.forEach((color) => {
                color.sizes.forEach((size) => {
                    if (product.size_id == size.size_id) {
                        product.picked.color = color
                        product.picked.size = size
                    }
                })
            })
        })

    })

    $rootScope.title = 'Shop Sheyn'

    $rootScope.search = function () {
        $rootScope.text_search = $rootScope.text_search ? $rootScope.text_search : undefined
        if ($location.path() == '/product') {
            $location.path('/product').search('text_search', $rootScope.text_search);
        } else {
            $location.path('/product').search({ text_search: $rootScope.text_search });
        }
    }

    $rootScope.activeNavigation = function (path) {
        return $location.path() == path
    }

    $rootScope.$on('$routeChangeStart', function (evt, absNewUrl, absOldUrl) {
        $window.scrollTo(0, 0);
    })

    //Cart
    $rootScope.changeColorInCart = function (product, color, old_color) {
        //Giữ size
        let index
        if (product.picked.size) {
            index = JSON.parse(old_color).sizes.findIndex(size => size.size_id == product.picked.size.size_id)
            product.picked.size = color.sizes[index]
        }
        product.picked.color = color
    }

    $rootScope.increaseInCart = function (product_picked) {
        if (product_picked.quantity < product_picked.size.quantity) {
            product_picked.quantity++
        }
    }

    $rootScope.decreaseInCart = function (product_picked) {
        if (product_picked.quantity > 1) {
            product_picked.quantity--
        }
    }

})

app.config(function ($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "html/home.html",
            controller: "HomeController"
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
