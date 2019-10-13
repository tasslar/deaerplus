

DealerApp.controller('oopsCtrl',['$scope','$http','$rootScope','RegisterService',function($scope,$http,$rootScope,RegisterService){

	/*setTimeout(function(){ 
			window.location = '#/';
		}, 2000);*/

}]);

DealerApp.service('BasicDataService', function() {
  this.data = {}
  this.data.BasicData = new Array();
  this.data.selectedBillMap = '';
});

DealerApp.service("basicInfoService", function($http) {
  return {
    basicInfoData: []
  }
});

DealerApp.controller('basicInfoCtrl',['$scope', '$http', '$mdDialog', 'CityService', 'BasicDataService', 'basicInfoService', '$templateCache', 'apiurl', '$routeParams',function($scope, $http, $mdDialog, CityService, BasicDataService, basicInfoService, $templateCache, apiurl, $routeParams){

	console.log("Inventory basic information");

  sid = $routeParams.sid;

  $scope.BasicData = BasicDataService.data.BasicData;
  console.log($scope.BasicData);

  $templateCache.removeAll();
  /*get data*/

  $scope.getData = function(){
    $http.get(apiurl+'public/apidoaddinventory').then(function(response){
      console.log(response.data);
      basicInfoService.basicInfoData = response.data;
      $scope.getBasicData = basicInfoService.basicInfoData;

    },function(response){
      console.log('Service Error');
    });
  }


  $scope.getModel = function(){
    var data = {make_id:$scope.BasicData.make};
    $http.post(apiurl+'public/doApi_master_model',data).then(function(response){
      console.log(response.data);
      $scope.modelData = response.data;
    },function(response){
      console.log('Service Error');
    });
  }

  $scope.getVariant = function(){
    var data = {model_id:$scope.BasicData.model};
    $http.post(apiurl+'public/doApi_master_variant',data).then(function(response){
      console.log(response.data);
      $scope.variantData = response.data;
    },function(response){
      console.log('Service Error');
    });
  }

  $scope.getTransmission = function(){
    var data = {session_user_id:sid,variant_id:$scope.BasicData.varient};
    $http.post(apiurl+'public/api_master_transmissiontype',data).then(function(response){
      console.log(response.data);
      $scope.transmissionData = response.data;
      $scope.BasicData.body = $scope.transmissionData.Body_type.category_description;
      $scope.BasicData.transmission = $scope.transmissionData.Transmission_type[0];
      $scope.BasicData.fueltype = $scope.transmissionData.Fuel_type.fuel_type;
    },function(response){
      console.log('Service Error');
    });
  }

  $scope.getBranch = function(){
    var data = {session_user_id:sid,city_id:$scope.BasicData.varient};
    $http.post(apiurl+'public/api_master_branchtype',data).then(function(response){
      console.log(response.data);
      $scope.branchData = response.data;
    },function(response){
      console.log('Service Error');
    });
  }
 

  if(basicInfoService.basicInfoData.length==0)
  {
    console.log(1);
       $scope.getData();
  }
  else
  {
      console.log(2);
       $scope.getBasicData = basicInfoService.basicInfoData;
       console.log($scope.getBasicData.make);
       if(typeof $scope.getBasicData.make=='undefined')
       {
       
          $scope.getModel();
       }

       if(typeof $scope.getBasicData.model=='undefined')
       {
        
          $scope.getVariant();
       }

       if(typeof $scope.getBasicData.varient=='undefined')
       {
        
          $scope.getTransmission();
       }

       if(typeof $scope.getBasicData.cityid=='undefined')
       {
        
          $scope.getBranch();
       }
  }



  

  /* city data*/
  $scope.getCity = function(){
    $http.get('http://52.221.57.201/dev/public/master_city_get').then(function(response){
      console.log(response.data);
      $scope.cities = response.data;
      CityService.cityData = $scope.cities;
      $scope.loader = false;
    },function(response){
      console.log('Service Error');
      //console.log(response);
    });
  }
  $scope.getCity();


  $scope.citypage = function(){
    window.location = '#/city';
  }


  $scope.showTabDialog = function(ev,page,ctrl) {
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

	
}]);

DealerApp.controller('cityCtrl',['$scope', '$http', 'CityService', '$mdDialog',function($scope, $http, CityService, $mdDialog){

  /*CityService.async().then(function(d) {
    $scope.cities = d[0];
    //console.log($scope.cities);
  });*/

  console.log(CityService.cityData);
  //$scope.cities = CityService.cityData[0];

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

  $scope.close = function()
  {
    $mdDialog.hide();
  }

}]);

DealerApp.service("CityService", function($http) {
  return {
    cityData: []
  }
});

DealerApp.controller('inventorycertificateCtrl',['$scope','$http',function($scope,$http){

	console.log("Inventory certification information");

	
}]);


DealerApp.controller('inventoryEngineCtrl',['$scope','$http',function($scope,$http){

	console.log("Inventory Engine information");

	
}]);

DealerApp.controller('inventoryImageCtrl',['$scope','$http', '$mdDialog',function($scope, $http, $mdDialog){

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

/*document.getElementById('profilePic').addEventListener('change', handleFileSelect, false);*/
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



}]);

DealerApp.controller('imageEditCtrl',['$scope','$http',function($scope,$http){

  console.log('image edit');

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

/*DealerApp.filter('checkFile', function () {
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
}); */

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
