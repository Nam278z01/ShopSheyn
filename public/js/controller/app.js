var app = angular.module("myApp", ['angularUtils.directives.dirPagination', 'ui.router'])

app.constant('API_URL', '');

app.run(function ($rootScope, $http, API_URL) {
    $http({
        method: 'GET',
        url: API_URL + "/api/category",
    }).then((res) => {
        $rootScope.categories = res.data.data
    })
})

app.config(function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/");
    $stateProvider
        .state('home', {
            url: "/",
            templateUrl: "html/home.html"
        })
        .state('product', {
            url: "/product",
            templateUrl: "html/product.html"
        })
        .state('details', {
            url: "/details",
            templateUrl: "html/details.html"
        })
});
