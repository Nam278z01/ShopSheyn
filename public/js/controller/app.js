var app = angular.module("myApp", [
    "angularUtils.directives.dirPagination",
    "ngRoute",
    "ngSanitize",
]);

app.constant("API_URL", "");

app.filter("jsDate", function () {
    return function (x) {
        return x.replace("/Date(", "").replace(")/", "");
    };
});

app.run(function (
    $rootScope,
    $http,
    $routeParams,
    $location,
    $window,
    API_URL
) {
    $http({
        method: "GET",
        url: API_URL + "/api/category",
    }).then((res) => {
        $rootScope.categories = res.data.data;
    });

    // Cart
    $http({
        method: "GET",
        url: API_URL + "/api/cart",
    }).then((res) => {
        $rootScope.cart = res.data.data;
        $rootScope.cart.map((product) => {
            product.picked = {};
            product.picked.quantity = product.quantity;
            product.colors.forEach((color) => {
                color.sizes.forEach((size) => {
                    if (product.size_id == size.size_id) {
                        product.picked.color = color;
                        product.picked.size = size;
                    }
                });
            });
        });
        $rootScope.total_price = $rootScope.cart.reduce(function (total, current) {
            return total + current.picked.color.product_price * current.picked.quantity
        }, 0)
    });

    // Add Cart
    $rootScope.addToCartInProductPage = function (product, size) {
        let product_new = JSON.parse(JSON.stringify(product))
        product_new.cart_id = Math.floor(Date.now() * Math.random());
        product_new.picked.size = size
        product_new.picked.quantity = 1
        if (product_new.colors.length == 1) {
            product_new.picked.color = product_new.colors[0]
        }
        $http({
            method: "POST",
            url: API_URL + "/api/cart",
            data: {
                cart_id: product_new.cart_id,
                product_id: product_new.product_id,
                size_id: product_new.picked.size.size_id,
                quantity: product_new.picked.quantity,
            }
        }).then((res) => {
            let index = $rootScope.cart.findIndex(p => p.picked.size.size_id == product_new.picked.size.size_id)
            index != -1 ? $rootScope.cart[index].picked.quantity += product_new.picked.quantity : $rootScope.cart.unshift(product_new)

            $rootScope.total_price = $rootScope.cart.reduce(function (total, current) {
                return total + current.picked.color.product_price * current.picked.quantity
            }, 0)
        });
    }

    //  EditCart
    $rootScope.editCart = function (product) {
        $http({
            method: "PUT",
            url: API_URL + "/api/cart/" + product.cart_id,
            data: {
                product_id: product.product_id,
                size_id: product.picked.size.size_id,
                quantity: product.picked.quantity,
            }
        }).then((res) => {
            $rootScope.total_price = $rootScope.cart.reduce(function (total, current) {
                return total + current.picked.color.product_price * current.picked.quantity
            }, 0)
        });
    }
    // Remove product in cart
    $rootScope.removeProductFromCart = function (cart_id) {
        $http({
            method: "DELETE",
            url: API_URL + "/api/cart/" + cart_id,
        }).then((res) => {
            $rootScope.cart = $rootScope.cart.filter(product => {
                return product.cart_id != cart_id;
            })

            $rootScope.total_price = $rootScope.cart.reduce(function (total, current) {
                return total + current.picked.color.product_price * current.picked.quantity
            }, 0)
        });
    }


    $rootScope.title = "Shop Sheyn";

    $rootScope.search = function () {
        $rootScope.text_search = $rootScope.text_search
            ? $rootScope.text_search
            : undefined;
        if ($location.path() == "/product") {
            $location
                .path("/product")
                .search("text_search", $rootScope.text_search);
        } else {
            $location
                .path("/product")
                .search({ text_search: $rootScope.text_search });
        }
    };

    $rootScope.activeNavigation = function (path) {
        return $location.path() == path;
    };

    $rootScope.$on("$routeChangeStart", function (evt, absNewUrl, absOldUrl) {
        $window.scrollTo(0, 0);
    });

    //Cart
    $rootScope.changeColorInCart = function (product, color, old_color) {
        //Giữ size
        let index;
        if (product.picked.size) {
            index = JSON.parse(old_color).sizes.findIndex(
                (size) => size.size_id == product.picked.size.size_id
            );
            product.picked.size = color.sizes[index];
        }
        product.picked.color = color;
    };

    $rootScope.increaseInCart = function (product) {
        if (product.picked.quantity < product.picked.size.quantity) {
            product.picked.quantity++;
            $rootScope.editCart(product)
        }
    };

    $rootScope.decreaseInCart = function (product) {
        if (product.picked.quantity > 1) {
            product.picked.quantity--;
            $rootScope.editCart(product)
        }
    };
    console.log(document.cookie)
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "html/home.html",
            controller: "HomeController",
        })
        .when("/product", {
            templateUrl: "html/product.html",
            controller: "ProductController",
        })
        .when("/cart", {
            templateUrl: "html/cart.html",
        })
        .when("/details", {
            templateUrl: "html/details.html",
            controller: "ProductDetailsController",
        });
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false,
    });
});
