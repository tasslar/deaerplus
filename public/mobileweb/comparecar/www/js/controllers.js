angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout, $rootScope, $ionicHistory, $location, $window) {

  // With the new view caching in Ionic, Controllers are only called
  // when they are recreated or on app start, instead of every page change.
  // To listen for when this page is active (for example, to refresh data),
  // listen for the $ionicView.enter event:
  //$scope.$on('$ionicView.enter', function(e) {
  //});
  
  $rootScope.goBack = function() {
	  
	 // window.location = 'http://52.221.57.201/dev/public/mobileweb/back.html';
	  
	//  window.location = 'http://52.221.99.190/mobileweb/back.html';
	window.location = 'http://13.228.84.233/mobileweb/back.html';
	  
	   };

  // Form data for the login modal
  $scope.loginData = {};

  // Create the login modal that we will use later
  
  // Triggered in the login modal to close it
 

  // Perform the login action when the user submits the login form
  
})
.controller('CompareCtrl', function($scope, $stateParams, $http, $ionicModal) {
	
	
	
	$scope.cardata = {};
 $scope.cardata.session_user_id = $stateParams.sId;
 
// alert("se id="+$scope.cardata.session_user_id);
 
 $scope.cardata.car1_id = $stateParams.c1d;
 
 //alert("car1_id id="+$scope.cardata.car1_id);
 
 $scope.cardata.car2_id = $stateParams.c2d;
 
 //alert("car2_id id="+$scope.cardata.car2_id);
 
 $scope.cardata.car_id = $scope.cardata.car1_id+','+$scope.cardata.car2_id;
 
 
 
 //$scope.cardata.session_user_id = '2';

 
//$scope.cardata.car_id = 'DPLD20170321115228,DPLD20170322113900';
 
 //$scope.cardata.car_id = 'DPLD20170327012657';

 $http({
										url: 'http://13.228.84.233/api_buy_compare',
								//url: 'http://52.221.99.190/api_buy_compare',
							//url: 'http://52.221.57.201/dev/public/api_buy_compare',
								method: "POST",
								headers : {
									
									'Content-Type' : 'application/json'
									
								},
								//timeout : 4500,
								data: JSON.stringify($scope.cardata),
							})
							.success(function(response) {
							
							//alert("sucess");		
								
								//alert("res="+JSON.stringify(response));
								$scope.details = response;
								$scope.carimagedetails = response.carimagesdetails;
								$scope.imageurl1 = response.carimagesdetails[0];
        						$scope.imageurl2 = response.carimagesdetails[1];
								$scope.carmodeldetails = response.carmodeldetails;
								$scope.carspecification = response.carspecification;
								$scope.carenginedetails = response.carenginedetails;
								$scope.cardimentiondetails = response.cardiemention;
								$scope.carinteriordetails = response.carinteriordetails;
								$scope.carcomfortdetails = response.carcomportdetails;
								$scope.carsafetydetails = response.carsafetydetails;
								$scope.carexteriordetails = response.carexteriordetails;
								$scope.carentertainmentdetails = response.carentertainmentdetails;
								//alert("dat="+JSON.stringify($scope.cardetails));
								//$ionicLoading.hide();										
								//alert(JSON.stringify(response.status));
								
								
								
							
							}, 
						
							function(response) { // optional
							
								//$ionicLoading.hide();  
								  
							}).error(function(data)
								{
									//$ionicLoading.hide();
									
									alert("Failed to connect to the server. Please try again later");
									
										});
 
 
 $scope.openmodal =  function(imgs){
	 
	//alert("imgs="+imgs);
		
		$ionicModal.fromTemplateUrl('templates/view_image.html', {
						scope: $scope
					  }).then(function(modal) {
						  
							$scope.image_url = imgs;
						//	$scope.image_length = $scope.image_url.length;
							

							
							$scope.modal = modal;
							$scope.modal.show();
							//initialize1();
							
					  });
		
	}
 
 $scope.closeModal =  function()
	 {

		  $scope.modal.remove();
	 }
	
	$scope.backward = function()
 {
  
    
  $scope.expand_id = window.localStorage.getItem('expand_id');
  
  if($scope.expand_id==null || $scope.expand_id=='' || $scope.expand_id==undefined || $scope.expand_id=='NaN')
  {
   

   $scope.current_tab =1;
   
   window.localStorage.setItem('expand_id','1');
   
  }
  else{
	 
   $scope.new_expand = parseInt($scope.expand_id)-parseInt(1);
   
  
  window.localStorage.setItem('expand_id',$scope.new_expand);
  
  if($scope.new_expand  == 0)
  {
	 
	  	  $scope.current_tab =$scope.expand_id;
	  
   
   window.localStorage.setItem('expand_id',$scope.expand_id);
   
   
    }
  
  else
  {
	
	  $scope.current_tab =$scope.new_expand;
	  
  
  }
   
  }
  
    
 }
 
 $scope.forward = function()
 {
  
  
  
  $scope.expand_id = window.localStorage.getItem('expand_id');
  
  
  if($scope.expand_id==null || $scope.expand_id=='' || $scope.expand_id==undefined || $scope.expand_id=='NaN')
  {
   $scope.current_tab =1;
   
   window.localStorage.setItem('expand_id','1');
  }
  
  else
   
   {
    
    $scope.new_expand = parseInt($scope.expand_id)+parseInt(1);
      
  window.localStorage.setItem('expand_id',$scope.new_expand);
  
  if($scope.new_expand  == 10)
  {
	  $scope.current_tab =10;
  
   window.localStorage.setItem('expand_id',$scope.expand_id);

    }
  
  else
  {
   $scope.current_tab =$scope.new_expand;
 
  
  }
    
   }
  
  
  
 
 }
	
	$scope.expand = function(id)
	{
		window.localStorage.setItem('expand_id',id);
		
		//alert(window.localStorage.getItem('expand_id'));
	}

	$scope.toggleGroup = function(group) {
    if ($scope.isGroupShown(group)) {
      $scope.shownGroup = '0';
    } else {
      $scope.shownGroup = group;
    }
  };
  $scope.isGroupShown = function(group) {
    return $scope.shownGroup === group;
  };
	
}).controller('CarviewCtrl', function($scope, $stateParams) {
	
});
