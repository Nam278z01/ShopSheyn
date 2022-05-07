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
        $scope.uploadFiles = function (files, cl, index) {
            let quantity =
                files.length +
                cl.files.filter((file) => file != undefined).length;
            cl.product_image1 && quantity++;
            cl.product_image2 && quantity++;
            cl.product_image3 && quantity++;
            cl.product_image4 && quantity++;
            cl.product_image5 && quantity++;
            if (quantity <= 5) {
                let [one_file, ...several_files] = files;
                cl.files[index] = one_file;
                cl.files.forEach(function (file, index) {
                    if (!file && !cl[`product_image${index + 1}`]) {
                        cl.files[index] = several_files.shift();
                    }
                });
            } else {
                $rootScope.showSimpleToast("Tối đa 5 ảnh một màu!", "warning");
            }
        };

        $scope.removeFile = function (cl, index) {
            if (cl.files) {
                cl.files[index] = undefined;
            }
            if ($scope.form_name != "THÊM SẢN PHẨM") {
                $scope.product.files_for_delete.push(
                    cl[`product_image${index + 1}`]
                );
                cl[`product_image${index + 1}`] = null;
            }
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
                        files: [...Array(5)],
                        files_for_delete: [],
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
        $scope.addColor = function () {
            $scope.product.colors.push({
                color_name: "",
                sizes: JSON.parse(JSON.stringify([...$scope.product.sizes])),
                files: [...Array(5)],
                files_for_delete: [],
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

        $scope.showModalEditAndCreate = function (form_name, product) {
            $scope.form_name = form_name;
            if (form_name == "THÊM SẢN PHẨM") {
                $scope.category_picked = null;
                initialProduct();
            } else {
                $scope.product = JSON.parse(JSON.stringify(product));
                $scope.category_picked = $scope.categories.find(
                    (c) =>
                        c.category_id == $scope.product.subcategory.category_id
                );
                $scope.category_picked.subcategory =
                    $scope.category_picked.subcategories.find(
                        (sc) =>
                            sc.subcategory_id ==
                            $scope.product.subcategory.subcategory_id
                    );
                $scope.product = JSON.parse(JSON.stringify(product));
                $scope.product.sizes = JSON.parse(
                    JSON.stringify($scope.product.colors[0].sizes)
                );
                $scope.product.sizes.forEach((size) => {
                    size.quantity = 0;
                });
                $scope.product.colors.forEach((color) => {
                    color.files = [...Array(5)];
                    color.files_for_delete = [];
                });
            }
        };
        $scope.addOrEditProduct = function () {
            if (!$scope.progress) {
                let files = $scope.product.colors
                    .reduce(function (colors, colorCurrent) {
                        return [...colors, ...colorCurrent.files];
                    }, [])
                    .filter(function (file) {
                        return file != undefined;
                    });
                if (files && files.length || $scope.form_name != "THÊM SẢN PHẨM") {
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
                                        if (file != undefined) {
                                            color[`product_image${index + 1}`] =
                                                $scope.result.shift();
                                        }
                                    });
                                });
                                //Remove sizes, files
                                $scope.product.subcategory_id =
                                    $scope.category_picked.subcategory.subcategory_id;
                                let { sizes, ...product_new } = $scope.product;
                                product_new = JSON.parse(
                                    JSON.stringify(product_new)
                                );
                                $scope.product.colors.forEach(function (
                                    { files, files_for_delete, ...color },
                                    index
                                ) {
                                    product_new.colors[index] = color;
                                });
                                // Add Product
                                if ($scope.form_name == "THÊM SẢN PHẨM") {
                                    $http({
                                        method: "POST",
                                        url: API_URL + "/api/product",
                                        data: product_new,
                                        "Content-Type": "application/json",
                                    }).then((res) => {
                                        $scope.progress = 100;
                                        $scope.products.unshift(res.data.data);
                                        $scope.tableParams.reload();
                                        $rootScope.showSimpleToast(
                                            "Thêm sản phẩm thành công!",
                                            "success"
                                        );
                                        initialProduct();
                                        $timeout(function () {
                                            $scope.progress = 0;
                                        }, 500);
                                    });
                                } else {
                                    // Edit Product
                                    let paths = [];
                                    $scope.product.colors.forEach(function (
                                        color
                                    ) {
                                        paths = [
                                            ...paths,
                                            ...color.files_for_delete,
                                        ];
                                    });
                                    $http({
                                        method: "POST",
                                        url: API_URL + "/api/upload/delete",
                                        data: { paths: paths },
                                        "Content-Type": "application/json",
                                    }).then((res) => {
                                        $http({
                                            method: "PUT",
                                            url: API_URL + "/api/product/" + product_new.product_id,
                                            data: product_new,
                                            "Content-Type": "application/json",
                                        }).then((res) => {
                                            $scope.progress = 100;
                                            let index = $scope.products.findIndex(
                                                (p) =>
                                                    p.product_id == product_new.product_id
                                            );
                                            $scope.products[index] = res.data.data;
                                            $scope.tableParams.reload();
                                            $rootScope.showSimpleToast(
                                                "Sửa thông tin sản phẩm thành công!",
                                                "success"
                                            );
                                            $timeout(function () {
                                                $scope.progress = 0;
                                            }, 500);
                                        });
                                    });
                                }
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
            $scope.product_for_delete = product;
        };
        $scope.deleteProduct = function () {
            let paths = [];
            $scope.product_for_delete.colors.forEach(function (color) {
                color.product_image1 && paths.push(color.product_image1);
                color.product_image2 && paths.push(color.product_image2);
                color.product_image3 && paths.push(color.product_image3);
                color.product_image4 && paths.push(color.product_image4);
                color.product_image5 && paths.push(color.product_image5);
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
                        $scope.product_for_delete.product_id,
                }).then((res) => {
                    $rootScope.showSimpleToast(
                        "Xóa sản phẩm thành công!",
                        "success"
                    );
                    let index = $scope.products.findIndex(
                        (p) =>
                            p.product_id == $scope.product_for_delete.product_id
                    );
                    $scope.products.splice(index, 1);
                    $scope.tableParams.reload();
                });
            });
        };
    }
);
