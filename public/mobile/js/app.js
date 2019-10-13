var DealerApp = angular.module('CarDealer', ['ngRoute','ngMaterial','ngMessages','angular-carousel']);
DealerApp.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "partials/step1.html",
        controller : 'step1Ctrl as vm'
    })
    .when("/step2", {
        templateUrl : "partials/step2.html",
        controller : 'step2Ctrl'
    })
    .when("/finalStep", {
        templateUrl : "partials/finalStep.html",
        controller : 'finalStepCtrl'
    })
    .when("/registerDone", {
        templateUrl : "partials/successfullRegister.html"
    })
    .when("/oops", {
        templateUrl : "partials/oopsPage.html",
        controller : 'oopsCtrl'
    })
    .when("/auto", {
        templateUrl : "partials/autocomplete.html"
    })
    .when("/NotFound", {
        templateUrl : "partials/pageNotFound.html",
        controller : 'oopsCtrl'
    })
    .when("/carview/:sId/:cId", {
        templateUrl : "partials/carview.html",
        controller : 'carviewCtrl'
    })
    .when("/converstion", {
        templateUrl : "partials/conversation.html",
        controller : 'converstionCtrl'
    })
    .when("/basicInfo", {
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
    .when("/test", {
        templateUrl : "partials/test.html"
    })
    .when("/wateMarkImage", {
        templateUrl : "partials/wateMarkImage.html"
    })
    .otherwise({redirectTo:'/NotFound'});
});
