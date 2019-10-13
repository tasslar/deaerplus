
/*dialog controller*/

DealerApp.controller('pageNotFoundCtrl',['$scope','$http','apiurl',function($scope,$http,apiurl){

  $scope.backtoBasic = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }

}]);

DealerApp.controller('sendMessageDealerCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','items', '$mdToast', 'apiurl',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, items, $mdToast, apiurl){

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
		$http.post(apiurl+'api_domessage_send',data).then(function(response){
			console.log(response.data);
			var pinTo = $scope.getToastPosition();
		    $mdToast.show(
		      $mdToast.simple()
		        .textContent(response.data.message)
		        .position(pinTo )
		        .hideDelay(2000)
		    );
		    $mdDialog.hide();
			$scope.loader = false;
			//alert(response.data.message);
			
		},function(response){
			console.log('Service Error');
			$scope.loader = false;
			var pinTo = $scope.getToastPosition();
		    $mdToast.show(
		      $mdToast.simple()
		        .textContent('Unable to Reach Server. Please Try Again Later...')
		        .position(pinTo )
		        .hideDelay(2000)
		    );
		    $mdDialog.hide();
		});
	}

}]);

DealerApp.controller('fundingCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','items', '$mdToast', 'apiurl',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, items, $mdToast, apiurl){

	console.log(items);
	$scope.ownerDetails = items[0];

	if($scope.ownerDetails.fundingdetails.result==0)
	{
		$scope.dsName = $scope.ownerDetails.currentdealerdetails['dealershipname'];
		$scope.dname = $scope.ownerDetails.currentdealerdetails['dealername'];
		$scope.emailId = $scope.ownerDetails.currentdealerdetails['dealeremailid'];
		$scope.phNo = $scope.ownerDetails.currentdealerdetails['dealermobile'];
		$scope.amount = $scope.ownerDetails.carmodeldetails['Price'];
		$scope.date = $scope.ownerDetails.currentdealerdetails['todaydate'];
		$scope.city = $scope.ownerDetails.currentdealerdetails['dealercity'];
	}


	//$scope.emailFrom = $scope.ownerDetails.currentdealerdetails['dealeremailid'];


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



	$scope.submitFunding = function()
	{
		if($scope.amount!=null)
		{
			if(parseInt($scope.amount)!=0 || $scope.amount!='' )
			{
				if($scope.ownerDetails.carmodeldetails['Price']>=$scope.amount)
				{	
					$scope.loader = true;
					var data = {'session_user_id':$routeParams.sId,'listingid':$scope.ownerDetails.carmodeldetails['listing_id'],'dealershipname':$scope.dsName,'dealername':$scope.dname,'emailid':$scope.emailId,'mobilenumber':$scope.phNo,'date':$scope.date,'place':$scope.city,'fundingamount':$scope.amount,'make':$scope.ownerDetails.carmodeldetails['Make'],'model_name':$scope.ownerDetails.carmodeldetails['Model'],'variant':$scope.ownerDetails.carmodeldetails['Variant'],'ownerid':$scope.ownerDetails.carmodeldetails['dealer_id']};
					console.log(data);
					$http.post(apiurl+'doApibuyfundingregister',data).then(function(response){
						console.log(response.data);
						//alert(response.data.message);
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
						$scope.loader = false;
						var pinTo = $scope.getToastPosition();
					    $mdToast.show(
					      $mdToast.simple()
					        .textContent('Unable to Reach Server. Please Try Again Later...')
					        .position(pinTo )
					        .hideDelay(2000)
					    );
					    $mdDialog.hide();
					});
				}
				else
				{
					var pinTo = $scope.getToastPosition();
				    $mdToast.show(
				      $mdToast.simple()
				        .textContent('Please enter value less than or equal to Rs.'+$scope.ownerDetails.carmodeldetails['Price'])
				        .position(pinTo )
				        .hideDelay(2000)
				    );
				}
			}
			else
			{
				var pinTo = $scope.getToastPosition();
			    $mdToast.show(
			      $mdToast.simple()
			        .textContent('Enter Valid Amount')
			        .position(pinTo )
			        .hideDelay(2000)
			    );
			}
		}
		else
		{
			var pinTo = $scope.getToastPosition();
		    $mdToast.show(
		      $mdToast.simple()
		        .textContent('Enter Valid Amount')
		        .position(pinTo )
		        .hideDelay(2000)
		    );
		}
	}

}]);

DealerApp.controller('shareCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','items', '$mdToast', 'apiurl',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, items, $mdToast, apiurl){

	console.log(items);
	$scope.ownerDetails = items[0];
	$scope.emailFrom = $scope.ownerDetails.currentdealerdetails['dealeremailid'];


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



	$scope.shareMessage = function()
	{
		$scope.loader = true;
		var data = {'session_user_id':$routeParams.sId,'car_id':$routeParams.cId,'mailto':$scope.emailTo,'mailfrom':$scope.emailFrom,'comments':$scope.comments};
		console.log(data);
		$http.post('http://app.dealerplus.in/doApiCardetailshare',data).then(function(response){
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
			$scope.loader = false;
			var pinTo = $scope.getToastPosition();
		    $mdToast.show(
		      $mdToast.simple()
		        .textContent('Unable to Reach Server. Please Try Again Later...')
		        .position(pinTo )
		        .hideDelay(2000)
		    );
		    $mdDialog.hide();
		});
	}

}]);


DealerApp.controller('testDriveCtrl',['$scope','$mdDialog', '$http', '$mdToast', '$interval', 'mapservice', 'testDriveService', 'apiurl',function($scope,$mdDialog, $http, $mdToast, $interval, mapservice, testDriveService, apiurl){

	console.log(testDriveService.testDriveData);
	$scope.ownerDetails = testDriveService.testDriveData[0];
	/*$scope.ownerDetails.testdrive_dealerpoint=1;
	$scope.ownerDetails.testdrive_doorstep=0;*/

	$scope.back = function()
	{
		window.location = '#/carview/'+$scope.ownerDetails.sid+'/'+$scope.ownerDetails.carId+'/'+$scope.ownerDetails.pageId;
	}

	$scope.phoneDialler = function(phno)
    {
    	
    	document.location.href = "tel:"+phno;
    	//console.log("tel:"+$scope.phnoData);
    }

    $scope.testDriveDS = 'doorstep';


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
	    	$http.post(apiurl+'api_dotestdrive_send',data).then(function(response){
				console.log(response.data);
				var pinTo = $scope.getToastPosition();
			    $mdToast.show(
			      $mdToast.simple()
			        .textContent(response.data.message)
			        .position('bottom')
			        .hideDelay(2000)
			    );
			    $scope.back(); 
				
			},function(response){
				console.log('Service Error');
				var pinTo = $scope.getToastPosition();
			    $mdToast.show(
			      $mdToast.simple()
			        .textContent('Server Under Maintanence. Try Again Later')
			        .position('bottom')
			        .hideDelay(2000)
			    );
			    $scope.back(); 
			});
    	}
    	else
    	{
    		$scope.errorFlag = "Pls, Enter Address";
    		var pinTo = $scope.getToastPosition();
			    $mdToast.show(
			      $mdToast.simple()
			        .textContent('Please enter the address')
			        .position('bottom')
			        .hideDelay(2000)
			    );
    	}
    	
	}	


	$scope.showTabDialog = function(ev,page,ctrl) {
  		console.log($scope.cities);

		$mdDialog.show({
			templateUrl: page,
			controller: ctrl,
			//parent: angular.element(document.body),
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
		  console.log('functin triggered 1');
		}, function() {
		  $scope.status = 'You cancelled the dialog.';
		  console.log('functin triggered 2');
		});
  	};

  	function getaddress(lat,lon)
	{
		//console.log(lat+" "+lon);
		$http.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lon+'&sensor=true').then(function mySucces(response){

			console.log(response.data);
			//$scope.map_address = response.data.results[0].formatted_address;

		});

	}

	 $scope.mapdata = mapservice.mapData;
	 console.log($scope.mapdata);
 	function loadMapData()
 	{
		 if($scope.mapdata=='')
		 {
		 	$scope.address = '';
		 }
		 else
		 {
		 	$scope.address = $scope.mapdata.address;
		 }
	}
	loadMapData();

	 $scope.testDrive = function()
	{
		
		window.location = '#/newmap';
	}


	$scope.close = function()
	{
		$mdDialog.hide();
	}

	$scope.clearAddress = function()
	{
		mapservice.mapData = [];
		$scope.mapdata = mapservice.mapData;
		loadMapData();
		console.log($scope.mapdata);
	}

	

}]);


DealerApp.controller('dealerInfoCtrl',['$scope','$mdDialog','items', '$http', '$mdToast', '$interval', 'mapservice', 'apiurl',function($scope,$mdDialog,items, $http, $mdToast, $interval, mapservice, apiurl){

	console.log(items);
	$scope.ownerDetails = items[0];
	/*$scope.ownerDetails.testdrive_dealerpoint=1;
	$scope.ownerDetails.testdrive_doorstep=0;*/

	$scope.phoneDialler = function(phno)
    {
    	
    	document.location.href = "tel:"+phno;
    	//console.log("tel:"+$scope.phnoData);
    }


	$scope.close = function()
	{
		$mdDialog.hide();
	}


 	$scope.$watch('$viewContentLoaded', function(){
 		if($scope.ownerDetails.df['Dealer Address']=='')
 		{
 			addressData = $scope.ownerDetails.carmodeldetails.Location;
 		}
 		else
 		{
 			addressData = $scope.ownerDetails.df['Dealer Address'];
 		}
    	
    	codeAddress(addressData);

 	 });

	 var geocoder;
	var map;
	var marker;

	codeAddress = function (addr) {
	    geocoder = new google.maps.Geocoder();
	  
	  var address = addr;
	  geocoder.geocode( { 'address': address}, function(results, status) {

	    if (status == google.maps.GeocoderStatus.OK) {

	      map = new google.maps.Map(document.getElementById('mapCanvas'), {
	    zoom: 16,
	            streetViewControl: false,
	          mapTypeControlOptions: {
	        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
	              mapTypeIds:[google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP] 
	    },
	    center: results[0].geometry.location,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	      nativeLat = results[0].geometry.location.lat();
	      nativeLng = results[0].geometry.location.lng();
	      map.setCenter(results[0].geometry.location);
	      marker = new google.maps.Marker({
	          map: map,
	          position: results[0].geometry.location,
	          draggable: true,
	          title: 'My Title'
	      });
	     // updateMarkerPosition(results[0].geometry.location);
	     // geocodePosition(results[0].geometry.location);
	        
	      // Add dragging event listeners.
	  /*google.maps.event.addListener(marker, 'dragstart', function() {
	    updateMarkerAddress('Dragging...');
	  });
	      
	  google.maps.event.addListener(marker, 'drag', function() {
	    updateMarkerStatus('Dragging...');
	    updateMarkerPosition(marker.getPosition());
	  });
	  
	  google.maps.event.addListener(marker, 'dragend', function() {
	    updateMarkerStatus('Drag ended');
	    geocodePosition(marker.getPosition());
	      map.panTo(marker.getPosition()); 
	  });
	  
	  google.maps.event.addListener(map, 'click', function(e) {
	    updateMarkerPosition(e.latLng);
	    geocodePosition(marker.getPosition());
	    marker.setPosition(e.latLng);
	  map.panTo(marker.getPosition()); 
	  });*/ 
	  
	    } else {
	      console.log('Geocode was not successful for the following reason: ' + status);
	    }
	  });
	}

	$scope.getDirections = function()
	{
		console.log(1);
		window.location = 'http://maps.google.com/?q=-37.866963,144.980615';
	}

	$scope.getAndroidMap = function()
	{
		var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
		console.log(iOS);
		if(iOS == true)
		{
			window.location = 'http://maps.google.com/';
		}
		else
		{
			var addressLongLat = nativeLat+','+nativeLng+'?q='+nativeLat+','+nativeLng;
			window.open("geo:"+addressLongLat);
			//window.location = 'http://maps.google.com/maps?saddr=43.0054446,-87.9678884&daddr=42.9257104,-88.0508355';
		}
		/*var addressLongLat = nativeLat+','+nativeLng;
		window.open("geo:"+addressLongLat);*/
		//window.open("http://maps.apple.com/?q="+addressLongLat, '_system');
	}

	
	/*function geocodePosition(pos) {
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
	      updateMarkerAddress(responses[0].formatted_address);
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.');
	    }
	  });
	}*/

	/*function updateMarkerStatus(str) {
	  document.getElementById('markerStatus').innerHTML = str;
	}

	function updateMarkerPosition(latLng) {
	  document.getElementById('info').innerHTML = [
	    latLng.lat(),
	    latLng.lng()
	  ].join(', ');
	}

	function updateMarkerAddress(str) {
	  document.getElementById('address').innerHTML = str;
	}*/


}]);

/*DealerApp.directive('googleplace', function() {
    return {
        require: 'ngModel',
        scope:{
        myModel: '=ngModel'
    	},
        link: function(scope, element, attrs, model) {

			var mapOptions;
	      	var googleMap;
	      	var searchMarker;
	      	var searchLatLng;


	        var options = {
	            types: [],
	            componentRestrictions: {}
	        };
	        scope.gPlace = new google.maps.places.Autocomplete(element[0], options);


         	searchMarker =  scope.gPlace;


 		google.maps.event.addListener(searchMarker, 'place_changed', function() {
                scope.$apply(function() {
                	
               	var place = searchMarker.getPlace();
				latitude = place.geometry.location.lat();
				longitude = place.geometry.location.lng();
				var Address = latitude+','+longitude;
				model.$setViewValue(Address);
				console.log(Address);
                });
            });
        }
    };
});*/

DealerApp.controller('testMapCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','mapservice',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, mapservice){

	console.log('mapctrl');

	
	$scope.fun = function()
	{
		console.log('hai');
		var mapOptions;
	      	var googleMap;
	      	var searchMarker;
	      	var searchLatLng;


	        var options = {
	            types: [],
	            componentRestrictions: {}
	        };

	        element = angular.element(document.querySelector(".newMap"));
	        $scope.gPlace = new google.maps.places.Autocomplete(element[0], options);


         	searchMarker =  $scope.gPlace;


 		google.maps.event.addListener(searchMarker, 'place_changed', function() {
                $scope.$apply(function() {
                	
               	var place = searchMarker.getPlace();
               console.log(place.formatted_address);
				/*latitude = place.geometry.location.lat();
				longitude = place.geometry.location.lng();*/
				//var Address = latitude+','+longitude;
				codeAddress(place.formatted_address);
				/*mapFun(latitude,longitude);
				updatePosition(latitude, longitude);*/
				//console.log(Address);
                });
            });
	}

	var probablyPhone = ((/iphone|android|ie|blackberry|fennec/).test(navigator.userAgent.toLowerCase()) && 'ontouchstart' in document.documentElement);

	$scope.$watch('address', function(){
    	
    	$scope.fun();

 	 });


	$scope.$watch('$viewContentLoaded', function(){
    	
    	codeAddress('chennai');

 	 });

	 var geocoder;
		var map;
		var marker;

		codeAddress = function (addr) {
		    geocoder = new google.maps.Geocoder();
		  
		  var address = addr;
		  geocoder.geocode( { 'address': address}, function(results, status) {
		    if (status == google.maps.GeocoderStatus.OK) {
		      map = new google.maps.Map(document.getElementById('mapCanvas'), {
		    zoom: 16,
		            streetViewControl: false,
		          mapTypeControlOptions: {
		        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
		              mapTypeIds:[google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP] 
		    },
		    center: results[0].geometry.location,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  });
		      map.setCenter(results[0].geometry.location);
		      marker = new google.maps.Marker({
		          map: map,
		          position: results[0].geometry.location,
		          draggable: true,
		          title: 'My Title'
		      });
		      updateMarkerPosition(results[0].geometry.location);
		      geocodePosition(results[0].geometry.location);
		        
		      // Add dragging event listeners.
		  google.maps.event.addListener(marker, 'dragstart', function() {
		    updateMarkerAddress('Dragging...');
		  });
		      
		  google.maps.event.addListener(marker, 'drag', function() {
		    updateMarkerStatus('Dragging...');
		    updateMarkerPosition(marker.getPosition());
		  });
		  
		  google.maps.event.addListener(marker, 'dragend', function() {
		    updateMarkerStatus('Drag ended');
		    geocodePosition(marker.getPosition());
		      map.panTo(marker.getPosition()); 
		  });
		  
		  google.maps.event.addListener(map, 'click', function(e) {
		    updateMarkerPosition(e.latLng);
		    geocodePosition(marker.getPosition());
		    marker.setPosition(e.latLng);
		  map.panTo(marker.getPosition()); 
		  }); 
		  
		    } else {
		      console.log('Geocode was not successful for the following reason: ' + status);
		    }
		  });
		}

		function geocodePosition(pos) {
		  geocoder.geocode({
		    latLng: pos
		  }, function(responses) {
		    if (responses && responses.length > 0) {
		      updateMarkerAddress(responses[0].formatted_address);
		    } else {
		      updateMarkerAddress('Cannot determine address at this location.');
		    }
		  });
		}

		function updateMarkerStatus(str) {
		  document.getElementById('markerStatus').innerHTML = str;
		}

		function updateMarkerPosition(latLng) {
		  document.getElementById('info').innerHTML = [
		    latLng.lat(),
		    latLng.lng()
		  ].join(', ');
		}

		function updateMarkerAddress(str) {
		  document.getElementById('address').innerHTML = str;
		}







}]);

DealerApp.controller('newmapCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','mapservice','$mdToast',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, mapservice, $mdToast){

	$scope.mapdata = {};

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

	$scope.back = function()
	{
		console.log($scope.address);
		if($scope.address != "")
		{
			console.log(1);
			mapservice.mapData = $scope.mapdata;
			window.location = '#/testdrive';
		}
		else
		{
			console.log(2);
			var pinTo = $scope.getToastPosition();
		    $mdToast.show(
		      $mdToast.simple()
		        .textContent('Please Choose a Location')
		        .position('bottom')
		        .hideDelay(2000)
		    );
		}
	}

	console.log(mapservice.mapData);

	/*if(mapservice.mapData.length==0)
	{
		$scope.previousMapLoc = '';
		$scope.previousLat = '';
   		$scope.previousLng = '';
		
	}
	else
	{
		$scope.previousMapLoc = mapservice.mapData.address;
		$scope.previousLat = mapservice.mapData.lat;
		$scope.previousLng = mapservice.mapData.lng;
	}*/

	$scope.discardMap = function()
	{
		
		window.location = '#/testdrive';
		/*if(mapservice.mapData.length==0)
		{
			mapservice.mapData = '';
			window.location = '#/testdrive';
		}
		else
		{
			mapservice.mapData.address = $scope.previousMapLoc;
			mapservice.mapData.lat = $scope.previousLat;
			mapservice.mapData.lng = $scope.previousLng;
			window.location = '#/testdrive';
		}*/
	}

	$scope.clearAddress = function()
	{
		$scope.address = "";
	}

	$scope.fun = function()
	{
		console.log('hai');
		var mapOptions;
	      	var googleMap;
	      	var searchMarker;
	      	var searchLatLng;


	        var options = {
	            types: [],
	            componentRestrictions: {}
	        };

	        element = angular.element(document.querySelector(".newMap"));
	        $scope.gPlace = new google.maps.places.Autocomplete(element[0], options);


         	searchMarker =  $scope.gPlace;


 		google.maps.event.addListener(searchMarker, 'place_changed', function() {
                $scope.$apply(function() {
                	
               	var place = searchMarker.getPlace();
               console.log(place.formatted_address);
				latitude = place.geometry.location.lat();
				longitude = place.geometry.location.lng();
				//var Address = latitude+','+longitude;
				initMap(latitude,longitude);
				getaddress(latitude,longitude);
				/*mapFun(latitude,longitude);
				updatePosition(latitude, longitude);*/
				//console.log(Address);
                });
            });
	}


	function getaddress(lat,lon)
	{
		//console.log(lat+" "+lon);
		$http.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lon+'&sensor=true').then(function mySucces(response){
			console.log(response.data);
			$scope.address = response.data.results[0].formatted_address;
			$scope.mapdata.lat = lat;
	   		$scope.mapdata.lng = lon;
	   		$scope.mapdata.address = $scope.address;
	   		

		});

	}

	$scope.$watch('address', function(){
    	
    	$scope.fun();

 	 });


	$scope.$watch('$viewContentLoaded', function(){
    	console.log(mapservice.mapData);
    	if (mapservice.mapData.length==0) {
    		console.log(1);
    		//lat = 40.714224;
			//lng = -73.961452;
			lat = 13.067439;
			lng = 80.237617;
			initMap(lat,lng);
			getaddress(lat,lng);
		}
		else
		{
			console.log(2);
			lat = mapservice.mapData.lat;
			lng = mapservice.mapData.lng;
			initMap(lat,lng);
			getaddress(lat,lng);
		}


 	});


	//google.maps.event.addDomListener(window, 'load', initMap);
  	var map = null;
	var marker;


	function initMap(lat,lng) {
	  var mapOptions = {
	    center: new google.maps.LatLng(lat, lng),
	    zoom: 16,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map-canvas"),
	    mapOptions);
	  google.maps.event.addListener(map, 'center_changed', function() {
	    /*document.getElementById('default_latitude').value = map.getCenter().lat();
	    document.getElementById('default_longitude').value = map.getCenter().lng();*/
	    var lati = map.getCenter().lat();
	    var long = map.getCenter().lng();
	    getaddress(lati,long);
	  });
	  $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
	    //do something onclick
	    .click(function() {
	      var that = $(this);
	      if (!that.data('win')) {
	        that.data('win', new google.maps.InfoWindow({
	          content: 'this is the center'
	        }));
	        that.data('win').bindTo('position', map, 'center');
	      }
	      that.data('win').open(map);
	    });
	}




}]);


DealerApp.controller('mapCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http','mapservice', 'apiurl',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, mapservice, apiurl){

	console.log('mapctrl');

	$scope.mapdata = {};
	$scope.fun = function()
	{
		console.log('hai');
		var mapOptions;
	      	var googleMap;
	      	var searchMarker;
	      	var searchLatLng;


	        var options = {
	            types: [],
	            componentRestrictions: {}
	        };

	        element = angular.element(document.querySelector(".newMap"));
	        $scope.gPlace = new google.maps.places.Autocomplete(element[0], options);


         	searchMarker =  $scope.gPlace;


 		google.maps.event.addListener(searchMarker, 'place_changed', function() {
                $scope.$apply(function() {
                	
               	var place = searchMarker.getPlace();
               console.log(place.formatted_address);
				latitude = place.geometry.location.lat();
				longitude = place.geometry.location.lng();
				//var Address = latitude+','+longitude;
				getaddress(latitude,longitude);
				/*mapFun(latitude,longitude);
				updatePosition(latitude, longitude);*/
				//console.log(Address);
                });
            });
	}


	function getaddress(lat,lon)
	{
		//console.log(lat+" "+lon);
		$http.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lon+'&sensor=true').then(function mySucces(response){

			console.log(response.data);
			$scope.map_address = response.data.results[0].formatted_address;
			codeAddress(latitude,longitude);
		});

	}

	$scope.$watch('address', function(){
    	
    	$scope.fun();

 	 });


	$scope.$watch('$viewContentLoaded', function(){
    	
    	
    	if (mapservice.mapData=='') {
    		lat = 40.714224;
			lng = -73.961452;
			codeAddress(lat,lng);
			$scope.map_address = 'chennai';
		}
		else
		{
			lat = mapservice.mapData.lat;
			lng = mapservice.mapData.lng;
			codeAddress(lat,lng);
			$scope.map_address = mapservice.mapData.address;
		}


 	 });

	 	var geocoder;
		var map;
		var marker;

		codeAddress = function (lat,lng) {
		    geocoder = new google.maps.Geocoder();
		  
		  //var address = addr;
		  var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
		  geocoder.geocode( {'location': latlng}, function(results, status) {
		    if (status == google.maps.GeocoderStatus.OK) {
		      map = new google.maps.Map(document.getElementById('mapCanvas'), {
		    zoom: 16,
		            streetViewControl: false,
		          mapTypeControlOptions: {
		        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
		              mapTypeIds:[google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP] 
		    },
		    center: {lat: lat, lng: lng},
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  });
		      //map.setCenter(results[0].geometry.location);
		      marker = new google.maps.Marker({
		          map: map,
		          position: {lat: lat, lng: lng},
		          draggable: false,
		          title: 'My Title'
		      });
		      console.log(results[0].geometry.location);
		      updateMarkerPositionFake(latlng);
		      updateMarkerAddress($scope.map_address);
		        
		      // Add dragging event listeners.
		  /*google.maps.event.addListener(marker, 'dragstart', function() {
		    updateMarkerAddress('Dragging...');
		  });
		      
		  google.maps.event.addListener(marker, 'drag', function() {
		    updateMarkerStatus('Dragging...');
		    updateMarkerPosition(marker.getPosition());
		  });
		  
		  google.maps.event.addListener(marker, 'dragend', function() {
		    updateMarkerStatus('Drag ended');
		    geocodePosition(marker.getPosition());
		      map.panTo(marker.getPosition()); 
		  });*/
		  
		  google.maps.event.addListener(map, 'click', function(e) {
		    updateMarkerPosition(e.latLng);
		    geocodePosition(marker.getPosition());
		    marker.setPosition(e.latLng);
		  map.panTo(marker.getPosition()); 
		  }); 
		  
		    } else {
		      console.log('Geocode was not successful for the following reason: ' + status);
		    }
		  });
		}

		function geocodePosition(pos) {
		  geocoder.geocode({
		    latLng: pos
		  }, function(responses) {
		    if (responses && responses.length > 0) {
		    	console.log(responses[0].formatted_address);
		      updateMarkerAddress(responses[0].formatted_address);
		    } else {
		      updateMarkerAddress('Cannot determine address at this location.');
		    }
		  });
		}

		function updateMarkerStatus(str) {
		  document.getElementById('markerStatus').innerHTML = str;
		}

		function updateMarkerPosition(latLng) {
		  /*document.getElementById('info').innerHTML = [
		    latLng.lat(),
		    latLng.lng()
		  ].join(', ');*/
		  	$scope.mapdata.lat = latLng.lat();
	   		$scope.mapdata.lng = latLng.lng();
	   		console.log(latLng.lat()+","+latLng.lng());
	   		//mapservice.mapData = $scope.mapdata;
	   		
		}

		function updateMarkerPositionFake(latLng) {
		  	$scope.mapdata.lat = latLng.lat;
	   		$scope.mapdata.lng = latLng.lng;
	   		console.log(latLng.lat+","+latLng.lng);
	   		//mapservice.mapData = $scope.mapdata;
	   		
		}

		function updateMarkerAddress(str) {
		  	document.getElementById('address').innerHTML = str;
		  	$scope.mapdata.address = str;
			mapservice.mapData = $scope.mapdata;
			console.log(mapservice.mapData);
		}
	
   /* $scope.$watch('$viewContentLoaded', function(){
    	
    	if (mapservice.mapData=='') {
			lat = -33.013803;
			lng = -71.551498;
		}
		else
		{
			lat = mapservice.mapData.lat;
			lng = mapservice.mapData.lng;
			$scope.map_address = mapservice.mapData.address;
		}
		mapFun(lat,lng);

 	 });

    function mapFun(lat,lng)
    {
    	console.log('content loaded');
		var center = new google.maps.LatLng(lat, lng);
		var result = document.getElementById("mapBox");
		console.log('angular'+result);
		var map = new google.maps.Map(document.getElementById("mapBox"), {
		    zoom: 18,
		    center: center,
		    mapTypeId: google.maps.MapTypeId.HYBRID
		});

		var myMarker = new google.maps.Marker({
		    position: center,
		    draggable: true,
		    map: map
		});

		google.maps.event.addListener(myMarker, 'dragend', function () {
		    map.setCenter(this.getPosition()); // Set map center to marker position
		    updatePosition(this.getPosition().lat(), this.getPosition().lng()); // update position display
		});

		google.maps.event.addListener(map, 'dragend', function () {
		    myMarker.setPosition(this.getCenter()); // set marker position to map center
		    updatePosition(this.getCenter().lat(), this.getCenter().lng()); // update position display
		});

		
    }

    function updatePosition(lat, lng) {
		   // document.getElementById('dragStatus').innerHTML = '<p> Current Lat: ' + lat.toFixed(4) + ' Current Lng: ' + lng.toFixed(4) + '</p>';
		    $http.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=true').then(function mySucces(response){
			console.log(response.data);
			$scope.map_address = response.data.results[0].formatted_address;
			$scope.mapdata = {'lat':lat,'lng':lng,'address':$scope.map_address};
			mapservice.mapData = $scope.mapdata;
			});
		}*/


    sId = $routeParams.sId;
	cId = $routeParams.cId;

	
	$scope.ownerDetails = [];
    $scope.carView = function()
    {
    	var data = {'session_user_id':sId,'car_id':cId}
    	console.log(data);
    	$http.post(apiurl+'api_view_cardetails',data).then(function(response){
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
  		console.log($scope.cities);
  		$mdDialog.hide();
		$mdDialog.show({
			templateUrl: page,
			controller: ctrl,
			//parent: angular.element(document.body),
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
		  console.log('functin triggered 1');
		}, function() {
		  $scope.status = 'You cancelled the dialog.';
		  console.log('functin triggered 2');
		});
  	};

 	 

	$scope.close = function()
	{
		$mdDialog.hide();
	}



}]);

DealerApp.run(function($rootScope, $templateCache) {
   $rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
   });
});

DealerApp.service("mapservice", function() {
  return {
    mapData: []
  }
});

DealerApp.service("carservice", function() {
  return {
    carData: []
  }
});

DealerApp.service("testDriveService", function() {
  return {
    testDriveData: []
  }
});

/*car view details controller*/
DealerApp.controller('carviewCtrl',['$scope','$mdDialog','$timeout', '$interval', '$routeParams','$http', 'carservice', 'testDriveService', 'apiurl', '$route', 'mapservice',function($scope,$mdDialog,$timeout, $interval, $routeParams, $http, carservice, testDriveService, apiurl, $route, mapservice){

	mapservice.mapData = ''; // for clearing map details

	$scope.project = {
				  comments: 'Comments',    
			   };

   	$scope.status = '  ';
  	$scope.customFullscreen = false;

  	$scope.loader = true;

  	sId = $routeParams.sId;
	cId = $routeParams.cId;

	$scope.sessionUser = sId;

	$scope.close = function()
	{
		$mdDialog.hide();
	}
	$scope.ownerDetails = [];

	$scope.ownerDetails.user_id = $routeParams.sId;
	$scope.ownerDetails.pageId = $routeParams.pageId;

	$scope.backToNative = function()
	{
		if($routeParams.pageId!=0)
		{
			getText = $routeParams.pageId.substring(0, $routeParams.pageId.indexOf(":"));
			console.log($routeParams.pageId.indexOf(":"));

			if(getText=='')
			{
				console.log('compare page');
				window.location = apiurl+'mobileweb/comparecar/www/#/app/comparecar/'+$routeParams.sId+'/'+$routeParams.cId+'/'+$routeParams.pageId;
			}
			else
			{
				console.log('Mobile page');
				var chatPage = $routeParams.pageId.split(':')[1];
				window.location = apiurl+'mobileweb/mobilechat/index.html#/'+chatPage+'/'+getText+'/'+$routeParams.sId;
			}
		}
		else
		{
			console.log('Back Page');
			window.location = apiurl+'mobileweb/back.html';
			//window.location = apiurl+'mobileweb/comparecar/www/#/app/comparecar/'+$routeParams.sId+'/'+$routeParams.cId+'/'+$routeParams.pageId;
		}
		
		
		
	}

	

	//$scope.heartin = '';
    $scope.carView = function()
    {
    	var data = {'session_user_id':sId,'car_id':cId}
    	console.log(data);
    	$http.post(apiurl+'api_view_cardetails',data).then(function(response){
			console.log(response.data);
			if(response.data.Result==1)
			{
			carservice.carData = response.data; 
			$scope.carDetails = carservice.carData; 
			var ndata = $scope.carDetails.dealerinfo[0];
    		$scope.phnoData  = ndata['Mobile Number'];
    		$scope.saveCar = $scope.carDetails.carimagesdetails[0].savedcars;
    		$scope.alert_status = $scope.carDetails.carimagesdetails[0].alert_status;
    		if($scope.saveCar=='' || $scope.saveCar==0)
    		{
    			$scope.heartin = 'images/like.svg';
    		}
    		else
    		{
    			$scope.heartin = 'images/like-red.svg';
    		}
    		if($scope.alert_status=='' || $scope.alert_status==0)
    		{
    			$scope.alertData = 'images/bell-white.svg';
    		}
    		else
    		{
    			$scope.alertData = 'images/bell-red.svg';
    		}
			if($scope.carDetails.carimagesdetails.length!=0)
			{
				$scope.imageName = $scope.carDetails.carimagesdetails[0].image_name;
				$scope.imageDataJoin = $scope.carDetails.carimagesdetails[0].image_url.join(',');
				$scope.imageData = $scope.imageDataJoin.split(',');
				if($scope.carDetails.carimagesdetails[0].video_url.length!=0)
				{
					$scope.videoUrl = $scope.carDetails.carimagesdetails[0].video_url[0];
				}
				
			}
			$scope.reporting = $scope.carDetails.reportingdetails[0].reportingid;
			$scope.loader = false;
			make_model_variant = $scope.carDetails.carmodeldetails[0].Make+" "+$scope.carDetails.carmodeldetails[0].Model+" "+$scope.carDetails.carmodeldetails[0].Variant;
			//$scope.ownerDetails.push({'dm':$scope.carDetails.dealermessage[0],'df':$scope.carDetails.dealerinfo[0],'sid':sId,'carId':cId,'variant':make_model_variant,'dealerId':$scope.carDetails.carmodeldetails[0].dealer_id,'currentdealerdetails':$scope.carDetails.currentdealerdetails[0],'carmodeldetails':$scope.carDetails.carmodeldetails[0],'fundingdetails':$scope.carDetails.fundingdetails[0]});
			$scope.ownerDetails = [{'dm':$scope.carDetails.dealermessage[0],'df':$scope.carDetails.dealerinfo[0],'sid':sId,'carId':cId,'variant':make_model_variant,'dealerId':$scope.carDetails.carmodeldetails[0].dealer_id,'currentdealerdetails':$scope.carDetails.currentdealerdetails[0],'carmodeldetails':$scope.carDetails.carmodeldetails[0],'fundingdetails':$scope.carDetails.fundingdetails[0],'pageId':$routeParams.pageId}];
				console.log($scope.ownerDetails);
				testDriveService.testDriveData = $scope.ownerDetails;
			}
			else
			{
				$scope.loader = false;
				alert = $mdDialog.alert({
		        title: 'Attention',
		        textContent: 'Oops... No data found. Try again later..! ',
		        ok: 'Close'
		      	});

		       $mdDialog
		        .show( alert )
		        .finally(function() {
		          window.location = apiurl+'mobileweb/back.html';
		        });
			}
		},function(response){
			console.log('Service Error');
			$scope.loader = false;
			alert = $mdDialog.alert({
		        title: 'Attention',
		        textContent: 'Unable to reach Server. Try Again Later..! ',
		        ok: 'Close'
	      	});

	       $mdDialog
	        .show( alert )
	        .finally(function() {
	          window.location = apiurl+'mobileweb/back.html';
	        });
	        //$route.reload();
		});
    }

    $scope.saveCarFun = function()
    {
    	$scope.savedCarLoader = true;
    	var data = {'session_user_id':sId,'carid':cId}
    	console.log(data);
    	$http.post(apiurl+'api_save_car',data).then(function(response){
			console.log(response.data);
			$scope.savedCarLoader = false;
			$scope.carView();
			
		},function(response){
			console.log('Service Error');
			$scope.savedCarLoader = false;
			alert = $mdDialog.alert({
		        title: 'Attention',
		        textContent: 'Oops...Cant able to Add Item to your Wishlist. Try Again Later.. ',
		        ok: 'Close'
	      	});

	       $mdDialog
	        .show( alert )
	        .finally(function() {
	          alert = undefined;
	        });
		});
    }

    if(carservice.carData.length==0)
    {
    	$scope.carView();
	}
	else
	{
		console.log('2');
		$scope.carDetails = carservice.carData;
		var ndata = $scope.carDetails.dealerinfo[0];
		$scope.phnoData  = ndata['Mobile Number'];
		if($scope.carDetails.carimagesdetails.length!=0)
		{
			$scope.imageName = $scope.carDetails.carimagesdetails[0].image_name;
			$scope.imageDataJoin = $scope.carDetails.carimagesdetails[0].image_url.join(',');
			$scope.imageData = $scope.imageDataJoin.split(',');
			if($scope.carDetails.carimagesdetails[0].video_url.length!=0)
			{
				$scope.videoUrl = $scope.carDetails.carimagesdetails[0].video_url[0];
			}
			
		}
		$scope.saveCar = $scope.carDetails.carimagesdetails[0].savedcars;
		$scope.alert_status = $scope.carDetails.carimagesdetails[0].alert_status;
		$scope.reporting = $scope.carDetails.reportingdetails[0].reportingid;
		$scope.loader = false;
		make_model_variant = $scope.carDetails.carmodeldetails[0].Make+" "+$scope.carDetails.carmodeldetails[0].Model+" "+$scope.carDetails.carmodeldetails[0].Variant;
		$scope.ownerDetails = [{'dm':$scope.carDetails.dealermessage[0],'df':$scope.carDetails.dealerinfo[0],'sid':sId,'carId':cId,'variant':make_model_variant,'dealerId':$scope.carDetails.carmodeldetails[0].dealer_id,'currentdealerdetails':$scope.carDetails.currentdealerdetails[0],'carmodeldetails':$scope.carDetails.carmodeldetails[0],'fundingdetails':$scope.carDetails.fundingdetails[0],'pageId':$routeParams.pageId}];
		testDriveService.testDriveData = $scope.ownerDetails;
		if($scope.saveCar=='' || $scope.saveCar==0)
		{
			$scope.heartin = 'images/like.svg';
		}
		else
		{
			$scope.heartin = 'images/like-red.svg';
		}
		if($scope.alert_status=='' || $scope.alert_status==0)
		{
			$scope.alertData = 'images/bell-white.svg';
		}
		else
		{
			$scope.alertData = 'images/bell-red.svg';
		}
	}

    $scope.phoneDialler = function()
    {
    	
    	document.location.href = "tel:"+$scope.phnoData;
    	console.log("tel:"+$scope.phnoData);
    }
   // $scope.phoneDialler();

   $scope.testDrive = function()
   {
   		console.log(testDriveService.testDriveData);
   		window.location = '#/testdrive';
   }
		
			  
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
		  $scope.carView();
		}, function() {
		  $scope.status = 'You cancelled the dialog.';
		});
  	};

  	/* reporting */

  	$scope.addReporting = function(reportData)
    {
    	var data = {'session_user_id':sId,'carid':cId,'report_listing_type_type_id':reportData,'dealer_id':$scope.carDetails.carmodeldetails[0].dealer_id};
    	console.log(data);
    	$http.post(apiurl+'doApireportlisting',data).then(function(response){
			console.log(response.data);
			alert = $mdDialog.alert({
		        textContent: response.data.reporting,
		        ok: 'Close'
	      	});

	       $mdDialog
	        .show( alert )
	        .finally(function() {
	          alert = undefined;
	        });
			
		},function(response){
			console.log('Service Error');
			alert = $mdDialog.alert({
		        title: 'Attention',
		        textContent: 'Unable to add your Reporting. Try Again Later..!',
		        ok: 'Close'
	      	});

	       $mdDialog
	        .show( alert )
	        .finally(function() {
	          alert = undefined;
	        });
		});
    }

    $scope.alertfun = function()
    {
    	$scope.alertLoader = true;
    	var data = {'session_user_id':sId,'car_id':cId,'page_name':'alertcarpage'};
    	console.log(data);
    	$http.post(apiurl+'api_alert_car',data).then(function(response){
			console.log(response.data);
			$scope.alertLoader = false;
			$scope.carView();
		},function(response){
			console.log('Service Error');
			$scope.alertLoader = false;
			alert = $mdDialog.alert({
		        title: 'Attention',
		        textContent: 'Unable to reach Server. Try Again Later..!',
		        ok: 'Close'
	      	});

	       $mdDialog
	        .show( alert )
	        .finally(function() {
	          alert = undefined;
	        });
		});
    }


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