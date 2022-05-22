myApp.constant("API_URL", "");

myApp.filter("jsDate", function () {
    return function (x) {
        return new Date(x);
    };
});

myApp.filter("cvOrderState", function () {
    return function (name) {
        switch (name) {
            case 0:
                return "Đang xử lý";
            case 1:
                return "Đang giao";
            case 2:
                return "Đã giao";
            case 3:
                return "Đã hủy";
            default:
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
    function ($scope, $rootScope, customerService, $window) {
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
    } else {
        var restrictedPage =
            $.inArray($location.path(), ["/orders", "/orderdetails"]) != -1;
        if (restrictedPage) {
            $location.path("/").search({});
        }
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            var restrictedPage =
                $.inArray($location.path(), ["/orders", "/orderdetails"]) != -1;
            if (restrictedPage) {
                event.preventDefault();
                $location.path("/").search({});
            }
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

    $rootScope.validateNumber = function (e, product) {
        if (product.picked.size) {
            const pattern = /^[0-9]$/;
            if (!pattern.test(e.key)) {
                e.preventDefault();
            }
        } else {
            e.preventDefault();
        }
    };

    $rootScope.validateQuantity = function (product) {
        if (product.picked.size) {
            $rootScope
                .getQuantityOfSize(product.picked.size)
                .then(function (res) {
                    product.picked.size.quantity = res.data.quantity;
                    if (
                        product.picked.size &&
                        product.picked.size.quantity < product.picked.quantity
                    ) {
                        product.picked.quantity = product.picked.size.quantity;
                        $rootScope.showSnackbar(
                            `Sản phẩm này chỉ còn tối đa ${product.picked.size.quantity} cái!`
                        );
                    }
                    if (!product.picked.quantity) {
                        product.picked.quantity = 1;
                    }
                });
        }
    };

    $rootScope.getQuantityOfSize = function (size) {
        return $http({
            method: "GET",
            url: API_URL + "/api/product/get-quantity/" + size.size_id,
        });
    };

    $rootScope.snackbarContent = "Hello!";
    var myTimeout;
    $rootScope.showSnackbar = function (content, type) {
        $rootScope.snackbarContent = content;
        let snackbar = $("#snackbar");
        if (type == "error") {
            snackbar.css({ "background-color": "#F44336" });
            snackbar.css({ "background-image": "unset" });
        } else if (type == "success") {
            snackbar.css({
                "background-image":
                    "linear-gradient(to right, #2F80ED, #00AEEF)",
            });
            snackbar.css({ "background-color": "unset" });
        } else if (type == "warning") {
            snackbar.css({
                "background-image":
                    "linear-gradient(45deg, #F2AF12 0%, #FFD200 100%)",
            });
            snackbar.css({ "background-color": "unset" });
        } else {
            snackbar.css({ "background-color": "rgba(24, 34, 45, 1)" });
            snackbar.css({ "background-image": "unset" });
        }
        if (snackbar.hasClass("show")) {
            snackbar.removeClass("show");
            setTimeout(function () {
                clearTimeout(myTimeout);
                snackbar.addClass("show");
                myTimeout = setTimeout(function () {
                    snackbar.removeClass("show");
                }, 5000);
            }, 100);
        } else {
            snackbar.addClass("show");
            myTimeout = setTimeout(function () {
                snackbar.removeClass("show");
            }, 5000);
        }
    };

    $http({
        method: "GET",
        url: API_URL + "/api/category",
    }).then((res) => {
        $rootScope.categories = res.data;
    });

    // Show Cart
    $rootScope.showCartTimeout;
    $rootScope.showCart = function () {
        if ($rootScope.showCartTimeout) {
            $timeout.cancel($rootScope.showCartTimeout);
        }
        $rootScope.isShowCart = true;
        $rootScope.showCartTimeout = $timeout(function () {
            $rootScope.isShowCart = false;
            $rootScope.showCartTimeout = undefined;
        }, 2000);
    };

    $rootScope.recalculateTotalPrice = function () {
        $rootScope.total_price = $rootScope.cart
            .filter((product) => product.chose)
            .reduce(function (total, current) {
                return (
                    total +
                    (current.picked.color.product_price -
                        (current.picked.color.product_price *
                            current.product_discount) /
                            100) *
                        current.picked.quantity
                );
            }, 0);
    };

    $rootScope.mapCart = function () {
        $rootScope.cart.forEach((product) => {
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
    }

    // Get Cart
    $http({
        method: "GET",
        url: API_URL + "/api/cart",
    }).then((res) => {
        $rootScope.cart = res.data;
        $rootScope.mapCart();
        $rootScope.recalculateTotalPrice();
    });

    // Add Cart
    $rootScope.addToCartInProductPage = function (product, size) {
        let product_new = JSON.parse(JSON.stringify(product));
        product_new.cart_id = Math.floor(Date.now() * Math.random());
        product_new.picked.size = size;
        product_new.picked.quantity = 1;
        product_new.chose = false;
        if (product_new.colors.length == 1) {
            product_new.picked.color = product_new.colors[0];
        }
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
                    $rootScope.showSnackbar(
                        `Bạn đã có ${res.data.quantity_in_cart} sản phẩm trong này giỏ hàng. Không thể thêm số lượng đã chọn vào giỏ hàng vì sẽ vượt quá giới hạn mua hàng của bạn.`
                    );
                }
                size.quantity = res.data.quantity_in_stock;
            });
        } else {
            $rootScope.showSnackbar("Sản phẩm đã hết hàng!");
        }
    };

    //  EditCart
    $rootScope.editCart = function (product, product_old) {
        if (!product.picked.quantity) {
            product.picked.quantity = 1;
        }
        $http({
            method: "PUT",
            url: API_URL + "/api/cart/" + product.cart_id,
            data: {
                product_id: product.product_id,
                size_id: product.picked.size.size_id,
                quantity: product.picked.quantity,
            },
        }).then((res) => {
            if (res.data.status == "success") {
                $rootScope.recalculateTotalPrice();
                product.picked.size.quantity = res.data.quantity_in_stock;
            } else {
                if (res.data.quantity_in_stock) {
                    $rootScope.showSnackbar(
                        `Sản phẩm này chỉ còn tối đa ${res.data.quantity_in_stock} cái!`
                    );
                } else {
                    $rootScope.showSnackbar(`Sản phẩm này đã hết hàng!`);
                }

                // Edit on view
                product_old.colors.forEach(function (color) {
                    if (color.color_id == product_old.picked.color.color_id) {
                        product_old.picked.color = color;
                        product_old.picked.color.sizes.forEach(function (size) {
                            if (
                                size.size_id == product_old.picked.size.size_id
                            ) {
                                product_old.picked.size = size;
                                return false;
                            }
                        });
                        return false;
                    }
                });

                product_old.picked.quantity = res.data.quantity_in_cart;
                product_old.picked.size.quantity = res.data.quantity_in_stock;
                let index = $rootScope.cart.findIndex(
                    (p) => p.product_id === product_old.product_id
                );

                $rootScope.cart[index] = product_old;
            }
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

            $rootScope.recalculateTotalPrice();
        });
    };

    //Cart
    $rootScope.changeColorInCart = function (product, product_old) {
        let product_backup = JSON.parse(product_old);
        //Giữ size
        let index;
        if (product.picked.size) {
            index = product_backup.picked.color.sizes.findIndex(
                (size) => size.size_id == product.picked.size.size_id
            );
            product.picked.size = product.picked.color.sizes[index];
        }
        product.picked.quantity = 1;
        $rootScope.editCart(product, product_backup);
    };

    $rootScope.changeSizeInCart = function (product, product_old) {
        let product_backup = JSON.parse(product_old);
        product.picked.quantity = 1;
        $rootScope.editCart(product, product_backup);
    };

    $rootScope.increaseInCart = function (product) {
        if (product.picked.quantity < product.picked.size.quantity) {
            product.picked.quantity++;
            $rootScope.editCart(product);
        } else {
            $rootScope.showSnackbar(
                `Sản phẩm này chỉ còn tối đa ${product.picked.size.quantity} cái!`
            );
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
        $(function () {
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

myApp.directive("slickSlider2", function ($timeout) {
    function link(scope, element, attrs) {
        $(function () {
            $timeout(function () {
                $(".image-slider2").slick({
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    infinite: true,
                    arrows: true,
                    draggable: true,
                    prevArrow: `<button
                                    class="absolute left-[-15px] top-[40%] -translate-y-2/4 bg-[#f3f4f1] text-3xl rounded-full w-10 h-10 justify-center items-center flex z-10 hover:bg-white"
                                >
                                    <i class="bx bx-chevron-left"></i>
                                </button>`,
                    nextArrow: `<button
                                    class="absolute right-[-15px] top-[40%] -translate-y-2/4 bg-[#f3f4f1] text-3xl rounded-full w-10 h-10 justify-center items-center flex z-10 hover:bg-white"
                                >
                                    <i class="bx bx-chevron-right"></i>
                                </button>`,
                    dots: false,
                    // autoplay: false,
                    // autoplaySpeed: 1000,
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
        .when("/orders", {
            templateUrl: "html/orders.html",
            controller: "OrderController",
        })
        .when("/orderdetails", {
            templateUrl: "html/orderdetails.html",
            controller: "OrderController",
        })
        .otherwise({
            redirectTo: "/",
        });
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false,
    });
});
