var webChat = angular.module('webChat', ['ngRoute','smoothScroll', 'zInfiniteScroll']);
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
    .when("/test/:cid/:uid", {
        templateUrl : "partials/test.html",
        controller : 'conversationCtrl'
    });
    /*.when("/test", {
        templateUrl : "partials/test.html"
    })
    .otherwise({redirectTo:'/NotFound'});*/
});
