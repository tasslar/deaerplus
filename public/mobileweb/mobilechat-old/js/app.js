var webChat = angular.module('webChat', ['ngRoute','smoothScroll', 'zInfiniteScroll','ngCacheBuster']);
webChat.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "partials/home.html"
    })
    .when("/conversation/:cid/:uid", {
        templateUrl : "partials/conversation.html"
    })
    .when("/buy/:cid/:uid", {
        templateUrl : "partials/buy.html",
        controller : 'buyCtrl'
    })
    .when("/sell/:cid/:uid", {
        templateUrl : "partials/sell.html",
        controller : 'sellCtrl'
    })
    .when("/test/:cid/:uid", {
        templateUrl : "partials/test.html",
        controller : 'buyCtrl'
    });
    /*.when("/test", {
        templateUrl : "partials/test.html"
    })
    .otherwise({redirectTo:'/NotFound'});*/
});

webChat.constant('apiurl','http://52.221.99.190/');
//webChat.constant('apiurl','http://52.221.57.201/dev/public/');

webChat.config(function(httpRequestInterceptorCacheBusterProvider){
    httpRequestInterceptorCacheBusterProvider.setMatchlist([/.*images.*/]);
  });


/*webChat.config(function ($provide) {

    $provide.decorator('$exceptionHandler', function ($delegate) {

        return function (exception, cause) {
            $delegate(exception, cause);

            swal("Unable to reach server. Try again later..");
        };
    });
});*/

/*webChat.config(['$httpProvider', function($httpProvider) {
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