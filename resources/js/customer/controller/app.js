myApp.constant("API_URL", "");

myApp.filter("jsDate", function () {
    return function (x) {
        return x.replace("/Date(", "").replace(")/", "");
    };
});

myApp.filter("cvOrderState", function () {
    return function (x) {
        if (x == 0) {
            return "Đang xử lý";
        } else if (x == 1) {
            return "Đang giao";
        } else if (x == 2) {
            return "Đã giao";
        } else if (x == 3) {
            return "Đã hủy";
        } else {
            return "Hoàn trả";
        }
    };
});

myApp.factory(
    "customerService",
    function ($http, localStorageService, API_URL) {
        function checkIfLoggedIn() {
            if (localStorageService.get("authTokenCustomer")) return true;
            else return false;
        }
        function login(email, password, onSuccess, onError) {
            $http({
                method: "POST",
                url: API_URL + "/api/login/customer",
                data: {
                    email: email,
                    password: password,
                },
                "Content-Type": "application/json",
            }).then(
                function (response) {
                    localStorageService.set(
                        "authTokenCustomer",
                        response.data.access_token
                    );
                    onSuccess(response);
                },
                function (response) {
                    onError(response);
                }
            );
        }

        function logout() {
            localStorageService.remove("authTokenCustomer");
        }

        function getCurrentToken() {
            return localStorageService.get("authTokenCustomer");
        }

        return {
            checkIfLoggedIn: checkIfLoggedIn,
            login: login,
            logout: logout,
            getCurrentToken: getCurrentToken,
        };
    }
);

myApp.controller(
    "LoginController",
    function ($scope, $rootScope, API_URL, customerService, $window) {
        $rootScope.login = function () {
            customerService.login(
                $scope.email,
                $scope.password,
                function (res) {
                    if (res.data.status_code == 200) {
                        $window.location.reload();
                    }
                },
                function (err) {}
            );
        };
    }
);

myApp.run(function (
    $rootScope,
    $http,
    $routeParams,
    $location,
    $window,
    API_URL,
    customerService,
    $timeout
) {
    $rootScope.title = "Shop Sheyn";

    if (customerService.checkIfLoggedIn()) {
        $http({
            method: "GET",
            url: API_URL + "/api/customer",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            $rootScope.is_login = true;
            $rootScope.customer = res.data;
        });
    }
    $rootScope.logout = function () {
        $http({
            method: "DELETE",
            url: API_URL + "/api/logout",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + customerService.getCurrentToken(),
            },
        }).then((res) => {
            if (res.data.status_code == 200) {
                customerService.logout();
                $window.location.reload();
            }
        });
    };

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

    $rootScope.is_show_modal_login = false;
    $rootScope.showModalLogin = function () {
        $rootScope.is_show_modal_login = !$rootScope.is_show_modal_login;
    };

    $http({
        method: "GET",
        url: API_URL + "/api/category",
    }).then((res) => {
        $rootScope.categories = res.data;
    });

    // Cart
    $http({
        method: "GET",
        url: API_URL + "/api/cart",
    }).then((res) => {
        $rootScope.cart = res.data;
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
        recalculateTotalPrice();
    });

    function recalculateTotalPrice() {
        $rootScope.total_price = $rootScope.cart.reduce(function (
            total,
            current
        ) {
            return (
                total +
                (current.picked.color.product_price -
                    (current.picked.color.product_price *
                        current.product_discount) /
                        100) *
                    current.picked.quantity
            );
        },
        0);
    }

    // Add Cart
    $rootScope.addToCartInProductPage = function (product, size) {
        let product_new = JSON.parse(JSON.stringify(product));
        product_new.cart_id = Math.floor(Date.now() * Math.random());
        product_new.picked.size = size;
        product_new.picked.quantity = 1;
        if (product_new.colors.length == 1) {
            product_new.picked.color = product_new.colors[0];
        }
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
            let index = $rootScope.cart.findIndex(
                (p) => p.picked.size.size_id == product_new.picked.size.size_id
            );
            index != -1
                ? ($rootScope.cart[index].picked.quantity +=
                      product_new.picked.quantity)
                : $rootScope.cart.unshift(product_new);
            $rootScope.showCart();
            recalculateTotalPrice();
        });
    };

    $rootScope.showCartTimeout;
    $rootScope.showCart = function () {
        if ($rootScope.showCartTimeout) {
            $timeout.cancel($rootScope.showCartTimeout);
        }
        $rootScope.isShowCart = true;
        $rootScope.showCartTimeout = $timeout(function () {
            $rootScope.isShowCart = false;
            $rootScope.showCartTimeout = undefined;
        }, 3000);
    };

    $rootScope.addToCartInDetailsPage = function (product) {
        let product_new = JSON.parse(JSON.stringify(product));
        product_new.cart_id = Math.floor(Date.now() * Math.random());
        if (product_new.picked.size) {
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
                let index = $rootScope.cart.findIndex(
                    (p) =>
                        p.picked.size.size_id == product_new.picked.size.size_id
                );
                index != -1
                    ? ($rootScope.cart[index].picked.quantity +=
                          product_new.picked.quantity)
                    : $rootScope.cart.unshift(product_new);

                $rootScope.showCart();
                recalculateTotalPrice();
            });
        }
    };

    //  EditCart
    $rootScope.editCart = function (product) {
        $http({
            method: "PUT",
            url: API_URL + "/api/cart/" + product.cart_id,
            data: {
                product_id: product.product_id,
                size_id: product.picked.size.size_id,
                quantity: product.picked.quantity,
            },
        }).then((res) => {
            recalculateTotalPrice();
        });
    };
    // Remove product in cart
    $rootScope.removeProductFromCart = function (cart_id) {
        $http({
            method: "DELETE",
            url: API_URL + "/api/cart/" + cart_id,
        }).then((res) => {
            $rootScope.cart = $rootScope.cart.filter((product) => {
                return product.cart_id != cart_id;
            });

            recalculateTotalPrice();
        });
    };

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
            $rootScope.editCart(product);
        }
    };

    $rootScope.decreaseInCart = function (product) {
        if (product.picked.quantity > 1) {
            product.picked.quantity--;
            $rootScope.editCart(product);
        }
    };
});

myApp.directive("slickSlider", function ($timeout) {
    function link(scope, element, attrs) {
        $(document).ready(function () {
            $timeout(function () {
                $(".image-slider").slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: false,
                    arrows: false,
                    draggable: true,
                    prevArrow: `<button
                                    class="absolute left-[15px] top-2/4 -translate-y-2/4 bg-[#f3f4f1] text-3xl rounded-full w-10 h-10 justify-center items-center hidden group-hover:flex z-10 hover:bg-white"
                                >
                                    <i class="bx bx-chevron-left"></i>
                                </button>`,
                    nextArrow: `<button
                                    class="absolute right-[15px] top-2/4 -translate-y-2/4 bg-[#f3f4f1] text-3xl rounded-full w-10 h-10 justify-center items-center hidden group-hover:flex z-10 hover:bg-white"
                                >
                                    <i class="bx bx-chevron-right"></i>
                                </button>`,
                    dots: false,
                    autoplay: true,
                    autoplaySpeed: 1000,
                });
            }, 1000);
        });
    }

    return {
        link: link,
    };
});

myApp.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "html/home.html",
        })
        .when("/product", {
            templateUrl: "html/product.html",
            controller: "ProductController",
        })
        .when("/cart", {
            templateUrl: "html/cart.html",
            controller: "OrderController",
        })
        .when("/details", {
            templateUrl: "html/details.html",
            controller: "ProductDetailsController",
        })
        .when("/checkout", {
            templateUrl: "html/checkout.html",
        })
        .when("/orders", {
            templateUrl: "html/orders.html",
            controller: "OrderController",
        })
        .when("/orderdetails", {
            templateUrl: "html/orderdetails.html",
        })
        .otherwise({
            redirectTo: "/",
        });
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false,
    });
});
