var DealerApp = angular.module('CarDealer', ['ngRoute','ngMaterial','ngMessages']);
DealerApp.config(function($routeProvider) {
    $routeProvider
    .when("/registerDone", {
        templateUrl : "partials/successfullRegister.html"
    })
    .when("/oops", {
        templateUrl : "partials/oopsPage.html",
        controller : 'oopsCtrl'
    })
    .when("/NotFound", {
        templateUrl : "partials/pageNotFound.html",
        controller : 'oopsCtrl'
    })
    .when("/basicInfo/:sid", {
        templateUrl : "partials/inventory-basicinfo.html",
        controller : 'basicInfoCtrl'
    })
    .when("/priceInfo", {
        templateUrl : "partials/inventory-price.html",
        controller : 'pricingInfoCtrl'
    })
    .when("/inventoryImage", {
        templateUrl : "partials/inventory-images.html",
        controller : 'inventoryImageCtrl'
    })
    .when("/inventoryDocument", {
        templateUrl : "partials/inventory-document.html",
        controller : 'inventoryDocumentCtrl'
    })
    .when("/inventoryCertification", {
        templateUrl : "partials/inventory-certification.html",
        controller : 'inventorycertificateCtrl'
    })
    .when("/inventoryEngine", {
        templateUrl : "partials/inventory-engine.html",
        controller : 'inventoryEngineCtrl'
    })
    .when("/wateMarkImage", {
        templateUrl : "partials/wateMarkImage.html"
    })
    .when("/city", {
        templateUrl : "partials/city.html",
        controller : 'cityCtrl'
    })
    .when("/test", {
        templateUrl : "partials/test.html"
    })
    .otherwise({redirectTo:'/NotFound'});
});

DealerApp.constant('apiurl','http://52.77.244.210/dev/');