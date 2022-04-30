window.$ = require("jquery");
require("slick-carousel");
require("angular");
require("angular-route");
require("angular-sanitize");
require("angular-utils-pagination");
window.myApp = angular.module("myApp", [
    "angularUtils.directives.dirPagination",
    "ngRoute",
    "ngSanitize",
]);
require("./controller/app");
require("./controller/product.controller");
require("./controller/productdetails.controller");
require("./controller/cart.controller");
