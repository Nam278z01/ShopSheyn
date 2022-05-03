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

        $scope.product = {
            product_discount: 0,
            colors: [
                {
                    color_name: '',
                    sizes: [
                        {
                            size_name: '',
                            quantity: 0
                        }
                    ],
                    files: []
                }
            ],
            sizes: [
                {
                    size_name: '',
                    quantity: 0
                }
            ]
        }

        $scope.addColor = function () {
            $scope.product.colors.push(
                {
                    color_name: '',
                    sizes: JSON.parse(JSON.stringify([...$scope.product.sizes])),
                    files: []
                }
            )
        }
        $scope.removeColor = function (index) {
            if ($scope.product.colors.length > 1) {
                $scope.product.colors.splice(index, 1);
            }
        }
        $scope.addSize = function () {
            $scope.product.sizes.push(
                {
                    size_name: '',
                    quantity: 0
                }
            )
            $scope.product.colors.forEach(function (color) {
                color.sizes.push(
                    {
                        size_name: '',
                        quantity: 0
                    }
                )
            })

        }
        $scope.changeSizeName = function ($index, size) {
            $scope.product.colors.forEach(function (color) {
                color.sizes[$index].size_name = size.size_name
            })
        }
        $scope.removeSize = function (index) {
            if ($scope.product.sizes.length > 1) {
                $scope.product.sizes.splice(index, 1);
            }
            $scope.product.colors.forEach(function (color) {
                color.sizes.splice(index, 1);
            })
        }
        $scope.showProduct = function () {
            console.log($scope.product)
        }

        $scope.uploadFilesIntoServer = function () {
            $scope.files =  $scope.product.colors.reduce(function (colors, colorCurrent) {
                return [...colors, ...colorCurrent.files]
            }, []);
            console.log($scope.files)
            if ($scope.files && $scope.files.length) {
                Upload.upload({
                    url: API_URL + "/api/upload",
                    data: {
                        files: $scope.files
                    }
                }).then(function (response) {
                    $timeout(function () {
                        $scope.result = response.data;
                        $scope.progress = 0;
                    });
                }, function (response) {
                    if (response.status > 0) {
                        $scope.errorMsg = response.status + ': ' + response.data;
                    }
                }, function (evt) {
                    $scope.progress =
                        Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                });
            }
        };
    }
);
