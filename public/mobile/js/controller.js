DealerApp.controller('step1Ctrl',['$scope','$http','$rootScope','RegisterService','$timeout', '$q', '$log', '$mdDialog',function($scope,$http,$rootScope,RegisterService,$timeout, $q, $log, $mdDialog){

		console.log("step 1 controller");
		$scope.loader = true;
		
		$scope.getCity = function(){
			$http.get('http://52.221.57.201/dev/public/master_city_get').then(function(response){
				console.log(response.data);
				$scope.cities = response.data[0];
				$scope.loader = false;
			},function(response){
				console.log('Service Error');
				//console.log(response);
			});
		}
		$scope.getCity();

		$scope.newVar = {
	    	val: ""
	  	};

	  	$scope.showTabDialog = function(ev,page,ctrl) {
	  		console.log($scope.cities);

			$mdDialog.show({
				templateUrl: page,
				controller: ctrl,
				parent: angular.element(document.body),
				targetEvent: ev,
				clickOutsideToClose:true,
				escapeToClose: false,
				animate: 'full-screen-dialog',
				locals: {
		           items: $scope.cities
		         }
				
			})
			.then(function(answer) {
			  $scope.status = 'You said the information was "' + answer + '".';
			}, function() {
			  $scope.status = 'You cancelled the dialog.';
			});
	  	};

	  	

	  	$scope.chkMobile = function(errorData){
	  		var mobileData = {'mobilenumber':$scope.dContact};
  			console.log(mobileData);
  			$http.post('http://52.221.57.201/dev/public/doapicontactexist',mobileData).then(function(response){
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
  		
  		$scope.step1 = function()
  		{
  			$scope.dealerData = {'DName':$scope.dName,'DContact':$scope.dContact,'DEmail':$scope.dEmail,'DShipName':$scope.dShipName,'Dcity':$scope.dCity,'plan':''};
  			RegisterService.ProcessedData = $scope.dealerData;
  			console.log(RegisterService.ProcessedData);
  			window.location = '#/step2';
  		}


  		$scope.loader = false;

  		


}]);

DealerApp.controller('cityCtrl',['$scope','$http','$rootScope','RegisterService','items','$mdDialog',function($scope,$http,$rootScope,RegisterService,items,$mdDialog){

	//$scope.dealerData = RegisterService.ProcessedData;
	
	$scope.cities = items;
	console.log(items);
	console.log('city cotroller');
	$scope.loader = false;
	// city 
	/*$scope.getCity = function(){
		$http.get('http://52.221.57.201/dev/public/master_city_get').then(function(response){
			//console.log(response.data);
			$scope.cities = response.data;
			$scope.loader = false;
		},function(response){
			console.log('Service Error');
		});
	}
	$scope.getCity();*/

	$scope.close = function()
	{
		$mdDialog.hide();
	}


}]);

DealerApp.controller('step2Ctrl',['$scope','$http','$rootScope','RegisterService','$mdToast','$mdDialog',function($scope,$http,$rootScope,RegisterService,$mdToast,$mdDialog){

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
				$http.get('http://52.221.57.201/dev/public/api_master_plandetails').then(function(response){
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
	  			$http.post('http://52.221.57.201/dev/public/registration_store',data).then(function(response){
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
				});
	  		}
		}
		else
	  	{
	  		console.log("exist");
	  		window.location = '#/oops';
	  	}
		

}]);


DealerApp.controller('finalStepCtrl',['$scope','$http','$rootScope','RegisterService','$mdDialog','$mdToast',function($scope,$http,$rootScope,RegisterService,$mdDialog,$mdToast){

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
				  //controller: inputController,
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
	  			$http.post('http://52.221.57.201/dev/public/registration_store',data).then(function(response){
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
				});
	  		}

	  		$scope.ApplyCoupon = function()
	  		{
	  			var data = {'plan_id':$scope.dealerData.plan,'coupancode':$scope.coupon};
	  			console.log(data);
	  			$http.post('http://52.221.57.201/dev/public/doapicoupanexist',data).then(function(response){
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
				});
	  		}

  		}
	  	else
	  	{
	  		console.log("exist");
	  		window.location = '#/oops';
	  	}

}]);

DealerApp.controller('oopsCtrl',['$scope','$http','$rootScope','RegisterService',function($scope,$http,$rootScope,RegisterService){

	setTimeout(function(){ 
			window.location = '#/';
		}, 2000);

}]);

DealerApp.controller('converstionCtrl',['$scope','$http',function($scope,$http){

	console.log("conversation controller");

	/*$scope.loadMore = function(page)
	{
		$scope.converstionMessage = [
		{id:1,message:'hai'},{id:2,message:'ya buddy'},{id:1,message:'how r u'},{id:2,message:'hmmm ya good'},{id:1,message:'aaaaaaaa'},{id:1,message:'how is my new car'},{id:2,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:2,message:'how is my new car'},{id:2,message:'how is my new car'},{id:2,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:1,message:'how is my new car'},{id:2,message:'how is my new car'},{id:2,message:'how is my new car'}
		];
		console.log(123);
	}*/
	//$scope.loadMore();
 	$scope.items = [];
    var counter = 0;
    $scope.currentpage = 1;

	$scope.loadMore = function(page) {
		console.log(page);
        for (var i = 0; i < 5; i++) {
            $scope.items.unshift({id: counter});
            counter += 10;
        }
    };
 

    $scope.nextPage = function()
    {
    	$scope.currentpage +=1;
    	$scope.loadMore($scope.currentpage);
    }
   	$scope.nextPage();
    setInterval(function() {
  	console.log($scope.currentpage);
  	$scope.loadMore($scope.currentpage);
	}, 2000);

}]);

 DealerApp.directive('whenScrolled', ['$timeout', function($timeout) {
    return function(scope, elm, attr) {
        var raw = elm[0];
        
        $timeout(function() {
            raw.scrollTop = raw.scrollHeight;          
        });         
        
        elm.bind('scroll', function() {
            if (raw.scrollTop <= 50) { // load more items before you hit the top
                var sh = raw.scrollHeight
                scope.$apply(attr.whenScrolled);
                raw.scrollTop = raw.scrollHeight - sh;
            }
        });
    };
}]);

DealerApp.controller('basicInfoCtrl',['$scope','$http',function($scope,$http){

	console.log("Inventory basic information");

	
}]);

DealerApp.controller('inventoryImageCtrl',['$scope','$http',function($scope,$http){

	console.log("Inventory basic information");

	function handleFileSelect(evt) {
		console.log(evt);
    var files = evt.target.files; // FileList object
	
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
         /* console.log(e.target.result);
          var span = document.createElement('span');
          span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('list').insertBefore(span, null);*/
          console.log(evt.target.id);
          $("#output"+evt.target.id).attr("src",e.target.result);

        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('profilePic').addEventListener('change', handleFileSelect, false);
document.getElementById('fv').addEventListener('change', handleFileSelect, false);
document.getElementById('fw').addEventListener('change', handleFileSelect, false);
document.getElementById('fu').addEventListener('change', handleFileSelect, false);

document.getElementById('rs').addEventListener('change', handleFileSelect, false);
document.getElementById('rq').addEventListener('change', handleFileSelect, false);
document.getElementById('frsiv').addEventListener('change', handleFileSelect, false);
document.getElementById('rear').addEventListener('change', handleFileSelect, false);

document.getElementById('ls').addEventListener('change', handleFileSelect, false);
document.getElementById('lq').addEventListener('change', handleFileSelect, false);
document.getElementById('ec').addEventListener('change', handleFileSelect, false);
document.getElementById('dashboard').addEventListener('change', handleFileSelect, false);

document.getElementById('or').addEventListener('change', handleFileSelect, false);
document.getElementById('abc').addEventListener('change', handleFileSelect, false);
document.getElementById('fdt').addEventListener('change', handleFileSelect, false);
document.getElementById('frt').addEventListener('change', handleFileSelect, false);

document.getElementById('rrt').addEventListener('change', handleFileSelect, false);
document.getElementById('boot').addEventListener('change', handleFileSelect, false);
document.getElementById('flt').addEventListener('change', handleFileSelect, false);
document.getElementById('ordr').addEventListener('change', handleFileSelect, false);

$scope.removeimge = function(id)
{
    var file = document.getElementById(id);
    file.value = file.defaultValue;
    $("#output"+id).attr("src",'images/compare.jpg');
}



}]);

DealerApp.controller('inventoryDocumentCtrl',['$scope','$http',function($scope,$http){

	console.log("Inventory document information");


	function handleFileSelect(evt) {
		console.log(evt.target.files);
    var files = evt.target.files[0].name; // FileList object
    $("#output"+evt.target.id).html('You Choosed : '+files);
	
    
  }

document.getElementById('regCer').addEventListener('change', handleFileSelect, false);
document.getElementById('Insurance').addEventListener('change', handleFileSelect, false);
document.getElementById('rto').addEventListener('change', handleFileSelect, false);
document.getElementById('fc').addEventListener('change', handleFileSelect, false);
document.getElementById('noc').addEventListener('change', handleFileSelect, false);
document.getElementById('pd').addEventListener('change', handleFileSelect, false);

$scope.removeDoc = function(id,fileName)
{
    var file = document.getElementById(id);
    file.value = file.defaultValue;
    $("#output"+id).html('Choose '+fileName);
}



	
}]);


DealerApp.controller('pricingInfoCtrl',['$scope','$http',function($scope,$http){

	console.log("Inventory pricing information");

	$scope.started = false;
	var fromDate = new Date();
  	var isOpen = false;

	$scope.testDrive = function()
	{
		if($scope.started == false)
		{	
			$scope.started = true;

		}
		else
		{
			$scope.started = false;
			$scope.AtDealerpoint = false;
			$scope.AtDoorstep = false;
		}
		console.log($scope.started);
	}

$scope.expenseRow = [];
row = 0
	$scope.dynamicExpence = function()
	{
		$scope.expenseRow.push({'id':row});
		row++;
	}
	$scope.dynamicExpence();

	$scope.removeExpence = function(position)
	{
		$scope.expenseRow.splice(1,position);
	}
	
}]);

DealerApp.filter('checkFile', function () {
    return function (data) {        
          
       
    	console.log(data.message);
		if (data.message.match(/.(jpg|jpeg|png|gif)$/i))
		{
			console.log(1);
			return true;
		}
		else
		{
			console.log(2);
			return false;
		}
    	


       	
    }
});

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

DealerApp.directive('usernameValidator', function($q, $timeout, $http) {
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
	  			$http.post('http://52.221.57.201/dev/public/doapiemailidexist',emailData).then(function(response){
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


DealerApp.directive('noValidator', function($q, $timeout, $http) {
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
	  			$http.post('http://52.221.57.201/dev/public/doapicontactexist',mobileData).then(function(response){
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


DealerApp.controller('DemoCtrl',['$timeout', '$q', '$log',function($timeout, $q, $log){
    var self = this;

    self.simulateQuery = false;
    self.isDisabled    = false;

    // list of `state` value/display objects
    self.states        = loadAll();
    self.querySearch   = querySearch;
    self.selectedItemChange = selectedItemChange;
    self.searchTextChange   = searchTextChange;

    self.newState = newState;

    function newState(state) {
      alert("Sorry! You'll need to create a Constitution for " + state + " first!");
    }

    // ******************************
    // Internal methods
    // ******************************

    /**
     * Search for states... use $timeout to simulate
     * remote dataservice call.
     */
    function querySearch (query) {
      var results = query ? self.states.filter( createFilterFor(query) ) : self.states,
          deferred;
      if (self.simulateQuery) {
        deferred = $q.defer();
        $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
        return deferred.promise;
      } else {
        return results;
      }
    }

    function searchTextChange(text) {
      $log.info('Text changed to ' + text);
    }

    function selectedItemChange(item) {
      $log.info('Item changed to ' + JSON.stringify(item));
    }

    /**
     * Build `states` list of key/value pairs
     */
    function loadAll() {
      var allStates = 'Alabama, Alaska, Arizona, Arkansas, California, Colorado, Connecticut, Delaware,\
              Florida, Georgia, Hawaii, Idaho, Illinois, Indiana, Iowa, Kansas, Kentucky, Louisiana,\
              Maine, Maryland, Massachusetts, Michigan, Minnesota, Mississippi, Missouri, Montana,\
              Nebraska, Nevada, New Hampshire, New Jersey, New Mexico, New York, North Carolina,\
              North Dakota, Ohio, Oklahoma, Oregon, Pennsylvania, Rhode Island, South Carolina,\
              South Dakota, Tennessee, Texas, Utah, Vermont, Virginia, Washington, West Virginia,\
              Wisconsin, Wyoming';

            //  var allStates = [{name:'Alabama',id:1},{name:'antartica',id:2},{name:'America',id:3}];

      return allStates.split(/, +/g).map( function (state) {
        return {
          value: state.toLowerCase(),
          display: state
        };
      });
    }

    /**
     * Create filter function for a query string
     */
    function createFilterFor(query) {
      var lowercaseQuery = angular.lowercase(query);

      return function filterFn(state) {
        return (state.value.indexOf(lowercaseQuery) === 0);
      };

    }
}]);

DealerApp.controller('demoDialog',['$scope','$mdDialog',function($scope,$mdDialog){

	
	$scope.close = function()
	{
		$mdDialog.hide();
	}

}]);


/*dialog controller*/

DealerApp.controller('sendMessageDealerCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','items', '$mdToast',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, items, $mdToast){

	console.log(items);
	$scope.ownerDetails = items[0];
	$scope.dName = $scope.ownerDetails.dm['Car Owner Name'];
	$scope.email = $scope.ownerDetails.dm['Car Owner Email'];


	$scope.close = function()
	{
		$mdDialog.hide();
	}

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



	$scope.sendMessage = function()
	{
		$scope.loader = true;
		var data = {'session_user_id':$scope.ownerDetails.sid,'car_id':$scope.ownerDetails.carId,'make_model_variant':$scope.ownerDetails.variant,'contact_dealer_name':$scope.dName,'contact_dealer_mailid':$scope.email,'contact_dealer_message':$scope.message,'dealer_id':$scope.ownerDetails.dealerId};
		console.log(data);
		$http.post('http://52.221.57.201/dev/public/api_domessage_send',data).then(function(response){
			console.log(response.data);
			//alert(response.data.message);
			var pinTo = $scope.getToastPosition();
		    $mdToast.show(
		      $mdToast.simple()
		        .textContent(response.data.message)
		        .position(pinTo )
		        .hideDelay(2000)
		    );
		    $mdDialog.hide();
			$scope.loader = false;
		},function(response){
			console.log('Service Error');
		});
	}

}]);

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


DealerApp.controller('dealerInfoCtrl',['$scope','$mdDialog','items', '$http', '$mdToast',function($scope,$mdDialog,items, $http, $mdToast){

	console.log(items);
	$scope.ownerDetails = items[0];
	/*$scope.ownerDetails.testdrive_dealerpoint=1;
	$scope.ownerDetails.testdrive_doorstep=0;*/


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

	if(($scope.ownerDetails.testdrive_dealerpoint==1 && $scope.ownerDetails.testdrive_doorstep==1) )
	{
		$scope.testDriveDS = 0;
		//$scope.testDriveDP = false;
	}
	else if($scope.ownerDetails.testdrive_dealerpoint==1)
	{
		$scope.testDriveDS = 'doorstep';
		//$scope.testDriveDP = false;
	}
	else if($scope.ownerDetails.testdrive_doorstep==1)
	{
		$scope.testDriveDS = 'dealerpoint';
		//$scope.testDriveDP = true;
	}

	$scope.address = '';
	$scope.applyTestDrive = function()
	{
		$scope.emptyFlag = true;
		if ($scope.testDriveDS=='doorstep') {
			if($scope.address!='')
			{
				var data = {'session_user_id':$scope.ownerDetails.sid,'car_id':$scope.ownerDetails.carId,'make_model_variant':$scope.ownerDetails.variant,'contact_dealer_message':$scope.address,'dealer_id':$scope.ownerDetails.dealerId,'test_drive':$scope.testDriveDS};
				console.log('1');
			}
			else
			{
				console.log('2');
				$scope.emptyFlag = false;
			}
		}
		else if ($scope.testDriveDS=='dealerpoint')
		{
			var data = {'session_user_id':$scope.ownerDetails.sid,'car_id':$scope.ownerDetails.carId,'make_model_variant':$scope.ownerDetails.variant,'contact_dealer_message':'','dealer_id':$scope.ownerDetails.dealerId,'test_drive':$scope.testDriveDS};
		}
		console.log($scope.emptyFlag);
		if($scope.emptyFlag == true)
		{
	    	console.log(data);
	    	$http.post('http://52.221.57.201/dev/public/api_dotestdrive_send',data).then(function(response){
				console.log(response.data);
				var pinTo = $scope.getToastPosition();
			    $mdToast.show(
			      $mdToast.simple()
			        .textContent(response.data.message)
			        .position(pinTo )
			        .hideDelay(2000)
			    );
			    $mdDialog.hide();
			},function(response){
				console.log('Service Error');
			});
    	}
    	else
    	{
    		$scope.errorFlag = "Pls, Enter Address";
    	}
    	
	}	


	$scope.showTabDialog = function(ev,page,ctrl) {
  		console.log($scope.cities);

		$mdDialog.show({
			templateUrl: page,
			controller: ctrl,
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			escapeToClose: false,
			animate: 'full-screen-dialog',
			locals: {
	           items: 'hai'
	         }
			
		})
		.then(function(answer) {
		  $scope.status = 'You said the information was "' + answer + '".';
		}, function() {
		  $scope.status = 'You cancelled the dialog.';
		});
  	};


	$scope.close = function()
	{
		$mdDialog.hide();
	}

}]);

DealerApp.controller('mapCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http){

	console.log('mapctrl');
	$scope.close = function()
	{
		$mdDialog.hide();
	}

}]);

/*car view details controller*/
DealerApp.controller('carviewCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http){

	$scope.project = {
				  comments: 'Comments',    
			   };

   	$scope.status = '  ';
  	$scope.customFullscreen = false;

  	$scope.loader = true;

  	sId = $routeParams.sId;
	cId = $routeParams.cId;

	$scope.close = function()
	{
		$mdDialog.hide();
	}
	$scope.ownerDetails = [];
    $scope.carView = function()
    {
    	var data = {'session_user_id':sId,'car_id':cId}
    	console.log(data);
    	$http.post('http://52.221.57.201/dev/public/api_view_cardetails',data).then(function(response){
			console.log(response.data);
			$scope.carDetails = response.data; 
			if($scope.carDetails.carimagesdetails.length!=0)
			{
				$scope.imageDataJoin = $scope.carDetails.carimagesdetails[0].image_url.join(',');
				$scope.imageData = $scope.imageDataJoin.split(',');
				if($scope.carDetails.carimagesdetails[0].video_url.length!=0)
				{
					$scope.videoUrl = $scope.carDetails.carimagesdetails[0].video_url[0];
				}
				
			}
			$scope.loader = false;
			make_model_variant = $scope.carDetails.carmodeldetails[0].Make+" "+$scope.carDetails.carmodeldetails[0].Model+" "+$scope.carDetails.carmodeldetails[0].Variant;
			$scope.ownerDetails.push({'dm':$scope.carDetails.dealermessage[0],'df':$scope.carDetails.dealerinfo[0],'sid':sId,'carId':cId,'variant':make_model_variant,'dealerId':$scope.carDetails.carmodeldetails[0].dealer_id});
				console.log($scope.ownerDetails);
		},function(response){
			console.log('Service Error');
		});
    }

    $scope.carView();
		
			  
  	$scope.showTabDialog = function(ev,page,ctrl) {
  		//console.log(ctrl)
		$mdDialog.show({
			templateUrl: page,
			controller: ctrl,
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			escapeToClose: false,
			animate: 'full-screen-dialog',
			locals: {
	           items: $scope.ownerDetails
	         }
			
		})
		.then(function(answer) {
		  $scope.status = 'You said the information was "' + answer + '".';
		}, function() {
		  $scope.status = 'You cancelled the dialog.';
		});
  	};

  	 $scope.colors = ["#fc0003", "#f70008", "#f2000d", "#ed0012", "#e80017", "#e3001c", "#de0021", "#d90026", "#d4002b", "#cf0030", "#c90036", "#c4003b", "#bf0040", "#ba0045", "#b5004a", "#b0004f", "#ab0054", "#a60059", "#a1005e", "#9c0063", "#960069", "#91006e", "#8c0073", "#870078", "#82007d", "#7d0082", "#780087", "#73008c", "#6e0091", "#690096", "#63009c", "#5e00a1", "#5900a6", "#5400ab", "#4f00b0", "#4a00b5", "#4500ba", "#4000bf", "#3b00c4", "#3600c9", "#3000cf", "#2b00d4", "#2600d9", "#2100de", "#1c00e3", "#1700e8", "#1200ed", "#0d00f2", "#0800f7", "#0300fc"];
            function getSlide(target, style) {
                var i = target.length;
                return {
                    id: (i + 1),
                    label: 'slide #' + (i + 1),
                    img: 'http://lorempixel.com/450/300/' + style + '/' + ((i + 1) % 10) ,
                    color: $scope.colors[ (i*10) % $scope.colors.length],
                    odd: (i % 2 === 0)
                };
            }
            function addSlide(target, style) {
                target.push(getSlide(target, style));
            };
            $scope.carouselIndex = 3;
            $scope.carouselIndex2 = 0;
            $scope.carouselIndex2 = 1;
            $scope.carouselIndex3 = 5;
            $scope.carouselIndex4 = 5;
            function addSlides(target, style, qty) {
                for (var i=0; i < qty; i++) {
                    addSlide(target, style);
                }
            }
            // 1st ngRepeat demo
            $scope.slides = [];
            addSlides($scope.slides, 'sports', 50);
            // 2nd ngRepeat demo
            $scope.slides2 = [];
            addSlides($scope.slides2, 'sports', 10);
            // 3rd ngRepeat demo
            $scope.slides3 = [];
            addSlides($scope.slides3, 'people', 50);
            // 4th ngRepeat demo
            $scope.slides4 = [];
            addSlides($scope.slides4, 'city', 50);
            // 5th ngRepeat demo
            $scope.slides6 = [];
            $scope.carouselIndex6 = 0;
            addSlides($scope.slides6, 'sports', 10);
            $scope.addSlide = function(at) {
                if(at==='head') {
                    $scope.slides6.unshift(getSlide($scope.slides6, 'people'));
                } else {
                    $scope.slides6.push(getSlide($scope.slides6, 'people'));
                }
            }
            
            // End to End swiping
            // load 130 images in main javascript container
            var slideImages = [];
            addSlides(slideImages, 'sports', 10);
            addSlides(slideImages, 'people', 10);
            addSlides(slideImages, 'city', 10);
            addSlides(slideImages, 'abstract', 10);
            addSlides(slideImages, 'nature', 10);
            addSlides(slideImages, 'food', 10);
            addSlides(slideImages, 'transport', 10);
            addSlides(slideImages, 'animals', 10);
            addSlides(slideImages, 'business', 10);
            addSlides(slideImages, 'nightlife', 10);
            addSlides(slideImages, 'cats', 10);
            addSlides(slideImages, 'fashion', 10);
            addSlides(slideImages, 'technics', 10);
            $scope.totalimg = slideImages.length;
            $scope.galleryNumber = 1;
            console.log($scope.galleryNumber);
            
            function getImage(target) {
                var i = target.length
                    , p = (($scope.galleryNumber-1)*$scope.setOfImagesToShow)+i;
                console.log("i=" + i + "--" + p);
                
                return slideImages[p];
            }
            function addImages(target, qty) {
                                
                for (var i=0; i < qty; i++) {
                    addImage(target);
                }
            }
            
            function addImage(target) {
                target.push(getImage(target));
            }
            
            $scope.slides7 = [];
            $scope.carouselIndex7 = 0;
            $scope.setOfImagesToShow = 3;
            addImages($scope.slides7, $scope.setOfImagesToShow);
            $scope.loadNextImages = function() {
                console.log("loading Next images");
                if (slideImages[slideImages.length-1].id !== $scope.slides7[$scope.slides7.length-1].id) {
                    // Go to next set of images if exist
                    $scope.slides7 = [];
                    $scope.carouselIndex7 = 0;
                    ++$scope.galleryNumber;
                    addImages($scope.slides7, $scope.setOfImagesToShow);
                } else {
                    // Go to first set of images if not exist
                    $scope.galleryNumber = 1;
                    $scope.slides7 = [];
                    $scope.carouselIndex7 = 0;
                    addImages($scope.slides7, $scope.setOfImagesToShow);
                }
            }
            $scope.loadPreviousImages = function() {
                if (slideImages[0].id !== $scope.slides7[0].id) {
                    // Go to previous set of images if exist
                    $scope.slides7 = [];
                    $scope.carouselIndex7 = 0;
                    --$scope.galleryNumber;
                    addImages($scope.slides7, $scope.setOfImagesToShow);
                } else {
                    // Go to last set of images if not exist
                    console.log("slideimageslength: " + slideImages.length + ", " + slideImages.length-1 / $scope.setOfImagesToShow);
                    // console.log("slideimageslength: " + slideImages.length );
                    $scope.galleryNumber = slideImages.length / $scope.setOfImagesToShow;
                    $scope.slides7 = [];
                    $scope.carouselIndex7 = 0;
                    addImages($scope.slides7, $scope.setOfImagesToShow);
                    console.log("no images left");
                }
                
            }


  	
}]);