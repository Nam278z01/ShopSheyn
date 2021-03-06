import $ from "jquery";
window.$ = window.jQuery = $;
require("bootstrap");
require("jquery-slimscroll");
require("fastclick");
require("angular");
require("angular-route");
require("angular-sanitize");
require("angular-animate");
require("angular-aria");
require("angular-messages");
require("angular-material");
require("ng-file-upload");
require("angular-local-storage");
require("ng-table/bundles/ng-table.min");
require("ui-select");
require('@gruposinternet/angular-ckeditor')
require('zingchart')
require('zingchart-angularjs')
require("./js/adminlte.min");
require("./js/demo");
window.myApp = angular.module("myApp", [
    "ngSanitize",
    "ngTable",
    "ngRoute",
    "ui.select",
    'ngAnimate',
    "ngMaterial",
    "ngMessages",
    "ngFileUpload",
    'ckeditor',
    'LocalStorageModule',
    'zingchart-angularjs'
]);
require("./controller/app.management");
require("./controller/dashboard.controller");
require("./controller/product.management.controller");
require("./controller/order.management.controller");
require("./controller/print.controller");
