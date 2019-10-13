var webChat = angular.module('ionicApp', ['ionic','ngCacheBuster']);

webChat.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider
  .state('intro', {
    url: '/buy/:cid/:uid', 
    //If in a folder, template/welcome.html    
    templateUrl: 'partials/buy.html',
      controller: 'buyCtrl'
  })

  .state('intro1', {
    url: '/sell/:cid/:uid', 
    //If in a folder, template/welcome.html    
    templateUrl: 'partials/sell.html',
      controller: 'sellCtrl'
  })
  
  .state('login', { 
    url: '/account/login', 
    //If in a folder, template/login.html
    templateUrl: 'login.html',
    controller: 'LoginController '
  })
 

  $urlRouterProvider.otherwise("/");
});

//webChat.constant('apiurl','http://52.221.57.201/dev/public/');

//webChat.constant('apiurl','http://52.221.99.190/');

webChat.constant('apiurl','http://13.228.84.233/');

webChat.config(function(httpRequestInterceptorCacheBusterProvider){
    httpRequestInterceptorCacheBusterProvider.setMatchlist([/.*images.*/]);
  });
