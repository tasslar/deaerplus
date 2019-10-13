var DealerApp = angular.module('CarDealer', ['ngRoute','ngMaterial','ngMessages']);
DealerApp.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "partials/step1.html",
        controller : 'step1Ctrl'
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
    .when("/NotFound", {
        templateUrl : "partials/pageNotFound.html",
        controller : 'oopsCtrl'
    })
    .when("/back", {
        templateUrl : "partials/back.html"
    })
    .otherwise({redirectTo:'/NotFound'});
});

//DealerApp.constant('apiurl','http://52.221.99.190/');

DealerApp.constant('apiurl','http://13.228.84.233/');

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