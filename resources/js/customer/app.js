import $ from 'jquery'
window.$ = window.jQuery = $
require("slick-carousel");
require("angular");
require("angular-route");
require("angular-sanitize");
require("angular-utils-pagination");
require("angular-local-storage");
window.myApp = angular.module("myApp", [
    "angularUtils.directives.dirPagination",
    "ngRoute",
    "ngSanitize",
    'LocalStorageModule'
]);
require("./controller/app");
require("./controller/product.controller");
require("./controller/productdetails.controller");
require("./controller/order.controller");
