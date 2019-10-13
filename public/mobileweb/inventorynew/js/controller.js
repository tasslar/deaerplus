

DealerApp.controller('oopsCtrl',['$scope','$http','$rootScope','RegisterService',function($scope,$http,$rootScope,RegisterService){

	/*setTimeout(function(){ 
			window.location = '#/';
		}, 2000);*/

}]);


DealerApp.controller('soldCtrl',['$scope','$http',function($scope,$http){

  console.log('sold page');

}]);


DealerApp.controller('insuranceCtrl',['$scope','$http','apiurl','$routeParams',function($scope,$http,apiurl,$routeParams){

    $scope.getHypoInsurance = function(){
    $scope.loader = true;
    var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid};
    $http.post(apiurl+'api_doview_hypothacation',data).then(function(response){
      console.log(response.data);
      $scope.insuranceData = response.data.basicinsurance[0];
      $scope.loader = false;
    },function(response){
      console.log('Service Error');
      $scope.loader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getHypoInsurance();

  $scope.saveHypoInsurance = function(){
    $scope.loader = true;
    var formData = new FormData($("form#addHypoInsurance")[0]);
        formData.append("session_user_id", $routeParams.sid);
        formData.append("car_id", $routeParams.cid);
        var options = { 
              clearForm: true,
              resetForm: true
            };
        
        jQuery.ajax({
          url: apiurl+'api_doadd_hypothacation',
          type:'post',
          data:  formData,
          async: false,
          contentType: false,
          processData: false,
          success: function(response) {
            console.log(response);
            $scope.loader = false;
            if(response.Result==1)
            {
                $('.toast').remove()
                var $toastContent = $('<span> The Details has been updated Successfully. </span>');
                Materialize.toast($toastContent, 5000);
            }
            else
            {
                $('.toast').remove();
                var $toastContent = $('<span> Whoops...! Something went Wrong. Try again later. </span>');
                Materialize.toast($toastContent, 5000);
            }
             
          },
          error: function (jqXHR, exception) {
              $scope.loader = false;
              swal("Unable to reach server. Try again later...");
          },
          
        });
    }

    $scope.backtoBasic = function()
    {
      window.history.back();  
    }

    $scope.next = function()
    {
      window.location = '#/inventoryCertification/'+$routeParams.sid+'/'+$routeParams.cid;
    }

  
}]);

DealerApp.controller('inventorycertificateCtrl',['$scope','$http','apiurl','$routeParams',function($scope,$http,apiurl,$routeParams){

    $scope.getCertification = function(){
      console.log(1);
    $scope.loader = true;
    var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid};
    $http.post(apiurl+'api_doview_certiwarranty',data).then(function(response){
      console.log(response.data);
      $scope.certificateData = response.data.basiccertificate[0];
      $scope.loader = false;
    },function(response){
      console.log('Service Error');
      $scope.loader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

 
  $scope.getCertification();

  $scope.saveCertification = function(){
    $scope.loader = true;
    var formData = new FormData($("form#addCertification")[0]);
        formData.append("session_user_id", $routeParams.sid);
        formData.append("car_id", $routeParams.cid);
        formData.append("inspectionagency", $scope.certificateData.inspectionagencyid);
        formData.append("serviceagency", $scope.certificateData.serviceagencyid);
        var options = { 
              clearForm: true,
              resetForm: true
            };
        
        jQuery.ajax({
          url: apiurl+'api_doAdd_certiwarranty',
          type:'post',
          data:  formData,
          async: false,
          contentType: false,
          processData: false,
          success: function(response) {
            console.log(response);
            $scope.loader = false;
            if(response.Result==1)
            {
                $scope.getCertification();
                $('.toast').remove()
                var $toastContent = $('<span> The Details has been updated Successfully. </span>');
                Materialize.toast($toastContent, 5000);
            }
            else
            {
                $('.toast').remove();
                var $toastContent = $('<span> Whoops...! Something went Wrong. Try again later. </span>');
                Materialize.toast($toastContent, 5000);
            }
             
          },
          error: function (jqXHR, exception) {
              $scope.loader = false;
              swal("Unable to reach server. Try again later...");
          },
          
        });
    }

    $scope.backtoBasic = function()
    {
      window.history.back();  
    }

    $scope.next = function()
    {
      window.location = '#/inventoryEngine/'+$routeParams.sid+'/'+$routeParams.cid;
    }


    $scope.pickInsAgency = function(id,name)
    {
      $scope.certificateData.inspectionagency = name;
      $scope.certificateData.inspectionagencyid = id;
      $('#insAngent').modal('close');
    }

    $scope.pickSerAgency = function(id,name)
    {
      $scope.certificateData.serviceagency = name;
      $scope.certificateData.serviceagencyid = id;
      $('#servAgency').modal('close');
    }

    function handleFileSelect(evt) {
      console.log(evt.target.files);
      if(evt.target.files[0].size <= 2097152)
      {
        var files = evt.target.files[0].name; // FileList object
        $("#output"+evt.target.id).html('You Selected : '+files);
      }
      else
      {
          var file = document.getElementById(evt.target.id);
          file.value = file.defaultValue;
          $('.toast').remove()
          var $toastContent = $('<span> Maximum File Size 2MB. </span>');
          Materialize.toast($toastContent, 5000);
      }
      
    }

    $scope.removeDoc = function(id,fileName)
    {
        var file = document.getElementById(id);
        file.value = file.defaultValue;
        $("#output"+id).html('Select '+fileName);  
        
    }

    document.getElementById('creportImg').addEventListener('change', handleFileSelect, false);
    document.getElementById('swreportImage').addEventListener('change', handleFileSelect, false);

  
}]);

DealerApp.controller('marketCtrl',['$scope','$http','$routeParams','apiurl',function($scope,$http,$routeParams,apiurl){

  console.log('market');

  $scope.back = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }

  $scope.getMarket = function(makeid){
    $scope.loader = true;
    var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid};
    $http.post(apiurl+'apidoviewmarket',data).then(function(response){
     // console.log(response.data);
      $scope.smsData = response.data.smsdata;
      $scope.emailData = response.data.emaildata;
      $scope.marketView = response.data.marketview[0];
      angular.forEach($scope.smsData,function(value,key){
        console.log(key);
        //$scope.smsObj.smscheck.push({key:true});
        $scope.smsObj.smscheck[key] = true;
        //console.log($scope.smsObj);
      });
      angular.forEach($scope.smsData,function(value,key){
        console.log(key);
        //$scope.smsObj.smscheck.push({key:true});
        $scope.smsObj.emailcheck[key] = true;
        //console.log($scope.smsObj);
      });
      //console.log($scope.smsObj.smscheck);
      $scope.loader = false;
    },function(response){
      console.log('Service Error');
      $scope.loader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

    $scope.getMarket();

    $scope.smsSwitch = 'on';
    $scope.emailSwitch = 'on';

    $scope.smsObj = [];
    $scope.smsObj.smscheck = [];
    $scope.smsObj.emailcheck = [];
    console.log($scope.smsObj); 
//http://dev.dealerplus.in/dev/public/api_Marketingsmsandmail
    $scope.submit = function()
    {
        console.log($scope.smsObj.smscheck);
        $scope.loader = true;
        var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid,'sms':$scope.smsObj.smscheck,'email':$scope.smsObj.emailcheck};
        console.log(data);
        $http.post('http://app.dealerplus.in/api_Marketingsmsandmail',data).then(function(response){
          console.log(response.data);
          swal({
              title: response.data.message,
              showCancelButton: false,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ok",
              closeOnConfirm: true
            },
            function(){
              window.location = apiurl+'mobileweb/back.html';
            });
          $scope.loader = false;
        },function(response){
          console.log('Service Error');
          $scope.loader = false;
          swal({
              title: "Unable to reach server. Try again later...",
              showCancelButton: false,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ok",
              closeOnConfirm: true
            },
            function(){
              window.location = apiurl+'mobileweb/back.html';
            });
        });
    }

    $scope.disableSmsSwitch = function()
    {
      angular.forEach($scope.smsData,function(value,key){
        console.log(key);
        //$scope.smsObj.smscheck.push({key:true});
        $scope.smsObj.smscheck[key] = false;
        //console.log($scope.smsObj);
      });
    }

    $scope.disableEmailSwitch = function()
    {
      angular.forEach($scope.smsData,function(value,key){
        console.log(key);
        //$scope.smsObj.smscheck.push({key:true});
        $scope.smsObj.emailcheck[key] = false;
        //console.log($scope.smsObj);
      });
    }

}]);


DealerApp.controller('pageNotFoundCtrl',['$scope','$http','apiurl',function($scope,$http,apiurl){

  $scope.backtoBasic = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }

}]);

DealerApp.controller('errorPageCtrl',['$scope','apiurl',function($scope,apiurl){

  $scope.back = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }

  $scope.backtoBasic = function()
  {
    window.history.back();  
  }
  
 
}]);

DealerApp.controller('testctrl',['$scope', '$http',function($scope, $http){

  console.log('test controller');

}]);

DealerApp.service("basicInfoService", function() {
  return {
    basicData: [],
    basicItemData: [],
    vinlookupData: [],
    carDetails: []
  }
});

DealerApp.service("editBasicInfoService", function() {
  return {
    basicData: [],
    basicItemData: [],
    basicEditData: [],
    vinlookupData: []
  }
});

DealerApp.controller('vinlookupCtrl',['$scope', '$http', '$templateCache', '$routeParams', 'apiurl', 'basicInfoService','$window',function($scope, $http, $templateCache, $routeParams, apiurl, basicInfoService,$window){

    console.log('vinlookup');

    $scope.sid = $routeParams.sid;
    $scope.loader = true;
    $scope.vinlookupFun = function(){

      $scope.vinlookupData = basicInfoService.vinlookupData;
      console.log($scope.vinlookupData);
      $scope.loader = false;
    }
    $scope.vinlookupFun();

    $scope.populate = function()
    {
      $scope.basicInfoData = {
        'registerYear':$scope.vinlookupData.vehicle.manu_yr,
        'makeId':$scope.vinlookupData.vehicle.makeid,
        'modalId':$scope.vinlookupData.vehicle.modelid,
        'vaientId':$scope.vinlookupData.vehicle.variantid,
        //'bodyType':$scope.vinlookupData.VinInfo.modelid,
        //'transmissionId':$scope.vinlookupData.VinInfo.modelid,
        //'totalDistance':$scope.vinlookupData.VinInfo.modelid,
        //'millege':$scope.mileage,
        'ownerShip':$scope.vinlookupData.vehicle.owner_sr,
        //'carStatusId':$scope.carstatusId,
        'colorId':$scope.vinlookupData.vehicle.colorid,
        'cityId':$scope.vinlookupData.vehicle.cityid,
        //'branch':$scope.branchId,
        //'fuelType':$scope.fuelType
        'regNum':$scope.vinlookupData.vehicle.regn_no,
        'engNum':$scope.vinlookupData.vehicle.eng_no,
        'chasisNum':$scope.vinlookupData.vehicle.chasi_no
      };

      $scope.basicItemData = {
      'registerYear':$scope.vinlookupData.vehicle.manu_yr,
      'make':$scope.vinlookupData.vehicle.makename,
      'modal':$scope.vinlookupData.vehicle.modelname,
      'vaient':$scope.vinlookupData.vehicle.variantname,
      //'bodyType':$scope.vinlookupData.VinInfo.manu_yr,
      //'transmissionId':$scope.vinlookupData.VinInfo.manu_yr,
      //'totalDistance':$scope.tDistance,
      //'millege':$scope.mileage,
      'ownerShip':$scope.vinlookupData.vehicle.owner_sr,
      //'carStatus':$scope.carstatus,
      'color':$scope.vinlookupData.vehicle.color,
      'city':$scope.vinlookupData.vehicle.cityname,
      //'branch':$scope.branch,
      //'fuelType':$scope.fuelType
    };
      console.log($scope.basicInfoData);
      basicInfoService.basicData = $scope.basicInfoData;
      basicInfoService.basicItemData = $scope.basicItemData;
      $window.history.back();
    }

    $scope.BackToBasic = function()
    {
      $window.history.back();
    }

}]);

DealerApp.controller('vinlookupEditCtrl',['$scope', '$http', '$templateCache', '$routeParams', 'apiurl', 'editBasicInfoService','$window',function($scope, $http, $templateCache, $routeParams, apiurl, editBasicInfoService,$window){

    console.log('vinlookup');

    $scope.sid = $routeParams.sid;
    $scope.loader = true;
    $scope.vinlookupFun = function(){

      $scope.vinlookupData = editBasicInfoService.vinlookupData;
      console.log($scope.vinlookupData);
      $scope.loader = false;
    }
    $scope.vinlookupFun();

    $scope.populate = function()
    {
      $scope.basicInfoData = {
        'registerYear':$scope.vinlookupData.vehicle.manu_yr,
        'makeId':$scope.vinlookupData.vehicle.makeid,
        'modalId':$scope.vinlookupData.vehicle.modelid,
        'vaientId':$scope.vinlookupData.vehicle.variantid,
        //'bodyType':$scope.vinlookupData.VinInfo.modelid,
        //'transmissionId':$scope.vinlookupData.VinInfo.modelid,
        //'totalDistance':$scope.vinlookupData.VinInfo.modelid,
        //'millege':$scope.mileage,
        'ownerShip':$scope.vinlookupData.vehicle.owner_sr,
        //'carStatusId':$scope.carstatusId,
        'colorId':$scope.vinlookupData.vehicle.colorid,
        'cityId':$scope.vinlookupData.vehicle.cityid,
        //'branch':$scope.branchId,
        //'fuelType':$scope.fuelType
        'regNum':$scope.vinlookupData.vehicle.regn_no,
        'engNum':$scope.vinlookupData.vehicle.eng_no,
        'chasisNum':$scope.vinlookupData.vehicle.chasi_no
      };

      $scope.basicItemData = {
      'registerYear':$scope.vinlookupData.vehicle.manu_yr,
      'make':$scope.vinlookupData.vehicle.makename,
      'modal':$scope.vinlookupData.vehicle.modelname,
      'vaient':$scope.vinlookupData.vehicle.variantname,
      //'bodyType':$scope.vinlookupData.VinInfo.manu_yr,
      //'transmissionId':$scope.vinlookupData.VinInfo.manu_yr,
      //'totalDistance':$scope.tDistance,
      //'millege':$scope.mileage,
      'ownerShip':$scope.vinlookupData.vehicle.owner_sr,
      //'carStatus':$scope.carstatus,
      'color':$scope.vinlookupData.vehicle.color,
      'city':$scope.vinlookupData.vehicle.cityname,
      //'branch':$scope.branch,
      //'fuelType':$scope.fuelType
    };
      console.log($scope.basicInfoData);
      editBasicInfoService.basicData = $scope.basicInfoData;
      editBasicInfoService.basicItemData = $scope.basicItemData;
      $window.history.back();
    }

    $scope.BackToBasic = function()
    {
      $window.history.back();
    }

}]);

DealerApp.controller('basicInfoCtrl',['$scope', '$http', '$templateCache', '$routeParams', 'apiurl', 'basicInfoService',function($scope, $http, $templateCache, $routeParams, apiurl, basicInfoService){

	console.log("Inventory basic information");

  $scope.totaldistanceLength = 6;
  $templateCache.removeAll();
  $scope.loader = true;
  $scope.pickLoader = true;
  
  /*$scope.$watch('$viewContentLoaded', function()
  {
      $scope.loader = false;
  });*/

  $scope.getModelEdit = function(makeid){
    $scope.itemLoader = true;
    var data = {make_id:makeid};
    $http.post(apiurl+'doApi_master_model',data).then(function(response){
      console.log(response.data);
      $scope.modelData = response.data;
      $scope.itemLoader = false;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getVariantEdit = function(modalId){
    $scope.itemLoader = true;
    var data = {model_id:modalId};
    $http.post(apiurl+'doApi_master_variant',data).then(function(response){
      console.log(response.data);
      $scope.variantData = response.data;
      $scope.itemLoader = false;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getBranchEdit = function(cityId){
    var data = {session_user_id:sid,city_id:cityId};
    $http.post(apiurl+'api_master_branchtype',data).then(function(response){
      console.log(response.data);
      $scope.branchData = response.data;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  console.log(basicInfoService.basicData);
  if(basicInfoService.basicData.length=='')
  {
    console.log('1')
    $scope.make = '';
    $scope.modal = '';
    $scope.branch = '';
    $scope.mileage = '';
    $scope.tDistance = '';
  }
  else
  {
    $scope.registerYear = basicInfoService.basicData.registerYear;
    $scope.make = basicInfoService.basicItemData.make;
    $scope.makeId = basicInfoService.basicData.makeId;
    $scope.modal = basicInfoService.basicItemData.modal;
    $scope.modalId = basicInfoService.basicData.modalId;
    $scope.varient = basicInfoService.basicItemData.vaient;
    $scope.varientId = basicInfoService.basicData.vaientId;
    $scope.bodyType = basicInfoService.basicData.bodyType; 
    $scope.transmission = basicInfoService.basicData.transmissionId;
    $scope.tDistance = basicInfoService.basicData.totalDistance;
    $scope.mileage = basicInfoService.basicData.millege;
    $scope.ownership = basicInfoService.basicData.ownerShip; 
    $scope.ownershipId =basicInfoService.basicItemData.ownerShip;
    $scope.carstatus = basicInfoService.basicItemData.carStatus;
    $scope.carstatusId = basicInfoService.basicData.carStatusId;
    $scope.color = basicInfoService.basicItemData.color;
    $scope.colorId = basicInfoService.basicData.colorId;
    $scope.city = basicInfoService.basicItemData.city;
    $scope.cityId = basicInfoService.basicData.cityId;
    $scope.branch = basicInfoService.basicItemData.branch;
    $scope.branchId = basicInfoService.basicData.branch;
    $scope.fuelType = basicInfoService.basicData.fuelType;

    /*vinlookup*/

    $scope.regNum = basicInfoService.basicData.regNum;
    $scope.engineNumber = basicInfoService.basicData.engNum;
    $scope.chasisNumber = basicInfoService.basicData.chasisNum;

    if($scope.makeId!='')
    {
      $scope.getModelEdit($scope.makeId);
    }
    if($scope.modalId!='')
    {
      $scope.getVariantEdit($scope.modalId);
    }
    if($scope.cityId!='')
    {
      $scope.getBranchEdit($scope.cityId);
    }
    
    console.log(2);
  }
  /*get data*/

  /* initilization */
  //$scope.make = '';
  //$scope.modal = '';
  $scope.modelData = '';
  $scope.variantData = '';
  $scope.branchId = '';

  sid = $routeParams.sid;

  $scope.getData = function(){
    $scope.itemLoader = true;
    var data = {'session_user_id':sid};
    $http.post(apiurl+'apidoaddinventory',data).then(function(response){
      console.log(response.data);
      if(response.data.Result == 1)
      {
        $scope.getBasicData = response.data;
        $scope.loader = false;
        $scope.itemLoader = false;
      }
      else
      {
        swal({
          title: "No Data Found..!",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/nodataFound';
        });
        $scope.loader = false;
      }
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
        $scope.loader = false;
    });
  }

  $scope.getData();

  $scope.getModel = function(makeid){
    $scope.itemLoader = true;
    
    $scope.modal = "";
    $scope.modalId = '';
    $scope.modelData = "";
    var data = {make_id:makeid};
    $http.post(apiurl+'doApi_master_model',data).then(function(response){
      console.log(response.data);
      $scope.modelData = response.data;
      $scope.itemLoader = false;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getVariant = function(modalId){
    $scope.itemLoader = true;
    $scope.varient = "";
    $scope.varientId = '';
    $scope.variantData = "";
    var data = {model_id:modalId};
    $http.post(apiurl+'doApi_master_variant',data).then(function(response){
      console.log(response.data);
      $scope.variantData = response.data;
      $scope.itemLoader = false;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getTransmission = function(varientId){
    $scope.transmissionData = "";
    var data = {session_user_id:sid,variant_id:varientId};
    $http.post(apiurl+'api_master_transmissiontype',data).then(function(response){
      console.log(response.data);
      $scope.transmissionData = response.data;
      $scope.bodyType = $scope.transmissionData.Body_type.category_description;
      $scope.transmission = $scope.transmissionData.Transmission_type[0];
      $scope.fuelType = $scope.transmissionData.Fuel_type.fuel_type;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }
 

  /* city data*/
  $scope.getCity = function(){
    $scope.itemLoader = true;
    $http.get(apiurl+'master_city_get').then(function(response){
      console.log(response.data);
      $scope.cities = response.data[0];
      $scope.itemLoader = false;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
      //console.log(response);
    });
  }
  $scope.getCity();
  $scope.branchData = '';
  $scope.getBranch = function(cityId){
    $scope.itemLoader = true;
    $scope.branch = "";
    $scope.branchId = "";
    $scope.branchData = "";
    var data = {session_user_id:sid,city_id:cityId};
    $http.post(apiurl+'api_master_branchtype',data).then(function(response){
      console.log(response.data);
      $scope.branchData = response.data;
      $scope.itemLoader = false;
    },function(response){
      console.log('Service Error');
      //$scope.itemLoader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.pickRegister = function(yearId,yearName){
    $scope.registerYear = yearName;
    $scope.registerId = yearId;
    $('#register').modal('close');
  }


  $scope.pickMake = function(makeId,makeName){
    $scope.pickLoader = false;
    $scope.make = makeName;
    $scope.makeId = makeId;
    $scope.getModel(makeId);
    $('#make').modal('close');
  }

  $scope.pickModal = function(modalId,modalName){
    $scope.modal = modalName;
    $scope.modalId = modalId;
    $scope.getVariant(modalId);
    $('#modal').modal('close');
  }

  $scope.pickVarient = function(varientId,varientName){
    $scope.varient = varientName;
    $scope.varientId = varientId;
    $scope.getTransmission(varientId);
    $('#varient').modal('close');
  }

  $scope.pickBodyType = function(bodyTypeName){
    $scope.bodyType = bodyTypeName;
    $('#bodyType').modal('close');
  }

  $scope.pickOwner = function(ownerId,ownerType){
    $scope.ownership = ownerId;
    $scope.ownershipId = ownerType;
   console.log($scope.ownership+" - "+$scope.ownershipId);
    $('#ownership').modal('close');
  }

  $scope.pickCar = function(carId,carType){
    $scope.carstatus = carType;
    $scope.carstatusId = carId;
    $('#carstatus').modal('close');
  }

  $scope.pickColor = function(colorId,colorName){
    $scope.color = colorName;
    $scope.colorId = colorId;
    $('#color').modal('close');
  }

  $scope.closeCity = function()
  {
    var offset = parseInt(document.body.style.top, 10);
    document.body.classList.remove('modal--opened');
    document.body.scrollTop = (offset * -1);
    $scope.searchCity = '';
    $('#city').modal('close');
  }

  $scope.pickCity = function(cityId,cityName){
    $scope.city = cityName;
    $scope.cityId = cityId;
    $scope.getBranch(cityId);
    $scope.closeCity();
  }

  $scope.pickBranch = function(branchName,branchId){
    $scope.branch = branchName;
    $scope.branchId = branchId;
    $('#branch').modal('close');
  }


  $scope.basicInfoSubmit = function()
  {
    $scope.loader = true;
      $scope.basicInfoData = {'registerYear':$scope.registerYear,'makeId':$scope.makeId,'modalId':$scope.modalId,'vaientId':$scope.varientId,'bodyType':$scope.bodyType,'transmissionId':$scope.transmission,'totalDistance':$scope.tDistance,'millege':$scope.mileage,'ownerShip':$scope.ownershipId,'carStatusId':$scope.carstatusId,'colorId':$scope.colorId,'cityId':$scope.cityId,'branch':$scope.branchId,'fuelType':$scope.fuelType};

      $scope.basicItemData = {'registerYear':$scope.registerYear,'make':$scope.make,'modal':$scope.modal,'vaient':$scope.varient,'bodyType':$scope.bodyType,'transmissionId':$scope.transmission,'totalDistance':$scope.tDistance,'millege':$scope.mileage,'ownerShip':$scope.ownership,'carStatus':$scope.carstatus,'color':$scope.color,'city':$scope.city,'branch':$scope.branch,'fuelType':$scope.fuelType,'planDetails':$scope.getBasicData.planDetails[0]};
      console.log($scope.basicInfoData);
      basicInfoService.basicData = $scope.basicInfoData;
      basicInfoService.basicItemData = $scope.basicItemData;
      window.location = '#/priceInfo/'+sid;
  }

  $scope.back = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }


  $scope.fetch = function()
  {   
    if($scope.regNum!='' && typeof $scope.regNum!='undefined' )
    {
        $scope.loader = true;
        var data = {session_user_id:sid,registerNumber:$scope.regNum};
        console.log(data);
        $http.post(apiurl+'api_doApifastlanevininfo',data).then(function(response){
          console.log(response.data);
          if(response.data.Result==1)
          {
            $scope.vinlookupData = response.data.VinInfo[0];
            basicInfoService.vinlookupData = $scope.vinlookupData;
            console.log(basicInfoService.vinlookupData);
            $scope.loader = false;
            window.location = '#/vinlookup/'+sid;
          }
          else
          {
            swal("No Data Found. Try again later...");
            $scope.loader = false;
          }
          
        },function(response){
          $scope.loader = false;
          console.log('Service Error');
          swal("Unable to reach server. Try again later...");
        });
    }
    else
    {
      //swal("Please Enter Register number");
      $('.toast').remove()
      var $toastContent = $('<span> Please Enter Registration number </span>');
      Materialize.toast($toastContent, 5000);
    }
  }

  $scope.openCity = function()
  {
    console.log('open city');
    var offset = document.body.scrollTop;
    document.body.style.top = (offset * -1) + 'px';
    document.body.classList.add('modal--opened');
    //$('#city').modal('open');
    //$('#city').modal('open');
  }

  $scope.$watch('mileage', function(newValue, oldValue) {
   
      if($scope.mileage>50)
      {
        //console.log(newValue.substring(from,to));
        $scope.mileage = '';
      }
    
  });

  /*$scope.$watch('tDistance', function(newValue, oldValue) {
   
      if(typeof newValue != 'undefined')
      {
        intostr = newValue.toString();
        console.log(intostr);
        if(intostr.length>=7)
        {
          console.log('greater than 6');
          $scope.tDistance = oldValue;
        }
        else if(newValue==0)
        {
          console.log('lesser than 6');
          $scope.tDistance = '';
        }
      }
      
  });*/

  
	
}]);

DealerApp.controller('EditBasicInfoCtrl',['$scope', '$http', '$templateCache', '$routeParams', 'apiurl', 'editBasicInfoService',function($scope, $http, $templateCache, $routeParams, apiurl, editBasicInfoService){

  console.log("Inventory Edit basic information");



  $templateCache.removeAll();
  $scope.loader = true;
  /*$scope.$watch('$viewContentLoaded', function()
  {
      $scope.loader = false;
  });*/

   sid = $routeParams.sid;
   cid = $routeParams.cid;

   $scope.getModelEdit = function(makeid){
    var data = {make_id:makeid};
    $http.post(apiurl+'doApi_master_model',data).then(function(response){
      console.log(response.data);
      $scope.modelData = response.data;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getVariantEdit = function(modalId){
    var data = {model_id:modalId};
    $http.post(apiurl+'doApi_master_variant',data).then(function(response){
      console.log(response.data);
      $scope.variantData = response.data;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getBranchEdit = function(cityId){
    var data = {session_user_id:sid,city_id:cityId};
    $http.post(apiurl+'api_master_branchtype',data).then(function(response){
      console.log(response.data);
      $scope.branchData = response.data;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  if(editBasicInfoService.basicData.length=='')
  {
      $scope.getCarDetailsFun = function(){
        var data = {'session_user_id':sid,'car_id':cid};
        $http.post(apiurl+'api_doview_inventory',data).then(function(response){
        console.log(response.data);
        $scope.loader = false;
        if(response.data.Result==1)
        {
          $scope.registerYear = response.data.viewinventory[0].registration_year;
          $scope.make = response.data.viewinventory[0].makename;
          $scope.makeId = response.data.viewinventory[0].make;
          $scope.modal = response.data.viewinventory[0].modelname;
          $scope.modalId = response.data.viewinventory[0].model_id;
          $scope.varient = response.data.viewinventory[0].varientname;
          $scope.varientId = response.data.viewinventory[0].variant;
          $scope.bodyType = response.data.viewinventory[0].categoryname;
          $scope.transmission = response.data.viewinventory[0].transmission;
          $scope.tDistance = response.data.viewinventory[0].kms_done;
          $scope.mileage = response.data.viewinventory[0].mileage;
          $scope.ownership = response.data.viewinventory[0].owner_id;
          $scope.ownershipId = response.data.viewinventory[0].owner_type;
          $scope.carstatus = response.data.viewinventory[0].carstatusname;
          $scope.carstatusId = response.data.viewinventory[0].carstatus;
          $scope.color = response.data.viewinventory[0].colorname;
          $scope.colorId = response.data.viewinventory[0].colors;
          $scope.city = response.data.viewinventory[0].cityname;
          $scope.cityId = response.data.viewinventory[0].car_city;
          $scope.branch = response.data.viewinventory[0].branchname;
          $scope.branchId = response.data.viewinventory[0].branch_id;
          $scope.fuelType = response.data.viewinventory[0].fuel_type;
          editBasicInfoService.basicEditData = response.data.viewinventory[0];
          $scope.getModelEdit($scope.makeId);
          $scope.getVariantEdit($scope.modalId);
          $scope.getBranchEdit($scope.cityId);
        }
        else
        {
          swal({
            title: "No Data Found..!",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ok",
            closeOnConfirm: true
          },
          function(){
            window.location = '#/nodataFound';
          });
        }
        },function(response){
          console.log('Service Error');
          swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
        });
      }
    $scope.getCarDetailsFun();
    console.log('1')
    $scope.make = '';
    $scope.modal = '';
    $scope.branch = '';
  }
  else
  {
    $scope.registerYear = editBasicInfoService.basicData.registerYear;
    $scope.make = editBasicInfoService.basicItemData.make;
    $scope.makeId = editBasicInfoService.basicData.makeId;
    $scope.modal = editBasicInfoService.basicItemData.modal;
    $scope.modalId = editBasicInfoService.basicData.modalId;
    $scope.varient = editBasicInfoService.basicItemData.vaient;
    $scope.varientId = editBasicInfoService.basicData.vaientId;
    $scope.bodyType = editBasicInfoService.basicData.bodyType; 
    $scope.transmission = editBasicInfoService.basicData.transmissionId;
    $scope.tDistance = editBasicInfoService.basicData.totalDistance;
    $scope.mileage = editBasicInfoService.basicData.millege;
    $scope.ownership = editBasicInfoService.basicItemData.ownerShip;
    $scope.ownershipId = editBasicInfoService.basicData.ownerShip;
    $scope.carstatus = editBasicInfoService.basicItemData.carStatus;
    $scope.carstatusId = editBasicInfoService.basicData.carStatusId;
    $scope.color = editBasicInfoService.basicItemData.color;
    $scope.colorId = editBasicInfoService.basicData.colorId;
    $scope.city = editBasicInfoService.basicItemData.city;
    $scope.cityId = editBasicInfoService.basicData.cityId;
    $scope.branch = editBasicInfoService.basicItemData.branch;
    $scope.branchId = editBasicInfoService.basicData.branch;
    $scope.fuelType = editBasicInfoService.basicData.fuelType;

    $scope.regNum = editBasicInfoService.basicData.regNum;
    $scope.engineNumber = editBasicInfoService.basicData.engNum;
    $scope.chasisNumber = editBasicInfoService.basicData.chasisNum;

    if($scope.makeId!='')
    {
      $scope.getModelEdit($scope.makeId);
    }
    if($scope.modalId!='')
    {
      $scope.getVariantEdit($scope.modalId);
    }
    if($scope.cityId!='')
    {
      $scope.getBranchEdit($scope.cityId);
    }
    console.log(2);
    $scope.loader = false;
  }
  /*get data*/

  /* initilization */
  //$scope.make = '';
  //$scope.modal = '';
  $scope.modelData = '';
  $scope.variantData = '';

 

  $scope.getData = function(){
    var data = {'session_user_id':sid};
    $http.post(apiurl+'apidoaddinventory',data).then(function(response){
      console.log(response.data);
      if(response.data.Result == 1)
      {
        $scope.getBasicData = response.data;
        $scope.itemLoader = false;
      }
      else
      {
        swal({
          title: "No Data Found..!",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/nodataFound';
        });
        
      }
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getData();

  

  $scope.getModel = function(makeid){
    $scope.modal = "";
    $scope.modalId = '';
    $scope.modelData = "";
    var data = {make_id:makeid};
    $http.post(apiurl+'doApi_master_model',data).then(function(response){
      console.log(response.data);
      $scope.modelData = response.data;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  

  $scope.getVariant = function(modalId){
    $scope.varient = "";
    $scope.varientId = '';
    $scope.variantData = "";
    var data = {model_id:modalId};
    $http.post(apiurl+'doApi_master_variant',data).then(function(response){
      console.log(response.data);
      $scope.variantData = response.data;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getTransmission = function(varientId){
    $scope.transmissionData = "";
    var data = {session_user_id:sid,variant_id:varientId};
    $http.post(apiurl+'api_master_transmissiontype',data).then(function(response){
      console.log(response.data);
      $scope.transmissionData = response.data;
      $scope.bodyType = $scope.transmissionData.Body_type.category_description;
      $scope.transmission = $scope.transmissionData.Transmission_type[0];
      $scope.fuelType = $scope.transmissionData.Fuel_type.fuel_type;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }
 

  /* city data*/
  $scope.getCity = function(){
    $http.get(apiurl+'master_city_get').then(function(response){
      console.log(response.data);
      $scope.cities = response.data[0];
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
      //console.log(response);
    });
  }
  $scope.getCity();

  $scope.getBranch = function(cityId){
    $scope.branch = "";
    $scope.branchId = "";
    $scope.branchData = "";
    var data = {session_user_id:sid,city_id:cityId};
    $http.post(apiurl+'api_master_branchtype',data).then(function(response){
      console.log(response.data);
      $scope.branchData = response.data;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.pickRegister = function(yearId,yearName){
    $scope.registerYear = yearName;
    $scope.registerId = yearId;
    $('#register').modal('close');
  }


  $scope.pickMake = function(makeId,makeName){
    $scope.make = makeName;
    $scope.makeId = makeId;
    $scope.getModel(makeId);
    $('#make').modal('close');
  }

  $scope.pickModal = function(modalId,modalName){
    $scope.modal = modalName;
    $scope.modalId = modalId;
    $scope.getVariant(modalId);
    $('#modal').modal('close');
  }

  $scope.pickVarient = function(varientId,varientName){
    $scope.varient = varientName;
    $scope.varientId = varientId;
    $scope.getTransmission(varientId);
    $('#varient').modal('close');
  }

  $scope.pickBodyType = function(bodyTypeName){
    $scope.bodyType = bodyTypeName;
    $('#bodyType').modal('close');
  }

  $scope.pickOwner = function(ownerId,ownerType){
    $scope.ownership = ownerId;
    $scope.ownershipId = ownerType;
    $('#ownership').modal('close');
  }

  $scope.pickCar = function(carId,carType){
    $scope.carstatus = carType;
    $scope.carstatusId = carId;
    $('#carstatus').modal('close');
  }

  $scope.pickColor = function(colorId,colorName){
    $scope.color = colorName;
    $scope.colorId = colorId;
    $('#color').modal('close');
  }

  $scope.closeCity = function()
  {
    var offset = parseInt(document.body.style.top, 10);
    document.body.classList.remove('modal--opened');
    document.body.scrollTop = (offset * -1);
    $scope.searchCity = '';
    $('#city').modal('close');
  }

  $scope.pickCity = function(cityId,cityName){
    $scope.city = cityName;
    $scope.cityId = cityId;
    $scope.getBranch(cityId);
    $scope.closeCity();
  }

  $scope.pickBranch = function(branchName,branchId){
    $scope.branch = branchName;
    $scope.branchId = branchId;
    $('#branch').modal('close');
  }



  $scope.basicInfoSubmit = function()
  {
    $scope.loader = true;
      $scope.basicInfoData = {'registerYear':$scope.registerYear,'makeId':$scope.makeId,'modalId':$scope.modalId,'vaientId':$scope.varientId,'bodyType':$scope.bodyType,'transmissionId':$scope.transmission,'totalDistance':$scope.tDistance,'millege':$scope.mileage,'ownerShip':$scope.ownership,'carStatusId':$scope.carstatusId,'colorId':$scope.colorId,'cityId':$scope.cityId,'branch':$scope.branchId,'fuelType':$scope.fuelType};

      $scope.basicItemData = {'registerYear':$scope.registerYear,'make':$scope.make,'modal':$scope.modal,'vaient':$scope.varient,'bodyType':$scope.bodyType,'transmissionId':$scope.transmission,'totalDistance':$scope.tDistance,'millege':$scope.mileage,'ownerShip':$scope.ownership,'carStatus':$scope.carstatus,'color':$scope.color,'city':$scope.city,'branch':$scope.branch,'fuelType':$scope.fuelType,'planDetails':$scope.getBasicData.planDetails[0]};
      console.log($scope.basicInfoData);
      editBasicInfoService.basicData = $scope.basicInfoData;
      editBasicInfoService.basicItemData = $scope.basicItemData;
      window.location = '#/EditPriceInfo/'+sid+'/'+cid;
  }

  $scope.back = function()
  {
    window.location = apiurl+'mobileweb/back.html';
  }

  $scope.redirect = function()
  {
    window.location = '#/EditPriceInfo/'+sid+'/'+cid;
  }

  $scope.openCity = function()
  {
    console.log('open city');
    var offset = document.body.scrollTop;
    document.body.style.top = (offset * -1) + 'px';
    document.body.classList.add('modal--opened');
    //$('#city').modal('open');
    //$('#city').modal('open');
  }

  $scope.fetch = function()
  {   
    if($scope.regNum!='' && typeof $scope.regNum!='undefined' )
    {
        $scope.loader = true;
        var data = {session_user_id:sid,registerNumber:$scope.regNum};
        console.log(data);
        $http.post(apiurl+'api_doApifastlanevininfo',data).then(function(response){
          console.log(response.data);
          if(response.data.Result==1)
          {
            $scope.vinlookupData = response.data.VinInfo[0];
            editBasicInfoService.vinlookupData = $scope.vinlookupData;
            $scope.loader = false;
            window.location = '#/vinlookupEdit/'+sid;
          }
          else
          {
            swal("No Data Found. Try again later...");
            $scope.loader = false;
          }
          
        },function(response){
          $scope.loader = false;
          console.log('Service Error');
          swal("Unable to reach server. Try again later...");
        });
    }
    else
    {
      //swal("Please Enter Register number");
      $('.toast').remove()
      var $toastContent = $('<span> Please Enter Registration number </span>');
      Materialize.toast($toastContent, 5000);
    }
  }

  $scope.$watch('mileage', function(newValue, oldValue) {
   
      if($scope.mileage>50)
      {
        //console.log(newValue.substring(from,to));
        $scope.mileage = '';
      }
    
      
  });
  
}]);



DealerApp.controller('inventoryEngineCtrl',['$scope','$http','apiurl','$routeParams',function($scope,$http,apiurl,$routeParams){

	console.log("Inventory Engine information");

  $scope.getEngine = function(){
    $scope.loader = true;
    var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid};
    $http.post(apiurl+'api_doview_enginefeatures',data).then(function(response){
      console.log(response.data);
      $scope.engineData = response.data;
      $scope.loader = false;
    },function(response){
      console.log('Service Error');
      $scope.loader = false;
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.getEngine();

  $scope.back = function()
  {
    window.history.back();
  }

  $scope.saveEngine = function(){
    console.log(1);
    $scope.loader = true;
    var formData = new FormData($("form#engineDetails")[0]);
        formData.append("session_user_id", $routeParams.sid);
        formData.append("car_id", $routeParams.cid);
        var options = { 
              clearForm: true,
              resetForm: true
            };
        
        jQuery.ajax({
          url: apiurl+'api_doAdd_enginefeatures',
          type:'post',
          data:  formData,
          async: false,
          contentType: false,
          processData: false,
          success: function(response) {
            console.log(response);
            $scope.loader = false;
            if(response.Result==1)
            {
                 $scope.getEngine();
                $('.toast').remove();
                var $toastContent = $('<span> The Details has been Saved Successfully. </span>');
                Materialize.toast($toastContent, 5000);
            }
            else
            {
                $('.toast').remove();
                var $toastContent = $('<span> Whoops...! Something went Wrong. Try again later. </span>');
                Materialize.toast($toastContent, 5000);
            }
             
          },
          error: function (jqXHR, exception) {
              $scope.loader = false;
              swal("Unable to reach server. Try again later...");
          },
          
        });
    }

    $scope.next = function()
    {
      window.location = '#/onlinePortal/'+$routeParams.sid+'/'+$routeParams.cid+'/'+1;
    }

	
}]);

DealerApp.controller('inventoryImageCtrl',['$scope','$http', 'basicInfoService', 'apiurl', '$routeParams',function($scope, $http, basicInfoService, apiurl, $routeParams){

	console.log("Inventory basic information");

      $scope.sid = $routeParams.sid;
      $scope.carId = $routeParams.carId;

    $scope.loader = true;
    $scope.$watch('$viewContentLoaded', function()
    {
        $scope.loader = false;
    });
	
    $scope.watermarkPage = function(imageType)
    {
      window.location = '#/wateMarkImage';
      basicInfoService.basicItemData.imageTypeData = imageType;
    }

    $scope.getCarDetailsFun = function(){
      var data = {'session_user_id':$scope.sid,'car_id':$scope.carId};
      $http.post(apiurl+'api_doview_basicinfo',data).then(function(response){
      console.log(response.data);

      if(response.data.Result == 1)
      {
        $scope.basicInfo = response.data.basic_infoimage[0];  
        basicInfoService.basicItemData = {'waterMarkImage':$scope.basicInfo.watermark_logo,'Phno':$scope.basicInfo.mobile,'carId':$scope.carId,'sessionId':$scope.sid,'imageTypeData':''};
      }
      else
      {
        swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = apiurl+'mobileweb/back.html';
        });
      }
      
      },function(response){
        console.log('Service Error');
        swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = apiurl+'mobileweb/back.html';
        });
      });
    }
    $scope.getCarDetailsFun();

    $scope.next = function()
    {
      //window.location = '#/onlinePortal/'+$scope.sid+'/'+$scope.carId+'/'+1;
       basicInfoService.carDetails =  {
                                        'make': $scope.basicInfo.make,
                                        'model': $scope.basicInfo.model,
                                        'Varient': $scope.basicInfo.varient,
                                        'price': $scope.basicInfo.price,
                                        'kms': $scope.basicInfo.kms_done,
                                        'fuel_type': $scope.basicInfo.fuel_type,
                                        'regYear': $scope.basicInfo.registration_year,
                                        'owner': $scope.basicInfo.owner_type,
                                        'city': $scope.basicInfo.city
                                      };
      window.location = '#/inventoryDocument/'+$scope.sid+'/'+$scope.carId;
    }

    $scope.back = function()
  {
    window.location = '#/EditBasicInfo/'+$scope.sid+'/'+$scope.carId;
  }



}]);

DealerApp.controller('watermarkCtrl',['$scope','$http', 'apiurl', 'basicInfoService', '$window',function($scope, $http, apiurl, basicInfoService, $window){

  console.log('image edit');

   $scope.loader = true;
    $scope.$watch('$viewContentLoaded', function()
    {
        $scope.loader = false;
    });

  console.log(basicInfoService.basicItemData);
  $scope.basicData = basicInfoService.basicItemData;

  $scope.positionName = 'Top Right';
  $scope.positionId = 1;
  $scope.phno = '';

  $scope.phno = $scope.basicData.Phno;


  $scope.pickPosition = function(position,positionId)
  {
    $scope.positionName = position;
    $scope.positionId = positionId;
    $('#position').modal('close');
  }

   $scope.uploadImage = function()
   {
      
      //$window.history.back();
      /*var formData = new FormData($("form#imageData")[0]);
      formData.append("position", $scope.position);
      var options = { 
            clearForm: true,
            resetForm: true
          };
      
      jQuery.ajax({
        url: apiurl+'buyer/register',
        type:'post',
        data:  formData,
        async: false,
        contentType: false,
        processData: false,
        success: function(response) {
          console.log(response);
        }
        
      });*/


        var imageData  = $('#imageNew').val();
        if(imageData!='')
        {
          $scope.loader = true;
          var data = {'image':imageData,'number':$scope.phno,'car_id':$scope.basicData.carId,'session_user_id':$scope.basicData.sessionId,'imageTypeData':$scope.basicData.imageTypeData,'position':$scope.positionId,'watermark_logo':$scope.basicData.waterMarkImage};
          console.log(data);
          $http.post(apiurl+'api_doimage_upload',data).then(function(response){
          console.log(response.data);
            if(response.data.Result=='1')
            {
              var $toastContent = $('<span> Image Added Successfully </span>');
              Materialize.toast($toastContent, 5000);
              $window.history.back();
              $scope.loader = false;
            }
            else
            {
              var $toastContent = $('<span> Cant able to add your Image. </span>');
              Materialize.toast($toastContent, 5000);
              $window.history.back();
              $scope.loader = false;
            }
          },function(response){
            console.log('Service Error');
            swal("Unable to reach server. Try again later...");
            $window.history.back();
            $scope.loader = false;
          });
        }
        else
        {
            $('.toast').remove()
            var $toastContent = $('<span> Please Choose Image. </span>');
            Materialize.toast($toastContent, 5000);
        }
    
   }

  

   $scope.close = function()
    {
      $window.history.back();
    }

}]);

DealerApp.controller('inventoryDocumentCtrl',['$scope','$http','$routeParams','apiurl','basicInfoService',function($scope,$http,$routeParams,apiurl,basicInfoService){

	console.log("Inventory document information");

  $scope.additionalDetails = basicInfoService.carDetails;
  console.log($scope.additionalDetails);

	function handleFileSelect(evt) {
		console.log(evt.target.files);
    if(evt.target.files[0].size <= 2097152)
    {
      var files = evt.target.files[0].name; // FileList object
      $("#output"+evt.target.id).html('You Choosed : '+files);
    }
    else
    {
        var file = document.getElementById(evt.target.id);
        file.value = file.defaultValue;
        $('.toast').remove()
        var $toastContent = $('<span> Maximum File Size 2MB. </span>');
        Materialize.toast($toastContent, 5000);
    }
    
  }

document.getElementById('regCer').addEventListener('change', handleFileSelect, false);
document.getElementById('Insurance').addEventListener('change', handleFileSelect, false);
document.getElementById('rto').addEventListener('change', handleFileSelect, false);
document.getElementById('fc').addEventListener('change', handleFileSelect, false);
document.getElementById('noc').addEventListener('change', handleFileSelect, false);
document.getElementById('pd').addEventListener('change', handleFileSelect, false);

$scope.removeDoc = function(id,fileName,position)
{
    var file = document.getElementById(id);
    file.value = file.defaultValue;
    if($scope.viewDocument[position].documentdownload != '')
    {
      $("#output"+id).html('You Choosed : '+$scope.viewDocument[position].documentname);
    }
    else
    {
      $("#output"+id).html('Choose '+fileName);  
    }
    
}

$scope.documentUpload = function()
{
    $scope.loader = true;
    var formData = new FormData($("form#addDocument")[0]);
    console.log($("form#addDocument")[0]);
    formData.append("session_user_id", $routeParams.sid);  
    formData.append("car_id", $routeParams.cid);   
   //console.log(formData);
    var options = { 
                clearForm: true,
                resetForm: true
            };
    
    jQuery.ajax({
      url: apiurl+'api_dodocument_upload',
      type:'post',
      data:  formData,
      async: false,
      contentType: false,
      processData: false,
      success: function(response) {  
        console.log(response);
        $scope.getDocument();
        $scope.loader = false;
        if(response.Result==1)
        {
          $('.toast').remove();
          var $toastContent = $('<span> Files Uploaded Successfully. </span>');
          Materialize.toast($toastContent, 5000);  
        }
        else
        {
          $('.toast').remove();
          var $toastContent = $('<span> Whoops, Try again later. </span>');
          Materialize.toast($toastContent, 5000);  
        }
        
      },
      error: function (jqXHR, exception) {
          $scope.loader = false;
          swal("Unable to reach server. Try again later...");
      },
      
    });  
}

$scope.getDocument = function()
{
  $scope.loader = true;
  var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid}
  $http.post(apiurl+'api_doviewdocument',data).then(function(response){
    console.log(response.data);
    $scope.viewDocument = response.data.basicdocument;
    $scope.loader = false;
  },function(response){
    console.log('Service Error');
    $scope.loader = false;
    swal({
        title: "Unable to reach server. Try again later...",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ok",
        closeOnConfirm: true
      },
      function(){
        window.location = '#/errorPage';
      });
  });  
}
$scope.getDocument();

  $scope.next = function()
  {
    window.location = "#/insurance/"+$routeParams.sid+"/"+$routeParams.cid;
  }

  $scope.back = function()
  {
    window.location = '#/inventoryImage/'+$routeParams.sid+'/'+$routeParams.cid;
  }
	
}]);


DealerApp.controller('pricingInfoCtrl',['$scope','$http', 'apiurl', '$routeParams', 'basicInfoService',function($scope, $http, apiurl, $routeParams, basicInfoService){

	console.log("Inventory pricing information");

  	var fromDate = new Date();
    var isOpen = false;

    var currentTime = new Date();
    $scope.currentTime = currentTime;
    var days = 0;
    $scope.minDate = 0;
    $scope.maxDate = (new Date($scope.currentTime.getTime() + ( 1000 * 60 * 60 *24 * days ))).toISOString();
    console.log('min date'+$scope.minDate+' - max date'+$scope.maxDate);
    $scope.loader = true;
    $scope.$watch('$viewContentLoaded', function()
    {
        $scope.loader = false;
    });

   // $('#basicId').addClass('active');

    sid = $routeParams.sid;
    obj = [];
    $scope.basicInfoData = [];
    $scope.basicInfoData[0] = basicInfoService.basicData;
    //$scope.basicInfoData[0] = {"registerYear":4,"makeId":5,"modalId":166,"vaientId":452,"bodyType":"SEDAN","transmissionId":"Manual","totalDistance":"23","millege":"23432","ownerShip":1,"carStatusId":1,"colorId":13,"cityId":526,"branch":"","fuelType":"Diesel"};
    console.log(JSON.stringify($scope.basicInfoData));
    $scope.basicdataName = basicInfoService.basicItemData;
    console.log(basicInfoService.basicItemData);


    /* choose options initialization */
    $scope.inventoryType = 'own';
    $scope.testswitch = '0';
    /*$scope.ownMarkupBtn = 'option1';
    $scope.parkMarkupBtn = 'option1';*/
    $scope.dealerpoint = '1';
    $scope.doorStep = '1';


    $scope.obj = {ownName: '',ownPrice: '',ownPurchaseDate: '',parkName: '',parkFromDate: '',startingKm: '',fuelIndication: 'NO',customerAskPrice: '',dealerMarkPrice: '',parkKey: 'no',parkDocument: 'no',ownKey: 'no',ownDocument: 'no',ownMarkupBtn: 'option1',parkMarkupBtn: 'option1',parkpercent: '',parkabsolute: '',ownpercent: '',ownabsolute: '',refurbishment:0,transport:0 };

    /* expense*/
    $scope.expenseRow = [];
    $scope.costrow = [];
    row = 0;


  $scope.customerType = function(){
    $http.get(apiurl+'api_master_customertype').then(function(response){
      console.log(response.data);
      $scope.customerTypeData = response.data.nametype;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.customerType();

  data = {
      "Apple": null,
      "Axe": null,
      "Microsoft": null,
      "Google": 'http://placehold.it/250x250',
    }
    console.log(data);

  $scope.getCustomerName = function(customerId){
    obj = [];
    
    var data = {'session_user_id':sid,'customertype':customerId};
    console.log(data);
    $http.post(apiurl+'api_customername',data).then(function(response){
      console.log(response.data);
      $scope.customerName = response.data;
      if($scope.customerName.message.length!=0)
      {
        angular.forEach($scope.customerName.message,function(value,key){
            console.log(value.contact_first_name);
            obj[value.contact_first_name] = null; //Use Bracket notation
        });
        autocomplete(obj);
      }
    },function(response){
      console.log('Service Error');
      swal("Unable to reach server. Try again later...");
    });
  }

  function autocomplete(autocompleteData)
  {
      $('.autocomplete-content').remove();    
      $('input.autocomplete').autocomplete({
        data: autocompleteData
      });  
      /*$('.autocomplete-content').on('click', 'li', function () {            
      $('.autocomplete-content').hide();
          });
      $('input.autocomplete').on('keyup',function(){ $('.autocomplete-content').show();})
*/
    
  }
  
  
  $scope.pickCustomerTypePark = function(customerId,customerName){
    $scope.customerTypePark = customerName;
    $scope.customerTypeParkId = customerId;
    $scope.getCustomerName(customerId);
    $('#parkRecievedFrom').modal('close');
  }

  $scope.pickCustomerTypeOwn = function(customerId,customerName){
    $scope.customerTypeOwn = customerName;
    $scope.customerTypeOwnId = customerId;
    $scope.getCustomerName(customerId);
    $('#ownPurchasedFrom').modal('close');
  }


	$scope.dynamicExpence = function()
	{
		$scope.expenseRow.push({'id':row,'expenseName':'','expensePrice':''});
		row++;
    console.log($scope.expenseRow);
	}
	$scope.dynamicExpence();

  $scope.clearExpence = function()
  {
    $scope.expenseRow = [{'id':0,'expenseName':'','expensePrice':''}];
  }

	$scope.removeExpence = function(position)
	{
		$scope.expenseRow.splice(position,1);
	}

  $scope.priceSubmit = function()
  {
    $scope.loader = true;
    //console.log(JSON.stringify($scope.expenseRow));
    if($scope.inventoryType=='park')
    {
      if($scope.obj.parkMarkupBtn=='option1')
      {
        $scope.markupName = 'option1';
        $scope.markupValue = $scope.obj.parkpercent;
        $scope.markupTotal = $('#ParkmarkupPercent').html();
      }
      else
      {
        $scope.markupName = 'option2';
        $scope.markupValue = $scope.obj.parkabsolute;
        $scope.markupTotal = $('#ParkmarkupAbsolute').html();
      }
      if($scope.testswitch=='1')
      {
        dealerpoint = $scope.dealerpoint;
        doorStep = $scope.doorStep;
      }
      else
      {
        dealerpoint = '0';
        doorStep = '0';
      }
      if($scope.obj.fuelIndication=='YES')
      {
        $scope.fuelindic = 1;
      }
      else
      {
        $scope.fuelindic = 0;
      }
      if($scope.obj.parkKey == 'yes' )
      {
        $scope.pkey = 1;
      }
      else
      {
        $scope.pkey = 0;
      }
      if($scope.obj.parkDocument == 'yes')
      {
        $scope.pdoc = 1;
      }
      else
      {
        $scope.pdoc = 0;
      }
      var markupTotal = $scope.markupTotal;
      markupTotalData = parseInt(markupTotal.replace(/,/g , ""));

      $scope.priceData = {'PricingType':$scope.inventoryType,'customerId':$scope.customerTypePark,'name':$scope.obj.parkName,'fromDate':$scope.obj.parkFromDate,'startingKm':$scope.obj.startingKm,'fuelIndication':$scope.fuelindic,'customerAskingPrice':$scope.obj.customerAskPrice,'dealerPrice':$scope.obj.dealerMarkPrice,'keysRecieved':$scope.pkey,'documentRecieved':$scope.pdoc,'refurbishment':$scope.obj.refurbishment,'transport':$scope.obj.transport,'AddExpense':$scope.expenseRow,'markupName':$scope.markupName,'markupValue':$scope.markupValue,'markupTotal':markupTotalData,'testDrive':$scope.testswitch,'testDrivedealerpoint':dealerpoint,'testDrivedoorstep':doorStep,'session_user_id':sid,'basicData':$scope.basicInfoData};
    }
    else
    {
      
        console.log('1');
        if($scope.obj.ownMarkupBtn=='option1')
        {
          $scope.markupName = 'option1';
          $scope.markupValue = $scope.obj.ownpercent;
          $scope.markupTotal = $('#ownmarkupPercent').html();
        }
        else
        {
          $scope.markupName = 'option2';
          $scope.markupValue = $scope.obj.ownabsolute;
          $scope.markupTotal = $('#ownmarkupAbsolute').html();
        }
        if($scope.testswitch=='1')
        {
          dealerpoint = $scope.dealerpoint;
          doorStep = $scope.doorStep;
        }
        else
        {
          dealerpoint = '0';
          doorStep = '0';
        }
        if($scope.obj.ownKey == 'yes')
        {
          $scope.okey = 1;
        }
        else
        {
          $scope.okey = 0;
        }
        if($scope.obj.ownDocument == 'yes')
        {
          $scope.odoc = 1;
        }
        else
        {
          $scope.odoc = 0;
        }
        var markupTotal = $scope.markupTotal;
        markupTotalData = parseInt(markupTotal.replace(/,/g , ""));
        $scope.priceData = {'PricingType':$scope.inventoryType,'customerId':$scope.customerTypeOwn,'name':$scope.obj.ownName,'purchasePrice':$scope.obj.ownPrice,'purchaseDate':$scope.obj.ownPurchaseDate,'keysRecieved':$scope.okey,'documentRecieved':$scope.odoc,'refurbishment':$scope.obj.refurbishment,'transport':$scope.obj.transport,'AddExpense':$scope.expenseRow,'markupName':$scope.markupName,'markupValue':$scope.markupValue,'markupTotal':markupTotalData,'testDrive':$scope.testswitch,'testDrivedealerpoint':dealerpoint,'testDrivedoorstep':doorStep,'session_user_id':sid,'basicData':$scope.basicInfoData};
     
    }
    var priceDataNew = $scope.priceData;
    console.log(priceDataNew);
    /*$http.post(apiurl+'api_doadd_inventory',data).then(function(response){
      console.log(response.data);
    },function(response){
      console.log(response);
      console.log('Service Error');
    });*/

    $http({
            method: 'POST',
            url: apiurl+'api_doadd_inventory',
            data: priceDataNew,
            headers: {
              'Content-type': 'application/json'
            }
          }).then(function(response){
                console.log(response.data);
                if(response.data.Result == '1')
                {
                  $scope.loader = false;
                  var $toastContent = $('<span> Listing Added Successfully </span>');
                  Materialize.toast($toastContent, 5000);
                  $('#preview').modal('close');
                  window.location =  '#/inventoryImage/'+sid+'/'+response.data.car_id;
                }
                else
                {
                  $scope.loader = false;
                  var $toastContent = $('<span> Operation Failed. Try again later. </span>');
                  Materialize.toast($toastContent, 5000);
                }
              },function(response){
                console.log(response);
                $scope.loader = false;
                swal("Unable to reach server. Try again later...");
              });



  }

  $scope.checkExpence  = function()
  {
   // $('#otherExp').modal('close');
   //console.log($scope.expenseRow);
   $('.toast').remove();
   if($scope.expenseRow.length==1)
   {
      console.log($scope.expenseRow[0].expenseName+' and '+$scope.expenseRow[0].expensePrice);
      if(($scope.expenseRow[0].expenseName=='' || typeof $scope.expenseRow[0].expenseName=='undefined') && ($scope.expenseRow[0].expensePrice=='' || typeof $scope.expenseRow[0].expensePrice=='undefined' ))
      {
        //alert("both null");
        var offset = parseInt(document.body.style.top, 10);
        document.body.classList.remove('modal--opened');
        document.body.scrollTop = (offset * -1);
        $('#otherExp').modal('close');
      }
      else if(
          (($scope.expenseRow[0].expenseName!='' || typeof $scope.expenseRow[0].expenseName!='undefined') && ($scope.expenseRow[0].expensePrice=='' || typeof $scope.expenseRow[0].expensePrice=='undefined' )) || 
          (($scope.expenseRow[0].expenseName=='' || typeof $scope.expenseRow[0].expenseName=='undefined') && ($scope.expenseRow[0].expensePrice!='' || typeof $scope.expenseRow[0].expensePrice!='undefined'))
        )
      {
          var $toastContent = $('<span>Please fill all the fields.</span>');
          Materialize.toast($toastContent, 5000);
      }
      else
      {
        console.log('else');
        var offset = parseInt(document.body.style.top, 10);
        document.body.classList.remove('modal--opened');
        document.body.scrollTop = (offset * -1);
        $('#otherExp').modal('close');
      }
   }
   else
   {
      expenseFlag = true;
      angular.forEach($scope.expenseRow, function(value,key){
        if(($scope.expenseRow[key].expenseName=='' || typeof $scope.expenseRow[key].expenseName=='undefined') || ($scope.expenseRow[key].expensePrice=='' || typeof $scope.expenseRow[key].expensePrice=='undefined') || (($scope.expenseRow[key].expenseName=='' && $scope.expenseRow[key].expensePrice=='') || (typeof $scope.expenseRow[key].expenseName=='undefined' && typeof $scope.expenseRow[key].expensePrice=='undefined') ))
        {
            expenseFlag = false;
        }
      });
      console.log(expenseFlag);
      if(expenseFlag == false)
      {
          var $toastContent = $('<span>Please fill all the fields.</span>');
          Materialize.toast($toastContent, 5000);
      }
      else
      {
        console.log('correct');
        var offset = parseInt(document.body.style.top, 10);
        document.body.classList.remove('modal--opened');
        document.body.scrollTop = (offset * -1);
        $('#otherExp').modal('close');
      }
   }
    
  }

  $scope.BackToBasic = function()
  {
    window.location = '#/basicInfo/'+sid;
  }

  $scope.check = function()
  {
    if($scope.inventoryType=='park')
    {
      if($scope.obj.dealerMarkPrice>0)
      {
        $('#preview').modal('open');
      }
      else
      {
          var $toastContent = $('<span> Dealer Markup Price should be greater than zero. </span>');
          Materialize.toast($toastContent, 5000);
      }
    }
    else
    {
      if($scope.obj.ownPrice>0)
      {
        $('#preview').modal('open');
      }
      else
      {
          var $toastContent = $('<span> Purchase Price should be greater than zero. </span>');
          Materialize.toast($toastContent, 5000);
      }
    }

  }

  $scope.back = function()
  {
    window.location = '#/back';
  }

  $scope.chkPriceModal = function()
  {
    if($scope.basicdataName.planDetails.PlanName=='BASIC')
    {
      swal("Your current package do not have access to this feature, please upgrade the package");
    }
    else if($scope.basicdataName.planDetails.PlanName!='BASIC' && $scope.basicdataName.planDetails.PlanTypeAllow=='Yes')
    {
      swal('You Don`t have Active Subscription, please click "Renew" button to renew the package.');
    }
    else
    {
      $('#chkPrice').modal('open');
    }
  }

  $scope.openExpense = function()
  {
    var offset = document.body.scrollTop;
    document.body.style.top = (offset * -1) + 'px';
    document.body.classList.add('modal--opened');
  }

  /*gokul code*/

  year = $scope.basicInfoData[0].registerYear;

make_id = $scope.basicInfoData[0].makeId;

modal_id = $scope.basicInfoData[0].modalId;

varient_id =  $scope.basicInfoData[0].vaientId;

city = $scope.basicInfoData[0].cityId;

kilometer = $scope.basicInfoData[0].totalDistance;

owner = $scope.basicInfoData[0].ownerShip;

color = $scope.basicInfoData[0].colorId;
var data = {session_user_id:sid,year:year,makeid:make_id,modalid:modal_id,varientid:varient_id,city:city,kilometer:kilometer,owner:owner,color:color};
   
    $http.post(apiurl+'api_doApiibbPrice',data).then(function(response){
      
    //alert("res="+JSON.stringify(response.data));
    $scope.pricedetails = response.data;
    
    
    
    //alert("11="+JSON.stringify(response.data.Result));
    if(response.data.Result=='1')
    {
      
      $scope.private1 = response.data.PriceList[0].ForPrivatePrice[0];
    $scope.private2 = response.data.PriceList[0].ForPrivatePrice[1];
    $scope.private3 = response.data.PriceList[0].ForPrivatePrice[2];
    
    $scope.retail1 = response.data.PriceList[0].ForRetailPrice[0];
    $scope.retail2 = response.data.PriceList[0].ForRetailPrice[1];
    $scope.retail3 = response.data.PriceList[0].ForRetailPrice[2];
    
    $scope.trade1 = response.data.PriceList[0].ForTradeinPrice[0];
    $scope.trade2 = response.data.PriceList[0].ForTradeinPrice[1];
    $scope.trade3 = response.data.PriceList[0].ForTradeinPrice[2];
    
     $scope.cpo1 = response.data.PriceList[0].ForCPOPrice[0];
      $scope.cpo2 = response.data.PriceList[0].ForCPOPrice[1];
     $scope.cpo3 = response.data.PriceList[0].ForCPOPrice[2];
      
      $scope.$watch('$viewContentLoaded', function()
      {
         document.getElementById("tab_show").style.display = "block";
          console.log("view content loaded");
      });
     
     // document.getElementById("tab_show").style.display = "block";
    }
    else
    {
    
      $scope.$watch('$viewContentLoaded', function()
      {
         document.getElementById("nodata").style.display = "block";
          console.log("view content loaded");
      });
     
      
    }
    
    
    },function(response){
      console.log('Service Error');
      swal("Unable to reach server. Try again later...");
    });

    $scope.$watch('obj.parkpercent', function(newValue, oldValue) {
   
      
      if($scope.obj.parkpercent>100)
      { 
        $scope.obj.parkpercent = '';
      }
      
  });

    $scope.$watch('obj.ownpercent', function(newValue, oldValue) {
   
      
      if($scope.obj.ownpercent>100)
      { 
        $scope.obj.ownpercent = '';
      }
      
  });

	
}]);

DealerApp.controller('EditPricingInfoCtrl',['$scope','$http', 'apiurl', '$routeParams', 'editBasicInfoService',function($scope, $http, apiurl, $routeParams, editBasicInfoService){

  console.log("Inventory pricing information");

    var fromDate = new Date();
    var isOpen = false;

    var currentTime = new Date();
    $scope.currentTime = currentTime;
    var days = 0;
    $scope.minDate = 0;
    $scope.maxDate = (new Date($scope.currentTime.getTime() + ( 1000 * 60 * 60 *24 * days ))).toISOString();
    console.log('min date'+$scope.minDate+' - max date'+$scope.maxDate);

    $scope.loader = true;
    $scope.$watch('$viewContentLoaded', function()
    {
        $scope.loader = false;
    });
    $scope.expenseRow = [];
    row = 0;
    console.log(editBasicInfoService.basicEditData);

    $scope.dynamicExpence = function()
    {
      $scope.expenseRow.push({'id':row,'expenseName':'','expensePrice':''});
      row++;
      console.log($scope.expenseRow);
    }

    if(editBasicInfoService.basicEditData.length!=0)
    {
      $scope.inventoryType = editBasicInfoService.basicEditData.inventory_type;
      $scope.testswitch = editBasicInfoService.basicEditData.test_drive;
      $scope.dealerpoint = editBasicInfoService.basicEditData.testdrive_dealerpoint;
      $scope.doorStep = editBasicInfoService.basicEditData.testdrive_doorstep;
      if($scope.inventoryType=='own')
      {
        if(editBasicInfoService.basicEditData.ownkey_received==0)
        {
          $scope.ownkey_received = 'no';
        }
        else
        {
          $scope.ownkey_received = 'yes';
        }
        if(editBasicInfoService.basicEditData.owndocuments_received==0)
        {
          $scope.owndocuments_received = 'no';
        }
        else
        {
          $scope.owndocuments_received = 'yes';
        }
        $scope.obj = {
          ownName: editBasicInfoService.basicEditData.ownreceived_from_name,
          ownPrice: editBasicInfoService.basicEditData.ownpurchased_price,
          ownPurchaseDate: editBasicInfoService.basicEditData.ownpurchase_date,
          ownKey: $scope.ownkey_received,
          ownDocument: $scope.owndocuments_received,
          refurbishment: editBasicInfoService.basicEditData.refurbishment_cost,
          transport: editBasicInfoService.basicEditData.transport_cost,
          ownMarkupBtn: editBasicInfoService.basicEditData.markup_condition,
          parkMarkupBtn: editBasicInfoService.basicEditData.markup_condition,
          ownpercent: editBasicInfoService.basicEditData.markup_percentage,
          ownabsolute: editBasicInfoService.basicEditData.markup_value
        };
          $scope.customerTypeOwn = editBasicInfoService.basicEditData.ownpurchased_from;
          //$scope.expenseRow = editBasicInfoService.basicEditData.otherexpense;
         
      }
      else
      {
       if(editBasicInfoService.basicEditData.keys_available==0)
        {
          $scope.keys_available = 'no';
        }
        else
        {
          $scope.keys_available = 'yes';
        }
        if(editBasicInfoService.basicEditData.documents_received==0)
        {
          $scope.documents_received = 'no';
        }
        else
        {
          $scope.documents_received = 'yes';
        }
        if(editBasicInfoService.basicEditData.fuel_indication==0)
        {
          $scope.fuel_indication = 'NO'
        }
        else
        {
          $scope.fuel_indication = 'YES'
        }

          $scope.obj = {
            parkName: editBasicInfoService.basicEditData.received_from_name,
            parkFromDate: editBasicInfoService.basicEditData.purchase_date,
            startingKm: editBasicInfoService.basicEditData.starting_kms,
            fuelIndication: $scope.fuel_indication,
            customerAskPrice: editBasicInfoService.basicEditData.customer_asking_price,
            dealerMarkPrice: editBasicInfoService.basicEditData.dealer_markup_price,
            parkKey: $scope.keys_available,
            parkDocument: $scope.documents_received,
            refurbishment: editBasicInfoService.basicEditData.refurbishment_cost,
            transport: editBasicInfoService.basicEditData.transport_cost,
            parkMarkupBtn: editBasicInfoService.basicEditData.markup_condition,
            ownMarkupBtn : editBasicInfoService.basicEditData.markup_condition,
            parkpercent: editBasicInfoService.basicEditData.markup_percentage,
            parkabsolute: editBasicInfoService.basicEditData.markup_value
         };
          $scope.customerTypePark = editBasicInfoService.basicEditData.received_from_own;
      }
      if(editBasicInfoService.basicEditData.otherexpense.length==0)
      {
        $scope.dynamicExpence();
      }
      else
      {
        $scope.expenseRow = editBasicInfoService.basicEditData.otherexpense;
        console.log($scope.expenseRow);
      }
      
    }
    else
    {
      swal({
          title: "No Data Found..!",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/nodataFound';
        });
    }

    sid = $routeParams.sid;
    cid = $routeParams.cid;
    obj = [];
    $scope.basicInfoData = [];
    $scope.basicInfoData[0] = editBasicInfoService.basicData;
    //$scope.basicInfoData[0] = {"registerYear":4,"makeId":5,"modalId":166,"vaientId":452,"bodyType":"SEDAN","transmissionId":"Manual","totalDistance":"23","millege":"23432","ownerShip":1,"carStatusId":1,"colorId":13,"cityId":526,"branch":"","fuelType":"Diesel"};
    console.log(JSON.stringify($scope.basicInfoData));
    $scope.basicdataName = editBasicInfoService.basicItemData;
    //console.log(JSON.stringify(basicInfoService.basicData));


    /* choose options initialization */
   /* $scope.inventoryType = 'own';
    $scope.testswitch = '0';*/
    /*$scope.ownMarkupBtn = 'option1';
    $scope.parkMarkupBtn = 'option1';*/
    


    

    /* expense*/
    


  $scope.customerType = function(){
    $http.get(apiurl+'api_master_customertype').then(function(response){
      console.log(response.data);
      $scope.customerTypeData = response.data.nametype;
    },function(response){
      console.log('Service Error');
      swal({
          title: "Unable to reach server. Try again later...",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = '#/errorPage';
        });
    });
  }

  $scope.customerType();

  

  $scope.getCustomerName = function(customerId){
    obj = [];
    
    var data = {'session_user_id':sid,'customertype':customerId};
    console.log(data);
    $http.post(apiurl+'api_customername',data).then(function(response){
      console.log(response.data);
      $scope.customerName = response.data;
      if($scope.customerName.message.length!=0)
      {
        angular.forEach($scope.customerName.message,function(value,key){
            console.log(value.contact_first_name);
            obj[value.contact_first_name] = null; //Use Bracket notation
        });
        autocomplete(obj);
      }
    },function(response){
      console.log('Service Error');
      swal("Unable to reach server. Try again later...");
    });
  }

  function autocomplete(autocompleteData)
  {
      $('.autocomplete-content').remove();    
      $('input.autocomplete').autocomplete({
        data: autocompleteData
      });  
      /*$('.autocomplete-content').on('click', 'li', function () {            
      $('.autocomplete-content').hide();
          });
      $('input.autocomplete').on('keyup',function(){ $('.autocomplete-content').show();})
*/
    
  }
  
  
  $scope.pickCustomerTypePark = function(customerId,customerName){
    $scope.customerTypePark = customerName;
    $scope.customerTypeParkId = customerId;
    $scope.getCustomerName(customerId);
    $('#parkRecievedFrom').modal('close');
  }

  $scope.pickCustomerTypeOwn = function(customerId,customerName){
    $scope.customerTypeOwn = customerName;
    $scope.customerTypeOwnId = customerId;
    $scope.getCustomerName(customerId);
    $('#ownPurchasedFrom').modal('close');
  }


  
  

  $scope.clearExpence = function()
  {
    $scope.expenseRow = [{'id':0,'expenseName':'','expensePrice':''}];
  }

  $scope.removeExpence = function(position)
  {
    $scope.expenseRow.splice(position,1);
  }

  $scope.priceSubmit = function()
  {console.log($scope.basicInfoData);
    
    //console.log(JSON.stringify($scope.expenseRow));
    if($scope.inventoryType=='park')
    {
      if($scope.obj.parkMarkupBtn=='option1')
      {
        $scope.markupName = 'option1';
        $scope.markupValue = $scope.obj.parkpercent;
        $scope.markupTotal = $('#ParkmarkupPercent').html();
      }
      else
      {
        $scope.markupName = 'option2';
        $scope.markupValue = $scope.obj.parkabsolute;
        $scope.markupTotal = $('#ParkmarkupAbsolute').html();
      }
      if($scope.testswitch=='1')
      {
        dealerpoint = $scope.dealerpoint;
        doorStep = $scope.doorStep;
      }
      else
      {
        dealerpoint = '0';
        doorStep = '0';
      }
      if($scope.obj.fuelIndication=='YES')
      {
        $scope.fuelindic = 1;
      }
      else
      {
        $scope.fuelindic = 0;
      }
      if($scope.obj.parkKey == 'yes' )
      {
        $scope.pkey = 1;
      }
      else
      {
        $scope.pkey = 0;
      }
      if($scope.obj.parkDocument == 'yes')
      {
        $scope.pdoc = 1;
      }
      else
      {
        $scope.pdoc = 0;
      }
      $scope.priceData = {'PricingType':$scope.inventoryType,'customerId':$scope.customerTypePark,'name':$scope.obj.parkName,'fromDate':$scope.obj.parkFromDate,'startingKm':$scope.obj.startingKm,'fuelIndication':$scope.fuelindic,'customerAskingPrice':$scope.obj.customerAskPrice,'dealerPrice':$scope.obj.dealerMarkPrice,'keysRecieved':$scope.pkey,'documentRecieved':$scope.pdoc,'refurbishment':$scope.obj.refurbishment,'transport':$scope.obj.transport,'AddExpense':$scope.expenseRow,'markupName':$scope.markupName,'markupValue':$scope.markupValue,'markupTotal':$scope.markupTotal,'testDrive':$scope.testswitch,'testDrivedealerpoint':dealerpoint,'testDrivedoorstep':doorStep,'session_user_id':sid,'basicData':$scope.basicInfoData,'carid':cid};
    }
    else
    {
      if($scope.obj.ownMarkupBtn=='option1')
      {
        $scope.markupName = 'option1';
        $scope.markupValue = $scope.obj.ownpercent;
        $scope.markupTotal = $('#ownmarkupPercent').html();
      }
      else
      {
        $scope.markupName = 'option2';
        $scope.markupValue = $scope.obj.ownabsolute;
        $scope.markupTotal = $('#ownmarkupAbsolute').html();
      }
      if($scope.testswitch=='1')
      {
        dealerpoint = $scope.dealerpoint;
        doorStep = $scope.doorStep;
      }
      else
      {
        dealerpoint = '0';
        doorStep = '0';
      }
      if($scope.obj.ownKey == 'yes')
      {
        $scope.okey = 1;
      }
      else
      {
        $scope.okey = 0;
      }
      if($scope.obj.ownDocument == 'yes')
      {
        $scope.odoc = 1;
      }
      else
      {
        $scope.odoc = 0;
      }
      $scope.priceData = {'PricingType':$scope.inventoryType,'customerId':$scope.customerTypeOwn,'name':$scope.obj.ownName,'purchasePrice':$scope.obj.ownPrice,'purchaseDate':$scope.obj.ownPurchaseDate,'keysRecieved':$scope.okey,'documentRecieved':$scope.odoc,'refurbishment':$scope.obj.refurbishment,'transport':$scope.obj.transport,'AddExpense':$scope.expenseRow,'markupName':$scope.markupName,'markupValue':$scope.markupValue,'markupTotal':$scope.markupTotal,'testDrive':$scope.testswitch,'testDrivedealerpoint':dealerpoint,'testDrivedoorstep':doorStep,'session_user_id':sid,'basicData':$scope.basicInfoData,'carid':cid};
    }
    var priceDataNew = $scope.priceData;
    console.log(priceDataNew);
    /*$http.post(apiurl+'api_doadd_inventory',data).then(function(response){
      console.log(response.data);
    },function(response){
      console.log(response);
      console.log('Service Error');
    });*/
    $scope.loader = true;
    $http({
            method: 'POST',
            url: apiurl+'api_doupdate_inventory',
            data: priceDataNew,
            headers: {
              'Content-type': 'application/json'
            }
          }).then(function(response){
                console.log(response.data);
                if(response.data.Result == '1')
                {
                  $scope.loader = false;
                  var $toastContent = $('<span> Listing Updated Successfully </span>');
                  Materialize.toast($toastContent, 5000);
                  $('#preview').modal('close');
                  editBasicInfoService.basicData = [];
                  window.location =  '#/inventoryImage/'+sid+'/'+cid;
                }
                else
                {
                  $scope.loader = false;
                  var $toastContent = $('<span> Operation Failed. Try again later. </span>');
                  Materialize.toast($toastContent, 5000);
                }
              },function(response){
                console.log(response);
                $scope.loader = false;
                swal("Unable to reach server. Try again later...");
              });



  }

  $scope.BackToBasic = function()
  {
    window.location = '#/EditBasicInfo/'+sid+'/'+cid;
  }

  $scope.checkExpence  = function()
  {
   // $('#otherExp').modal('close');
   //console.log($scope.expenseRow);
   $('.toast').remove();
   if($scope.expenseRow.length==1)
   {
      console.log($scope.expenseRow[0].expenseName+' and '+$scope.expenseRow[0].expensePrice);
      if(($scope.expenseRow[0].expenseName=='' || typeof $scope.expenseRow[0].expenseName=='undefined') && ($scope.expenseRow[0].expensePrice=='' || typeof $scope.expenseRow[0].expensePrice=='undefined' ))
     {
      //alert("both null");
      var offset = parseInt(document.body.style.top, 10);
        document.body.classList.remove('modal--opened');
        document.body.scrollTop = (offset * -1);
        $('#otherExp').modal('close');
     }
    
        else if(
            (($scope.expenseRow[0].expenseName!='' || typeof $scope.expenseRow[0].expenseName!='undefined') && ($scope.expenseRow[0].expensePrice=='' || typeof $scope.expenseRow[0].expensePrice=='undefined' )) || 
            (($scope.expenseRow[0].expenseName=='' || typeof $scope.expenseRow[0].expenseName=='undefined') && ($scope.expenseRow[0].expensePrice!='' || typeof $scope.expenseRow[0].expensePrice!='undefined'))
          )
        {
            var $toastContent = $('<span>Please fill all the fields.</span>');
            Materialize.toast($toastContent, 5000);
        }
        else
        {
          console.log('else');
          var offset = parseInt(document.body.style.top, 10);
          document.body.classList.remove('modal--opened');
          document.body.scrollTop = (offset * -1);
          $('#otherExp').modal('close');
        }
   }
   else
   {
      expenseFlag = true;
      angular.forEach($scope.expenseRow, function(value,key){
        if(($scope.expenseRow[key].expenseName=='' || typeof $scope.expenseRow[key].expenseName=='undefined') || ($scope.expenseRow[key].expensePrice=='' || typeof $scope.expenseRow[key].expensePrice=='undefined') || (($scope.expenseRow[key].expenseName=='' && $scope.expenseRow[key].expensePrice=='') || (typeof $scope.expenseRow[key].expenseName=='undefined' && typeof $scope.expenseRow[key].expensePrice=='undefined') ))
        {
            expenseFlag = false;
        }
      });
      console.log(expenseFlag);
      if(expenseFlag == false)
      {
          var $toastContent = $('<span>Please fill all the fields.</span>');
          Materialize.toast($toastContent, 5000);
      }
      else
      {
        console.log('correct');
        var offset = parseInt(document.body.style.top, 10);
        document.body.classList.remove('modal--opened');
        document.body.scrollTop = (offset * -1);
        $('#otherExp').modal('close');
      }
   }
    
  }

  $scope.check = function()
  {
    if($scope.inventoryType=='park')
    {
      if($scope.obj.dealerMarkPrice>0)
      {
        $('#preview').modal('open');
      }
      else
      {
          var $toastContent = $('<span> Dealer Markup Price should be greater than zero. </span>');
          Materialize.toast($toastContent, 5000);
      }
    }
    else
    {
      if($scope.obj.ownPrice>0)
      {
        $('#preview').modal('open');
      }
      else
      {
          var $toastContent = $('<span> Purchase Price should be greater than zero. </span>');
          Materialize.toast($toastContent, 5000);
      }
    }
  }

  $scope.back = function()
  {
    window.location = '#/back';
  }

  $scope.chkPriceModal = function()
  {
    if($scope.basicdataName.planDetails.PlanName=='BASIC')
    {
      swal("Your current package do not have access to this feature, please upgrade the package");
    }
    else if($scope.basicdataName.planDetails.PlanName!='BASIC' && $scope.basicdataName.planDetails.PlanTypeAllow=='Yes')
    {
      swal('You Don`t have Active Subscription, please click "Renew" button to renew the package.');
    }
    else
    {
      $('#chkPrice').modal('open');
    }
  }

  $scope.$watch('obj.parkpercent', function(newValue, oldValue) {
   
      
      if($scope.obj.parkpercent>100)
      { 
        $scope.obj.parkpercent = '';
      }
      
  });

    $scope.$watch('obj.ownpercent', function(newValue, oldValue) {
   
      
      if($scope.obj.ownpercent>100)
      { 
        $scope.obj.ownpercent = '';
      }
      
  });

  $scope.openExpense = function()
  {
    var offset = document.body.scrollTop;
    document.body.style.top = (offset * -1) + 'px';
    document.body.classList.add('modal--opened');
  }

  /*gokul code*/

  year = $scope.basicInfoData[0].registerYear;

make_id = $scope.basicInfoData[0].makeId;

modal_id = $scope.basicInfoData[0].modalId;

varient_id =  $scope.basicInfoData[0].vaientId;

city = $scope.basicInfoData[0].cityId;

kilometer = $scope.basicInfoData[0].totalDistance;

owner = $scope.basicInfoData[0].ownerShip;

color = $scope.basicInfoData[0].colorId;
var data = {session_user_id:sid,year:year,makeid:make_id,modalid:modal_id,varientid:varient_id,city:city,kilometer:kilometer,owner:owner,color:color};
   
    $http.post(apiurl+'api_doApiibbPrice',data).then(function(response){
      
    //alert("res="+JSON.stringify(response.data));
    $scope.pricedetails = response.data;
    
    
    
    //alert("11="+JSON.stringify(response.data.Result));
    if(response.data.Result=='1')
    {
      
      $scope.private1 = response.data.PriceList[0].ForPrivatePrice[0];
    $scope.private2 = response.data.PriceList[0].ForPrivatePrice[1];
    $scope.private3 = response.data.PriceList[0].ForPrivatePrice[2];
    
    $scope.retail1 = response.data.PriceList[0].ForRetailPrice[0];
    $scope.retail2 = response.data.PriceList[0].ForRetailPrice[1];
    $scope.retail3 = response.data.PriceList[0].ForRetailPrice[2];
    
    $scope.trade1 = response.data.PriceList[0].ForTradeinPrice[0];
    $scope.trade2 = response.data.PriceList[0].ForTradeinPrice[1];
    $scope.trade3 = response.data.PriceList[0].ForTradeinPrice[2];
    
     $scope.cpo1 = response.data.PriceList[0].ForCPOPrice[0];
      $scope.cpo2 = response.data.PriceList[0].ForCPOPrice[1];
     $scope.cpo3 = response.data.PriceList[0].ForCPOPrice[2];
      
      $scope.$watch('$viewContentLoaded', function()
      {
         document.getElementById("tab_show").style.display = "block";
          console.log("view content loaded");
      });
     
     // document.getElementById("tab_show").style.display = "block";
    }
    else
    {
    
      $scope.$watch('$viewContentLoaded', function()
      {
         document.getElementById("nodata").style.display = "block";
          console.log("view content loaded");
      });
    }
    
    
    },function(response){
      console.log('Service Error');
      swal("Unable to reach server. Try again later...");
    });



  
}]);


DealerApp.controller('onlinePortalCtrl',['$scope','$http', 'apiurl', '$routeParams', '$window',function($scope, $http, apiurl, $routeParams, $window){

  console.log('online portal');

  $scope.listing = true;

  $scope.loader = true;
  $scope.$watch('$viewContentLoaded', function()
  {
      $scope.loader = false;
  });

  $scope.savePost = function()
  {
     $scope.loader = true;
    var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid,'dealer_selection':'listing'};
    console.log(data);
    $http.post(apiurl+'api_dolisting_submit',data).then(function(response){
      console.log(response.data);
       $scope.loader = false;
       /*if(response.data.Result==0)
       {
        swal(response.data.message);
       }
       else
       {
        swal(response.data.message);
          setTimeout(function(){ 
              window.location = '#/back';
           }, 2000);
         
       }*/
       swal({
          title: response.data.message,
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = apiurl+'mobileweb/back.html';
        });
       
    },function(response){
      $scope.loader = false;
      swal({
          title: 'Unable to reach server. Try again later...',
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = apiurl+'mobileweb/back.html';
        });
      console.log('Service Error');
    });
  }

  $scope.CheckPrice = function()
  {
    var data = {'session_user_id':$routeParams.sid,'car_id':$routeParams.cid};
    console.log(data);
    $http.post(apiurl+'api_dolisting_submit_checkprice',data).then(function(response){
      console.log(response.data);
      if(response.data.price<=0)
      {
       swal({
          title: 'Sale Price should be greater than zero',
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
         
        });
     }
       
    },function(response){
      $scope.loader = false;
      swal({
          title: 'Unable to reach server. Try again later...',
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ok",
          closeOnConfirm: true
        },
        function(){
          window.location = apiurl+'mobileweb/back.html';
        });
      console.log('Service Error');
    });
  }

  $scope.CheckPrice();

    $scope.close = function()
    {
      $window.history.back();
    }

    $scope.back = function()
    {
      if($routeParams.pageId == 1)
      {
        //window.location = '#/inventoryEngine/'+$routeParams.sid+'/'+$routeParams.cid;
         window.history.back();
      }
      else
      {
        window.location = apiurl+'mobileweb/back.html';  
      }
      
    }

}]);

DealerApp.filter('ownPercentage', function () {
    return function (dydata,ownPrice,refurbishment,transport,ownpercent) {       
      var data = 0; 
      var totalSum = 0;
      if(ownPrice=='' || typeof ownPrice=="undefined")
      {
        ownPrice = 0;
      }
      if(refurbishment=='' || typeof refurbishment=="undefined")
      {
        refurbishment = 0;
      }
       if(transport=='' || typeof transport=="undefined")
      {
        transport = 0;
      }
       if(ownpercent=='' || typeof ownpercent=="undefined")
      {
        ownpercent = 0;
      }
      /*if(ownPrice!=0 && ownpercent!=0)
      {*/
      angular.forEach(dydata, function(value,key){
        if(typeof value.expenseName != "undefined" && typeof value.expensePrice != "undefined")
        {
          if(value.expensePrice!='')
          {
            totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
          }
        }
        
      });
      var data = (parseInt(ownPrice) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum)) + ((parseInt(ownPrice) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum)) * (parseFloat(ownpercent) / 100));

    // }


   /*var data = 0; 
   var totalSum = 0;
    if((typeof dydata != "undefined" && typeof ownPrice != "undefined" && typeof refurbishment != "undefined" && typeof transport != "undefined" && typeof ownpercent != "undefined" ) && ( dydata != "" &&  ownPrice != "" &&  refurbishment != "" &&  transport != "" &&  ownpercent != "" ) )
      {
        angular.forEach(dydata, function(value,key){
          console.log(value);
          if(isNaN(value.expensePrice))
          {
            
            totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
             
          }
          else
          {
          
            totalSum = 0;
          }
        });
        var data = (parseInt(ownPrice) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum)) + ((parseInt(ownPrice) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum)) * (parseFloat(ownpercent) / 100));
        console.log(totalSum);
    }
    if(isNaN(data))
    {
      data = 0;
    }*/
    return data;
    }
});

DealerApp.filter('ownAbsolute', function () {
    return function (dydata,ownPrice,refurbishment,transport,ownabsolute) {       
   var data = 0; 
   var totalSum = 0;
   if(ownPrice=='' || typeof ownPrice=="undefined")
    {
      ownPrice = 0;
    }
    if(refurbishment=='' || typeof refurbishment=="undefined")
    {
      refurbishment = 0;
    }
     if(transport=='' || typeof transport=="undefined")
    {
      transport = 0;
    }
     if(ownabsolute=='' || typeof ownabsolute=="undefined")
    {
      ownabsolute = 0;
    }
    /*if(ownPrice!=0 && ownabsolute!=0)
    {*/
        angular.forEach(dydata, function(value,key){
          if(typeof value.expenseName != "undefined" && typeof value.expensePrice != "undefined")
          {
            if(value.expensePrice!='')
            {
              totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
            }
          }
      });
      var data = parseInt(ownPrice) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum) + parseInt(ownabsolute);
   // }
    /*if((typeof dydata != "undefined" && typeof ownPrice != "undefined" && typeof refurbishment != "undefined" && typeof transport != "undefined" && typeof ownabsolute != "undefined" ) && ( dydata != "" &&  ownPrice != "" &&  refurbishment != "" &&  transport != "" &&  ownabsolute != "" ) )
    {
        angular.forEach(dydata, function(value,key){
          if(isNaN(value.expensePrice))
          {
          totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
          }
          else
          {
          
            totalSum = 0;
          }
        });
        var data = parseInt(ownPrice) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum) + parseInt(ownabsolute);
        console.log(totalSum);
    }*/
    return data;
    }
});

DealerApp.filter('parkPercent', function () {
    return function (dydata,price,refurbishment,transport,parkpercent) {       
   var data = 0; 
   var totalSum = 0;
   if(price=='' || typeof price=="undefined")
    {
      price = 0;
    }
    if(refurbishment=='' || typeof refurbishment=="undefined")
    {
      refurbishment = 0;
    }
     if(transport=='' || typeof transport=="undefined")
    {
      transport = 0;
    }
     if(parkpercent=='' || typeof parkpercent=="undefined")
    {
      parkpercent = 0;
    }
    /*if(price!=0 && parkpercent!=0)
    {*/
        angular.forEach(dydata, function(value,key){
          if(typeof value.expenseName != "undefined" && typeof value.expensePrice != "undefined")
          {
            if(value.expensePrice!='')
            {
              totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
            }
          }
        });
        var ps_cost = (parseInt(price) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum));
        var profit = ps_cost * (parseFloat(parkpercent) / 100);
        var data = ps_cost + profit;
    //}
    /*if((typeof dydata != "undefined" && typeof price != "undefined" && typeof refurbishment != "undefined" && typeof transport != "undefined" && typeof parkpercent != "undefined" ) && ( dydata != "" &&  price != "" &&  refurbishment != "" &&  transport != "" &&  parkpercent != "" ) )
    {
        angular.forEach(dydata, function(value,key){
          totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
        });
        var ps_cost = (parseInt(price) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum));
        var profit = ps_cost * (parseFloat(parkpercent) / 100);
        var data = ps_cost + profit;
    }*/
    return data;
    }
});

DealerApp.filter('parkAbsolute', function () {
    return function (dydata,price,refurbishment,transport,parkabsolute) {       
   var data = 0; 
   var totalSum = 0;
   if(price=='' || typeof price=="undefined")
    {
      price = 0;
    }
    if(refurbishment=='' || typeof refurbishment=="undefined")
    {
      refurbishment = 0;
    }
     if(transport=='' || typeof transport=="undefined")
    {
      transport = 0;
    }
     if(parkabsolute=='' || typeof parkabsolute=="undefined")
    {
      parkabsolute = 0;
    }
    /*if(price!=0 && parkabsolute!=0)
    {*/
        angular.forEach(dydata, function(value,key){
          if(typeof value.expenseName != "undefined" && typeof value.expensePrice != "undefined")
          {
            if(value.expensePrice!='')
            {
              totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
            }
          }
        });
        var data = parseInt(price) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum) + parseInt(parkabsolute);
    //}
   /* if((typeof dydata != "undefined" && typeof price != "undefined" && typeof refurbishment != "undefined" && typeof transport != "undefined" && typeof parkabsolute != "undefined" ) && ( dydata != "" &&  price != "" &&  refurbishment != "" &&  transport != "" &&  parkabsolute != "" ) )
    {
        angular.forEach(dydata, function(value,key){
          totalSum = parseInt(totalSum)+parseInt(value.expensePrice);
        });
        var data = parseInt(price) + parseInt(refurbishment) + parseInt(transport) + parseInt(totalSum) + parseInt(parkabsolute);
    }*/
    return data;
    }
});

DealerApp.filter('sumExpense', function () {
    return function (expenseData) {       
   var totalSum = 0;
    if((typeof expenseData != "undefined" &&  expenseData !='') )
    {
        angular.forEach(expenseData, function(value,key){
          if(typeof value.expenseName != "undefined" && typeof value.expensePrice != "undefined")
          {
            if(value.expensePrice!='')
            {
              
              totalSum = parseInt(totalSum,10)+parseInt(value.expensePrice,10);
            }
          }
        });
        
    }
    
    return totalSum;
    }
});


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



DealerApp.directive('basicForm', function () {
    return {
        restrict: 'A',
        link: function (scope, elem) {

            // set up event handler on the form element
            elem.on('submit', function () {

                // find the first invalid element
                var firstInvalid = elem[0].querySelector('.ng-invalid');
                console.log(firstInvalid);
                
                // if we find one, set focus
                if (firstInvalid) {
                    firstInvalid.focus();
                    var $toastContent = $('<span> Please Enter '+firstInvalid.id+'. </span>');
                    Materialize.toast($toastContent, 2000);
                }
            });
        }
    };
});

DealerApp.directive('priceForm', function () {
    return {
        restrict: 'A',
        link: function (scope, elem) {

            // set up event handler on the form element
            elem.on('submit', function () {

                // find the first invalid element
                var firstInvalid = elem[0].querySelector('.ng-invalid');
                console.log(firstInvalid);
                
                // if we find one, set focus
                if (firstInvalid) {
                    firstInvalid.focus();
                    var $toastContent = $('<span> Please Enter '+firstInvalid.name+'. </span>');
                    Materialize.toast($toastContent, 2000);
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

DealerApp.run(function($rootScope, $templateCache) {
   $rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
   });
});

DealerApp.filter('roundup', function () {
    return function (value) {
        return Math.ceil(value);
    };
});

/*DealerApp.run(function ($window, $timeout) {
    if(/Android/.test(navigator.appVersion)) {
   window.addEventListener("resize", function() {
     if(document.activeElement.tagName=="INPUT" || document.activeElement.tagName=="TEXTAREA") {
       document.activeElement.scrollIntoView();
     }
  })
} 
});*/