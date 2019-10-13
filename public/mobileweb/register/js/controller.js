DealerApp.controller('step1Ctrl',['$scope','$http','RegisterService','$timeout', 'apiurl',function($scope,$http,RegisterService,$timeout,apiurl){

	 	
		console.log("step 1 controller");
		$scope.loader = true;
		$scope.cities = '';
		console.log(apiurl+'master_city_get');
		$scope.getCity = function(){
			$http.get(apiurl+'master_city_get').then(function(response){
				console.log(response.data);
				$scope.cities = response.data[0];
			},function(response){
				console.log('Service Error');
				$timeout(function () {
			        window.location = '#/oops';
			    }, 1000);
			});
		}
		$scope.getCity();

		$scope.newVar = {
	    	val: ""
	  	};

	  	$scope.chkMobile = function(errorData){
	  		var mobileData = {'mobilenumber':$scope.dContact};
  			console.log(mobileData);
  			$http.post(apiurl+'doapicontactexist',mobileData).then(function(response){
  				console.log(response.data);	  
  				//ngModel.$setValidity('dContact', true);	

				if(response.data.result==1)
				{
					errorData.dContact.$setValidity('one', true);
					console.log(errorData);
					
				}
				else
				{
					errorData.dContact.$setValidity('one', false);
					console.log(errorData);
				}
			},function(response){
				console.log('Service Error');
				deferred.notify();
			});
		}

		$scope.pickCity = function(cityId,cityName)
  		{
  			$scope.dCity = cityName;
  			$scope.cityId = cityId;
  			$scope.searchCity = '';
  			$('.close').click();
  		}
  		
  		$scope.step1 = function()
  		{
  			$scope.dealerData = {'DName':$scope.dName,'DContact':$scope.dContact,'DEmail':$scope.dEmail,'DShipName':$scope.dShipName,'Dcity':$scope.cityId,'plan':''};
  			RegisterService.ProcessedData = $scope.dealerData;
  			console.log(RegisterService.ProcessedData);
  			window.location = '#/step2';
  		}


  		$scope.$watch('$viewContentLoaded', function()
        {
            $scope.loader = false;
        });
  		
  	

}]);

DealerApp.run(function($rootScope, $templateCache) {
   $rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
   });
});


DealerApp.controller('step2Ctrl',['$scope','$http','$rootScope','RegisterService','$mdToast','$mdDialog','apiurl',function($scope,$http,$rootScope,RegisterService,$mdToast,$mdDialog,apiurl){

		console.log("step 2 controller");

		$scope.loader = true;
  		$scope.dealerData = RegisterService.ProcessedData;

  		if($scope.dealerData !='') //check if data is present or not
  		{
  			console.log("enter");
  			$scope.loader = true;
			/*toast code starts here*/
			var last = {
		      bottom: false,
		      top: true,
		      left: false,
		      right: true
		    };

			$scope.toastPosition = angular.extend({},last);

				$scope.getToastPosition = function() {
				sanitizePosition();

				return Object.keys($scope.toastPosition)
				  .filter(function(pos) { return $scope.toastPosition[pos]; })
				  .join(' ');
			};

		  	function sanitizePosition() {
			    var current = $scope.toastPosition;

			    if ( current.bottom && last.top ) current.top = false;
			    if ( current.top && last.bottom ) current.bottom = false;
			    if ( current.right && last.left ) current.left = false;
			    if ( current.left && last.right ) current.right = false;

			    last = angular.extend({},current);
			}

			/* toast code ends here*/
	  		$scope.planTopic = function(){
				$http.get(apiurl+'api_master_plandetails').then(function(response){
					console.log(response.data);
					$scope.AllplanDetails = response.data;
					$scope.initFun();
				},function(response){	
					console.log('Service Error');
				});
			}
			$scope.planTopic();

			$scope.initFun = function()
			{
				if($scope.dealerData.plan != '')
				{
					$scope.selectedIndex = $scope.dealerData.position;
					$scope.AllplanDetails[$scope.selectedIndex].answer = $scope.dealerData.plan;
					$scope.loader = false;
				}
				else
				{
					$scope.loader = false;
				}
			}


			$scope.step2 = function()
			{
				//$scope.AllplanDetails[$scope.selectedIndex].answer = 2;
				if($scope.AllplanDetails[$scope.selectedIndex].answer!='')
				{
					angular.forEach($scope.AllplanDetails[$scope.selectedIndex].plans,function(value,key){
							if(value.subscription_plan_id==$scope.AllplanDetails[$scope.selectedIndex].answer)
							{
				  				$scope.dealerData.planDescription = value.frequency_desc;
				  				$scope.dealerData.unitCost = value.unit_cost;	  	
				  				$scope.dealerData.planFreqId = value.frequency_id;
				  				$scope.dealerData.planHeader = value.plan_type_name;

							}
					});
					$scope.dealerData.plan = $scope.AllplanDetails[$scope.selectedIndex].answer;
					$scope.dealerData.position = $scope.selectedIndex;
		  			RegisterService.ProcessedData = $scope.dealerData;
		  			console.log(RegisterService.ProcessedData);
	  				window.location = '#/finalStep';
	  			}
	  			else
	  			{
	  				var pinTo = $scope.getToastPosition();
				    $mdToast.show(
				      $mdToast.simple()
				        .textContent('Pls, Choose Plan!')
				        .position(pinTo )
				        .hideDelay(2000)
				    );
	  			}

			}

			/*confirm trial register*/

	  		$scope.ConfirmTrial = function(ev) {
			    // Appending dialog to document.body to cover sidenav in docs app
			    var confirm = $mdDialog.confirm()
			          .title('Would you like to make your trip trial?')
			          .textContent('By clicking confirm that you are agreed for all terms and conditions')
			          .targetEvent(ev)
			          .ok('Yes, Confirm')
			          .cancel('No, Cancel');

			    $mdDialog.show(confirm).then(function() {
			      $scope.trialRegister();
			    }, function() {
			      $scope.status = 'cancelled it.';
			    });
		  	};



	  		$scope.trialRegister = function()
	  		{
	  			$scope.loader = true;
	  			$scope.dealerData.couponId = 0;
	  			$scope.dealerData.finalamount = 0;
	  			$scope.dealerData.plan = 1;
	  			$scope.dealerData.planFreqId = 1;
	  			var data = $scope.dealerData;
	  			console.log(data);
	  			$http.post(apiurl+'registration_store',data).then(function(response){
					console.log(response.data);
					if(response.data.Result==1)
					{
						$scope.loader = false;
						$scope.dealerData = [];
						window.location = '#/registerDone';
					}
					else
					{
						$scope.loader = false;
						var pinTo = $scope.getToastPosition();
						$mdToast.show(
					      $mdToast.simple()
					        .textContent(response.data.message)
					        .position(pinTo )
					        .hideDelay(2000)
					    );
					}
				},function(response){
					console.log('Service Error');
					window.location = '#/oops';
				});
	  		}
		}
		else
	  	{
	  		console.log("exist");
	  		window.location = '#/oops';
	  	}

		

}]);


DealerApp.controller('finalStepCtrl',['$scope','$http','$rootScope','RegisterService','$mdDialog','$mdToast','apiurl',function($scope,$http,$rootScope,RegisterService,$mdDialog,$mdToast,apiurl){

		console.log("Final Step controller");

		$scope.dealerData = RegisterService.ProcessedData;
		if($scope.dealerData !='') //check if data is present or not
  		{

  			/*toast code starts here*/
			var last = {
		      bottom: false,
		      top: true,
		      left: false,
		      right: true
		    };

			$scope.toastPosition = angular.extend({},last);

				$scope.getToastPosition = function() {
				sanitizePosition();

				return Object.keys($scope.toastPosition)
				  .filter(function(pos) { return $scope.toastPosition[pos]; })
				  .join(' ');
			};

		  	function sanitizePosition() {
			    var current = $scope.toastPosition;

			    if ( current.bottom && last.top ) current.top = false;
			    if ( current.top && last.bottom ) current.bottom = false;
			    if ( current.right && last.left ) current.left = false;
			    if ( current.left && last.right ) current.right = false;

			    last = angular.extend({},current);
			}

			/* toast code ends here*/

  			/*pop function starts here*/

			$scope.project = {
			  comments: 'Comments',    
			};
	 		$scope.status = '  ';
		  	$scope.customFullscreen = false;

		  	
	  	 	$scope.couponRowId = 0;
			$scope.couponAmount = 0;

		  	$scope.showAdvanced = function(ev) {
				$mdDialog.show({
				  controller: 'dialogCloseCtrl',
				  templateUrl: 'partials/planDetails.html',
				  parent: angular.element(document.body),
				  targetEvent: ev,
				  clickOutsideToClose:true,
				  fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
				})
				.then(function(answer) {
				  $scope.status = 'You said the information was "' + answer + '".';
				}, function() {
				  $scope.status = 'You cancelled the dialog.';
				});
			  };

			  /* pop up function ends here*/

		  	$scope.tandc = false; // terms and condition
	  		console.log($scope.dealerData);
	  		$scope.step2 = function()
	  		{
	  			RegisterService.ProcessedData = $scope.dealerData;
	  			console.log(RegisterService.ProcessedData);
	  			window.location = '#/step2';
	  		}

	  		$scope.finalConfirm = function()
	  		{	$scope.loader = true;
	  			$scope.dealerData.couponId = $scope.couponRowId;
	  			$scope.dealerData.finalamount = $scope.dealerData.unitCost-$scope.couponAmount;
	  			var data = $scope.dealerData;
	  			console.log(data);
	  			$http.post(apiurl+'registration_store',data).then(function(response){
					console.log(response.data);
					if(response.data.Result==1)
					{
						$scope.loader = false;
						window.location = '#/registerDone';
					}
					else
					{
						$scope.loader = false;
						var pinTo = $scope.getToastPosition();
						$mdToast.show(
					      $mdToast.simple()
					        .textContent(response.data.message)
					        .position(pinTo )
					        .hideDelay(2000)
					    );
					}
				},function(response){
					console.log('Service Error');
					window.location = '#/oops';
				});
	  		}

	  		$scope.ApplyCoupon = function()
	  		{
	  			var data = {'plan_id':$scope.dealerData.plan,'coupancode':$scope.coupon};
	  			console.log(data);
	  			$http.post(apiurl+'doapicoupanexist',data).then(function(response){
					console.log(response.data);
					if(response.data.result==1)
					{
						var pinTo = $scope.getToastPosition();
					    $mdToast.show(
					      $mdToast.simple()
					        .textContent(response.data.message)
					        .position(pinTo )
					        .hideDelay(2000)
					    );
					    $scope.couponCode = $scope.coupon;
					    $scope.couponAmount = response.data.coupanamount;
					    $scope.couponRowId = response.data.coupon_id;
					}
					else
					{
						//erroMsg = response.data.message;
						var pinTo = $scope.getToastPosition();
					    $mdToast.show(
					      $mdToast.simple()
					        .textContent(response.data.message)
					        .position(pinTo )
					        .hideDelay(2000)
					    );
					    $scope.coupon = "";
					}
				},function(response){
					console.log('Service Error');
					var pinTo = $scope.getToastPosition();
					    $mdToast.show(
					      $mdToast.simple()
					        .textContent('Servers are in Maintanence. Try again after Some Time.')
					        .position(pinTo )
					        .hideDelay(2000)
					    );
				});
	  		}

  		}
	  	else
	  	{
	  		console.log("exist");
	  		window.location = '#/oops';
	  	}

}]);

DealerApp.controller('dialogCloseCtrl',['$scope','$mdDialog',function($scope,$mdDialog){

	$scope.cancel = function()
	{
		$mdDialog.hide();
	}

}]);

DealerApp.controller('oopsCtrl',['$scope','$http','$rootScope','RegisterService',function($scope,$http,$rootScope,RegisterService){

	/*setTimeout(function(){ 
			window.location = '#/';
		}, 2000);*/

}]);


DealerApp.service("RegisterService", function() {
  return {
    ProcessedData: []
  }
});

DealerApp.directive('numbersOnly', function(){
   return {
     require: 'ngModel',
     link: function(scope, element, attrs, modelCtrl) {
       modelCtrl.$parsers.push(function (inputValue) {
           // this next if is necessary for when using ng-required on your input.
           // In such cases, when a letter is typed first, this parser will be called
           // again, and the 2nd time, the value will be undefined
           if (inputValue == undefined) return ''
           var transformedInput = inputValue.replace(/[^0-9]/g, '');
           if (transformedInput!=inputValue) {
              modelCtrl.$setViewValue(transformedInput);
              modelCtrl.$render();
           }        

           return transformedInput;        
       });
     }
   };
});

DealerApp.directive('accessibleForm', function () {
    return {
        restrict: 'A',
        link: function (scope, elem) {

            // set up event handler on the form element
            elem.on('submit', function () {

                // find the first invalid element
                var firstInvalid = elem[0].querySelector('.ng-invalid');

                // if we find one, set focus
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            });
        }
    };
});

DealerApp.directive('usernameValidator', function($q, $timeout, $http, apiurl) {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$asyncValidators.dEmail = function(modelValue, viewValue) {
                if (!viewValue) {
                    return $q.when(true);
                }
                var deferred = $q.defer();
                var emailData = {'email':viewValue};
	  			console.log(emailData);
	  			$http.post(apiurl+'doapiemailidexist',emailData).then(function(response){
	  				console.log(response.data);
					if(response.data.result==1)
					{
						
						deferred.resolve();
					}
					else
					{
						deferred.reject();
					}
				},function(response){
					console.log('Service Error');
					deferred.notify();
				});
                return deferred.promise;
            };
            
        }
    };
});


DealerApp.directive('noValidator', function($q, $timeout, $http, apiurl) {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
           
            ngModel.$asyncValidators.dContact = function(modelValue, viewValue) {
                if (!viewValue) {
                	
                    return $q.when(true);
                }
                var deferred = $q.defer();                
                var mobileData = {'mobilenumber':viewValue};
	  			console.log(mobileData);
	  			$http.post(apiurl+'doapicontactexist',mobileData).then(function(response){
	  				console.log(response.data);	  
	  				//ngModel.$setValidity('dContact', true);	
					//ngModel.one = true;	
					if(response.data.result==1)
					{
						//ngModel.$setValidity('dContact', true);
						//ngModel.one = false;
						deferred.resolve();
						//console.log('1');
					}
					else
					{
						//ngModel.$setValidity('dContact', false);
						deferred.reject();
						//console.log('2');
					}
				},function(response){
					console.log('Service Error');
					deferred.notify();
				});
                return deferred.promise;
            };
        }
    };
});


 DealerApp.directive('noSpecialChar', function() {
    return {
      require: 'ngModel',
      restrict: 'A',
      link: function(scope, element, attrs, modelCtrl) {
        modelCtrl.$parsers.push(function(inputValue) {
          if (inputValue == undefined)
            return ''
          cleanInputValue = inputValue.replace(/[^\w\s]/gi, '');
          if (cleanInputValue != inputValue) {
            modelCtrl.$setViewValue(cleanInputValue);
            modelCtrl.$render();
          }
          return cleanInputValue;
        });
      }
    }
  });

