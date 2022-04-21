var app = angular.module("myApp", [])

app.constant('API_URL', '');

app.run(function ($rootScope) {

})

// app.config(function ($routeProvider) {
//     $routeProvider
//         .when("/", {
//             templateUrl: "./home.html"
//         })
//         .when("/product", {
//             templateUrl: "./product.html",
//             controller: "ProductController"
//         })
//         .when("/cart", {
//             templateUrl: "./cart.html"
//         })
//         .when("/details", {
//             templateUrl: "./details.html",
//             controller: "ProductDetailsController"
//         })
// });
