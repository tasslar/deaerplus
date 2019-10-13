var DealerApp = angular.module('CarDealer', ['ngRoute','ui.materialize','ngCacheBuster']);
DealerApp.config(function($routeProvider) {
    $routeProvider
    .when("/registerDone", {
        templateUrl : "partials/successfullRegister.html"
    })
    .when("/oops", {
        templateUrl : "partials/oopsPage.html"/*,
        controller : 'oopsCtrl'*/
    })
    .when("/NotFound", {
        templateUrl : "partials/pageNotFound.html",
        controller : 'pageNotFoundCtrl'
    })
	.when("/CheckPrice", {
        templateUrl : "partials/inventory-CheckPrice.html",
        controller : 'CheckPriceCtrl'
    })
    .when("/basicInfo/:sid", {
        templateUrl : "partials/inventory-basicinfo.html",
        controller : 'basicInfoCtrl'
    })
    .when("/EditBasicInfo/:sid/:cid", {
        templateUrl : "partials/inventory-EditBasicInfo.html",
        controller : 'EditBasicInfoCtrl'
    })
    .when("/priceInfo/:sid", {
        templateUrl : "partials/inventory-price.html",
        controller : 'pricingInfoCtrl'
    })
    .when("/EditPriceInfo/:sid/:cid", {
        templateUrl : "partials/inventory-EditPrice.html",
        controller : 'EditPricingInfoCtrl'
    })
    .when("/inventoryImage/:sid/:carId", {
        templateUrl : "partials/inventory-images.html",
        controller : 'inventoryImageCtrl'
    })
    .when("/inventoryDocument/:sid/:cid", {
        templateUrl : "partials/inventory-document.html",
        controller : 'inventoryDocumentCtrl'
    })
    .when("/vinlookup/:sid", {
        templateUrl : "partials/vinlookup.html",
        controller : 'vinlookupCtrl'
    })
    .when("/vinlookupEdit/:sid", {
        templateUrl : "partials/vinlookup.html",
        controller : 'vinlookupEditCtrl'
    })
    .when("/inventoryCertification/:sid/:cid", {
        templateUrl : "partials/inventory-certification.html",
        controller : 'inventorycertificateCtrl'
    })
    .when("/inventoryEngine/:sid/:cid", {
        templateUrl : "partials/inventory-engine.html",
        controller : 'inventoryEngineCtrl'
    })
    .when("/insurance/:sid/:cid", {
        templateUrl : "partials/insurance.html",
        controller : 'insuranceCtrl'
    })
    .when("/wateMarkImage", {
        templateUrl : "partials/wateMarkImage.html",
        controller : 'watermarkCtrl'
    })
    .when("/onlinePortal/:sid/:cid/:pageId", {
        templateUrl : "partials/onlinePortal.html",
        controller : 'onlinePortalCtrl'
    })
    .when("/sold/:sid/:cid", {
        templateUrl : "partials/sold.html",
        controller : 'soldCtrl'
    })
    .when("/city", {
        templateUrl : "partials/city.html"/*,
        controller : 'cityCtrl'*/
    })
    .when("/test", {
        templateUrl : "partials/test.html"
    })
    .when("/errorPage", {
        templateUrl : "partials/errorPage.html",
        controller : 'errorPageCtrl'
    })
    .when("/nodataFound", {
        templateUrl : "partials/nodataFound.html",
        controller : 'errorPageCtrl'
    })
    .when("/market/:sid/:cid", {
        templateUrl : "partials/market.html",
        controller : 'marketCtrl'
    })
    .when("/back", {
        templateUrl : "partials/back.html"
    })
    .otherwise({redirectTo:'/NotFound'});
});

//DealerApp.constant('apiurl','http://52.221.57.201/dev/public/');

DealerApp.constant('apiurl','http://13.228.84.233/');

//DealerApp.constant('apiurl','http://dev.dealerplus.in/dev/public/');

//DealerApp.constant('apiurl','http://52.221.99.190/');

DealerApp.config(function ($provide,$routeProvider) {

    $provide.decorator('$exceptionHandler', function ($delegate) {

        return function (exception, cause) {
            $delegate(exception, cause);

            //swal("Something went wrong. Try again later...");
        };
    });
});

DealerApp.config(function(httpRequestInterceptorCacheBusterProvider){
    httpRequestInterceptorCacheBusterProvider.setMatchlist([/.*images.*/]);
  });


//DealerApp.constant('apiurl','localhost/dealerplus/');

/*DealerApp.config(['$httpProvider', function($httpProvider) {
    //initialize get if not there
    if (!$httpProvider.defaults.headers.get) {
        $httpProvider.defaults.headers.get = {};    
    }    

    // Answer edited to include suggestions from comments
    // because previous version of code introduced browser-related errors

    //disable IE ajax request caching
    $httpProvider.defaults.headers.get['If-Modified-Since'] = 'Mon, 26 Jul 1997 05:00:00 GMT';
    // extra
    $httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache';
    $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';
}]);*/