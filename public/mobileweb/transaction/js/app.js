var DealerApp = angular.module('CarDealer', ['ngRoute','ui.materialize']);
DealerApp.config(function($routeProvider) {
    $routeProvider
    .when("/oops", {
        templateUrl : "partials/oopsPage.html"/*,
        controller : 'oopsCtrl'*/
    })
    .when("/NotFound", {
        templateUrl : "partials/pageNotFound.html",
        controller : 'pageNotFoundCtrl'
    })
    .when("/back", {
        templateUrl : "partials/back.html"
    })
    .when("/transaction/:sid", {
        templateUrl : "partials/transaction.html",
        controller : 'transactionCtrl'
    })
    .otherwise({redirectTo:'/NotFound'});
});

//DealerApp.constant('apiurl','http://52.221.57.201/dev/public/');

//DealerApp.constant('apiurl','http://dev.dealerplus.in/dev/public/');

//DealerApp.constant('apiurl','http://52.221.99.190/');

DealerApp.constant('apiurl','http://13.228.84.233/');

DealerApp.config(function ($provide,$routeProvider) {

    $provide.decorator('$exceptionHandler', function ($delegate) {

        return function (exception, cause) {
            $delegate(exception, cause);

            //swal("Something went wrong. Try again later...");
        };
    });
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