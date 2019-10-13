DealerApp.controller('pageNotFoundCtrl',['$scope','$http','apiurl',function($scope,$http,apiurl){

  $scope.backtoBasic = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }

}]);

DealerApp.controller('transactionCtrl',['$scope','$http','$rootScope','apiurl','$routeParams',function($scope,$http,$rootScope,apiurl,$routeParams){


  page = 0;
  checkLastPage = false;
  $scope.transactionBilling = [];
  $scope.transactionData = [];
  $scope.loader = true;
  $scope.sessionId = $routeParams.sid;
  $scope.gettransaction = function(pageNo){
    var data = {'session_user_id':$scope.sessionId,'page_no':pageNo};
    $http.post(apiurl+'api_doview_transaction',data).then(function(response){
      console.log(response.data);
      if(response.data.Result==1)
      {
        $scope.currentData = response.data;
        if(response.data.dealer_billing.length!=0)
        {
          checkLastPage = false;
          $scope.transactionData = response.data.dealer_billing;
          $scope.loader = false;
        }
        else{
          checkLastPage = true;
        }
      }
      else
      {
        swal("No data Found. Try again later...");
      }
      $scope.pageLoader = false;
    },function(response){
      console.log('Service Error');
      swal("Unable to reach server. Try again later...");
    });
  }
  $scope.gettransaction(page);

  $scope.$watch('transactionData', function(newValue, oldValue){
    //console.log(newValue);
     // $scope.loader = true;
      angular.forEach(newValue, function(value,key){
        $scope.transactionBilling.push({'plan':value.planname,'amount':value.total_amount,'transactionDate':value.billing_date,'paymentMode':value.mode,'paymentStatus':value.bill_status,'planDesc':value.description,'plansubStart':value.subscription_start_date,'plansubEnd':value.subscription_end_date,'period':value.period});
      });
     // $scope.loader = false;
      console.log($scope.transactionBilling);
  }, true);


  window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {

        console.log("you're at the bottom of the page");
        if(checkLastPage == false)
        {
          $scope.pageLoader = true;
          console.log(1);
          page++;
          $scope.gettransaction(page);
        }
        
    }
  };

}]);


DealerApp.run(function($rootScope, $templateCache) {
   $rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
   });
});

