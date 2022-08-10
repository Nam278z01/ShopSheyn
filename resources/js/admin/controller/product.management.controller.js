myApp.controller(
    "ProductManagementController",
    function (
        $scope,
        $rootScope,
        $http,
        API_URL,
        NgTableParams,
        Upload,
        $timeout,
        adminService
    ) {
        $rootScope.currentIndex = 1;
        $rootScope.currentSubIndex = 1;

        function findProduct(product) {
            let index = $scope.products.findIndex(
                (p) => p.product_id == product.product_id
            );
            return index;
        }

        $http({
            method: "GET",
            url: API_URL + "/api/admin/product",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + adminService.getCurrentToken(),
            },
        }).then((res) => {
            $scope.products = res.data;

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
            url: API_URL + "/api/category/get-all",
        }).then((res) => {
            $scope.categories = res.data;
        });

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
                cl.files_for_delete.push(cl[`product_image${index + 1}`]);
                cl[`product_image${index + 1}`] = null;
            }
        };

        let files_for_delete = [];
        $scope.removeColor = function (index) {
            if ($scope.product.colors.length > 1) {
                if ($scope.form_name != "THÊM SẢN PHẨM") {
                    let colors_of_product = $scope.product.colors[index];
                    colors_of_product.product_image1 &&
                        files_for_delete.push(colors_of_product.product_image1);
                    colors_of_product.product_image2 &&
                        files_for_delete.push(colors_of_product.product_image2);
                    colors_of_product.product_image3 &&
                        files_for_delete.push(colors_of_product.product_image3);
                    colors_of_product.product_image4 &&
                        files_for_delete.push(colors_of_product.product_image4);
                    colors_of_product.product_image5 &&
                        files_for_delete.push(colors_of_product.product_image5);
                }
                $scope.product.colors.splice(index, 1);
            }
        };
        $scope.addColor = function () {
            $scope.product.colors.push({
                color_name: "",
                sizes: JSON.parse(JSON.stringify([...$scope.product.sizes])),
                files: [...Array(5)],
                files_for_delete: [],
            });
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
        $scope.changeSizeName = function (index, size) {
            $scope.product.colors.forEach(function (color) {
                color.sizes[index].size_name = size.size_name;
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

        function initializeForUpdate(product) {
            let index = findProduct(product);
            $scope.products[index] = product;
            $scope.tableParams.reload();

            $scope.product = JSON.parse(JSON.stringify($scope.products[index]));

            // Select category & subcategory
            $scope.category_picked = $scope.categories.find(
                (c) => c.category_id == $scope.product.subcategory.category_id
            );
            $scope.category_picked.subcategory =
                $scope.category_picked.subcategories.find(
                    (sc) =>
                        sc.subcategory_id ==
                        $scope.product.subcategory.subcategory_id
                );

            // Size
            $scope.product.sizes = JSON.parse(
                JSON.stringify($scope.product.colors[0].sizes)
            );
            $scope.product.sizes.forEach((size) => {
                size.quantity = 0;
            });

            // Color
            $scope.product.colors.forEach((color) => {
                color.files = [...Array(5)];
                color.files_for_delete = [];
            });

            files_for_delete = [];
        }

        $scope.showModalEditAndCreate = function (form_name, product) {
            $scope.progress = 0;
            $scope.form_name = form_name;
            if (form_name == "THÊM SẢN PHẨM") {
                $scope.category_picked = null;
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
            } else {
                $http({
                    method: "GET",
                    url:
                        API_URL +
                        "/api/product/get-detail/" +
                        product.product_id,
                }).then((res) => {
                    initializeForUpdate(res.data);
                });
            }
        };

        $scope.addOrEditProduct = function () {
            if (!$scope.progress) {
                // Get file to upload
                let files = $scope.product.colors
                    .reduce(function (files, colorCurrent) {
                        return [...files, ...colorCurrent.files];
                    }, [])
                    .filter(function (file) {
                        return file != undefined;
                    });

                if (
                    (files && files.length) ||
                    $scope.form_name != "THÊM SẢN PHẨM"
                ) {
                    Upload.upload({
                        url: API_URL + "/api/admin/file",
                        data: {
                            files: files,
                        },
                        headers: {
                            "Content-Type": "application/json",
                            Authorization:
                                "Bearer " + adminService.getCurrentToken(),
                        },
                    }).then(
                        function (response) {
                            $timeout(function () {
                                let path_of_files = response.data;
                                //Enter src img
                                $scope.product.colors.forEach(function (color) {
                                    color.files.forEach(function (file, index) {
                                        if (file != undefined) {
                                            color[`product_image${index + 1}`] =
                                                path_of_files.shift();
                                        }
                                    });
                                });

                                //Remove sizes, files, files_for_delete
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
                                        url: API_URL + "/api/admin/product",
                                        data: product_new,
                                        "Content-Type": "application/json",
                                        headers: {
                                            "Content-Type": "application/json",
                                            Authorization:
                                                "Bearer " +
                                                adminService.getCurrentToken(),
                                        },
                                    }).then((res) => {
                                        $scope.progress = 100;
                                        $scope.products.unshift(res.data);
                                        $scope.tableParams.reload();

                                        $scope.showModalEditAndCreate(
                                            "THÊM SẢN PHẨM"
                                        );
                                        $rootScope.showSimpleToast(
                                            "Thêm sản phẩm thành công!",
                                            "success"
                                        );
                                        $timeout(function () {
                                            $scope.progress = 0;
                                        }, 500);
                                    });
                                } else {
                                    // Edit Product
                                    let paths_for_delete =
                                        $scope.product.colors.reduce(function (
                                            paths_for_delete,
                                            colorCurrent
                                        ) {
                                            return [
                                                ...paths_for_delete,
                                                ...colorCurrent.files_for_delete,
                                            ];
                                        },
                                        []);

                                    $http({
                                        method: "DELETE",
                                        url: API_URL + "/api/admin/file",
                                        data: {
                                            paths: [
                                                ...paths_for_delete,
                                                ...files_for_delete,
                                            ],
                                        },
                                        "Content-Type": "application/json",
                                        headers: {
                                            "Content-Type": "application/json",
                                            Authorization:
                                                "Bearer " +
                                                adminService.getCurrentToken(),
                                        },
                                    })
                                        .then((res) => {
                                            return $http({
                                                method: "PUT",
                                                url:
                                                    API_URL +
                                                    "/api/admin/product/" +
                                                    product_new.product_id,
                                                data: product_new,
                                                "Content-Type":
                                                    "application/json",
                                                headers: {
                                                    "Content-Type":
                                                        "application/json",
                                                    Authorization:
                                                        "Bearer " +
                                                        adminService.getCurrentToken(),
                                                },
                                            });
                                        })
                                        .then((res) => {
                                            $scope.progress = 100;
                                            let index =
                                                findProduct(product_new);
                                            $scope.products[index] = res.data;
                                            $scope.tableParams.reload();

                                            initializeForUpdate($scope.products[index]);

                                            $rootScope.showSimpleToast(
                                                "Sửa thông tin sản phẩm thành công!",
                                                "success"
                                            );
                                            $timeout(function () {
                                                $scope.progress = 0;
                                            }, 500);
                                        }, (err) => {
                                            $rootScope.showSimpleToast(
                                                "Không thể sửa sản phẩm!",
                                                "warning"
                                            );
                                        });
                                }
                            });
                        },
                        function (response) {},
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

        // Delete Product
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
                method: "DELETE",
                url: API_URL + "/api/admin/file",
                data: { paths: paths },
                "Content-Type": "application/json",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + adminService.getCurrentToken(),
                },
            })
                .then((res) => {
                    return $http({
                        method: "DELETE",
                        url:
                            API_URL +
                            "/api/admin/product/" +
                            $scope.product_for_delete.product_id,
                        headers: {
                            "Content-Type": "application/json",
                            Authorization:
                                "Bearer " + adminService.getCurrentToken(),
                        },
                    });
                })
                .then((res) => {
                    let index = findProduct($scope.product_for_delete);
                    $scope.products.splice(index, 1);
                    $scope.tableParams.reload();

                    $rootScope.showSimpleToast(
                        "Xóa sản phẩm thành công!",
                        "success"
                    );
                }, (err) => {
                    $rootScope.showSimpleToast(
                        "Không thể xóa sản phẩm!",
                        "warning"
                    );
                });
        };
    }
);
