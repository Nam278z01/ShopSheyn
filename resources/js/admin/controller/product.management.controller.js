myApp.controller(
    "ProductManagementController",
    function (
        $scope,
        $rootScope,
        $http,
        API_URL,
        $mdDialog,
        NgTableParams,
        Upload,
        $timeout
    ) {
        $rootScope.currentIndex = 1;
        $rootScope.currentSubIndex = 1;

        $http({
            method: "GET",
            url: API_URL + "/api/product",
        }).then((res) => {
            $scope.products = res.data.data;

            $scope.tableParams = new NgTableParams(
                {
                    page: 1, // show first page
                    count: 10, // count per page
                },
                {
                    filterDelay: 0,
                    dataset: $scope.products,
                }
            );
        });

        $http({
            method: "GET",
            url: API_URL + "/api/category",
        }).then((res) => {
            $scope.categories = res.data.data;
        });

        // File upload
        $scope.uploadFiles = function (files, cl) {
            cl.files = [...cl.files, ...files];
        };

        $scope.removeFile = function (cl, index) {
            cl.files.splice(index, 1);
        };

        // Editor options.
        $scope.options = {
            language: "vi",
            allowedContent: true,
            entities: false,
        };

        // Called when the editor is completely ready.
        $scope.onReady = function () {
            // ...
        };

        function initialProduct() {
            $scope.product = {
                product_discount: 0,
                colors: [
                    {
                        color_name: "",
                        sizes: [
                            {
                                size_name: "",
                                quantity: 0,
                            },
                        ],
                        files: [],
                    },
                ],
                sizes: [
                    {
                        size_name: "",
                        quantity: 0,
                    },
                ],
            };
        }
        initialProduct();

        $scope.addColor = function () {
            $scope.product.colors.push({
                color_name: "",
                sizes: JSON.parse(JSON.stringify([...$scope.product.sizes])),
                files: [],
            });
        };
        $scope.removeColor = function (index) {
            if ($scope.product.colors.length > 1) {
                $scope.product.colors.splice(index, 1);
            }
        };
        $scope.addSize = function () {
            $scope.product.sizes.push({
                size_name: "",
                quantity: 0,
            });
            $scope.product.colors.forEach(function (color) {
                color.sizes.push({
                    size_name: "",
                    quantity: 0,
                });
            });
        };
        $scope.changeSizeName = function ($index, size) {
            $scope.product.colors.forEach(function (color) {
                color.sizes[$index].size_name = size.size_name;
            });
        };
        $scope.removeSize = function (index) {
            if ($scope.product.sizes.length > 1) {
                $scope.product.sizes.splice(index, 1);
            }
            $scope.product.colors.forEach(function (color) {
                color.sizes.splice(index, 1);
            });
        };
        $scope.addProduct = function () {
            if (!$scope.progress) {
                let files = $scope.product.colors.reduce(function (
                    colors,
                    colorCurrent
                ) {
                    return [...colors, ...colorCurrent.files];
                },
                []);
                if (files && files.length) {
                    Upload.upload({
                        url: API_URL + "/api/upload",
                        data: {
                            files: files,
                        },
                    }).then(
                        function (response) {
                            $timeout(function () {
                                $scope.result = response.data;
                                //Enter src img
                                $scope.product.colors.forEach(function (color) {
                                    color.files.forEach(function (file, index) {
                                        color[`product_image${index + 1}`] =
                                            $scope.result.shift();
                                    });
                                });
                                //Remove sizes, files
                                $scope.product.subcategory_id =
                                    $scope.category_piked.subcategory.subcategory_id;
                                let { sizes, ...product_new } = $scope.product;
                                product_new = JSON.parse(
                                    JSON.stringify(product_new)
                                );
                                $scope.product.colors.forEach(function (
                                    { files, ...color },
                                    index
                                ) {
                                    product_new.colors[index] = color;
                                });
                                //Add Product
                                $http({
                                    method: "POST",
                                    url: API_URL + "/api/product",
                                    data: product_new,
                                    "Content-Type": "application/json",
                                }).then((res) => {
                                    $scope.progress = 100;
                                    $scope.products.unshift(res.data.data);
                                    $scope.tableParams.reload();
                                    $timeout(function () {
                                        $rootScope.showSimpleToast(
                                            "Thêm sản phẩm thành công!",
                                            "success"
                                        );
                                        $scope.progress = 0;
                                        initialProduct();
                                    }, 1000);
                                });
                            });
                        },
                        function (response) {
                            if (response.status > 0) {
                                $scope.errorMsg =
                                    response.status + ": " + response.data;
                            }
                        },
                        function (evt) {
                            $scope.progress = Math.min(
                                100,
                                (parseInt((100.0 * evt.loaded) / evt.total) *
                                    90) /
                                    100
                            );
                        }
                    );
                }
            } else {
                $rootScope.showSimpleToast("Xin chờ chút!", "warning");
            }
        };
        $scope.showModalDelete = function (product) {
            $scope.productForDetele = product;
        };
        $scope.deleteProduct = function () {
            let paths = [];
            $scope.productForDetele.colors.forEach(function (color) {
                if (color.product_image1) {
                    paths.push(color.product_image1);
                }
                if (color.product_image2) {
                    paths.push(color.product_image2);
                }
                if (color.product_image3) {
                    paths.push(color.product_image3);
                }
                if (color.product_image4) {
                    paths.push(color.product_image4);
                }
                if (color.product_image5) {
                    paths.push(color.product_image5);
                }
            });
            $http({
                method: "POST",
                url: API_URL + "/api/upload/delete",
                data: { paths: paths },
                "Content-Type": "application/json",
            }).then((res) => {
                $http({
                    method: "DELETE",
                    url:
                        API_URL +
                        "/api/product/" +
                        $scope.productForDetele.product_id,
                }).then((res) => {
                    $rootScope.showSimpleToast(
                        "Xóa sản phẩm thành công!",
                        "success"
                    );
                    $scope.products = $scope.products.filter(function (p) {
                        return (
                            p.product_id != $scope.productForDetele.product_id
                        );
                    });
                    let index = $scope.products.findIndex(
                        (p) =>
                            p.product_id == $scope.productForDetele.product_id
                    );
                    $scope.products.splice(index, 1);
                    $scope.tableParams.reload();
                });
            });
        };
    }
);
