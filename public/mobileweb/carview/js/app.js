var DealerApp = angular.module('CarDealer', ['ngRoute','ngMaterial','ngMessages','angular-carousel','ngCacheBuster']);
DealerApp.config(function($routeProvider) {
    $routeProvider
    .when("/NotFound", {
        templateUrl : "partials/pageNotFound.html",
        controller : 'pageNotFoundCtrl'
    })
    .when("/carview/:sId/:cId/:pageId", {
        templateUrl : "partials/carview.html",
        controller : 'carviewCtrl as ctrl'
    })
    .when("/testdrive", {
        templateUrl : "partials/testdrive.html",
        controller : 'testDriveCtrl'
    })
    .when("/newmap", {
        templateUrl : "partials/newmap.html",
        controller : 'newmapCtrl'
    })
    .when("/testpage", {
        templateUrl : "partials/testpage.html"
    })
    .when("/test", {
        templateUrl : "partials/test.html",
        controller : 'testMapCtrl'
    })
    .when("/oops", {
        templateUrl : "partials/oopsPage.html"
    })
    .when("/testcar/:sId/:cId/:pageId", {
        templateUrl : "partials/testcar.html",
        controller : 'carviewCtrl as ctrl'
    })
     .when("/back", {
        templateUrl : "partials/back.html"
    })
    .otherwise({redirectTo:'/NotFound'});
});

//DealerApp.constant('apiurl','http://52.221.99.190/');

DealerApp.constant('apiurl','http://13.228.84.233/');

//DealerApp.constant('apiurl','http://52.221.57.201/dev/public/');

//DealerApp.constant('apiurl','http://dev.dealerplus.in/dev/public/');

DealerApp.config(function(httpRequestInterceptorCacheBusterProvider){
    httpRequestInterceptorCacheBusterProvider.setMatchlist([/.*images.*/]);
  });

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