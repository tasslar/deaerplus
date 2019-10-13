webChat.controller('buyCtrl',['$scope', '$http', '$routeParams', '$location', '$anchorScroll', '$timeout', '$q', 'apiurl',function($scope, $http, $routeParams, $location, $anchorScroll, $timeout, $q, apiurl){

	console.log("conversation controller");
    
        //buy page
	$scope.data_set = [];


	conversationId = $routeParams.cid;
	$scope.userId = $routeParams.uid;
    $scope.cid  = $routeParams.cid;

	$scope.items = [];
 	pageNo = -1;
 	$scope.conversationDataRf = [];
 	$scope.conversationData = [];

    $scope.sendMessageData = '';
    $scope.flag = false;

 	$scope.gotoBottom = function() {
	      // set the location.hash to the id of
	      // the element you wish to scroll to.
	      $location.hash('bottom');
	      console.log('bottom');
	      // call $anchorScroll()
	      console.log('bottom');
	      $anchorScroll();
	    };

	$scope.getDetails = function(){
		var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId};
		$http.post(apiurl+'api_queries_chat',data).then(function(response){
			console.log(response.data);
			$scope.userDetails = response.data.queries_list[0];

		},function(response){
			console.log('Service Error');
            swal("Unable to reach server. Try again later..");
		});
	}
	$scope.getDetails();

    /*$scope.getdata = function(page){

        var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId,'page_no':1};
        $http.post('http://52.221.57.201/dev/api_queries_chatrefresh',data).then(function(response){
			//console.log(response.data.queries_list);
			$scope.conversationData = response.data.queries_list;
			$scope.loader = false;
		},function(response){
			console.log('Service Error');
		});
        
	}*/

	

	$scope.getdataRf = function(){

        var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId,'page_no':0};
        //console.log(data);
        $http.post(apiurl+'api_queries_chatrefresh',data).then(function(response){
			//console.log(response.data.queries_list);
			$scope.conversationDataRf = response.data.queries_list;
			$scope.loader = false;

		},function(response){
			console.log('Service Error');
            swal("Unable to reach server. Try again later..");
		});
        
	}

	$scope.$watch('conversationDataRf', function(newValue, oldValue){
		console.log($scope.conversationDataRf);
    	console.log('being watched oldValue:', oldValue, 'newValue:', newValue);
    	var lastValue = newValue[newValue.length-1];

    	//console.log(lastValue);
        if((oldValue=='' && newValue!='') ||  (oldValue[0].id!=newValue[0].id))
        {
            console.log('enter');
        	if(oldValue.length==0)
        	{
                console.log(newValue);
    	    	angular.forEach(newValue,function(value,key){
    	    		//console.log(value);
    	    		$scope.items.unshift({'message':value.message,'user_id':value.user_id,'date':value.time});
    	    	});
                $scope.flag = true;
                $scope.status.mainLoader = false;
        	}
        	else
        	{
        		console.log(newValue);
        		$scope.items.push({'message':newValue[0].message,'user_id':newValue[0].user_id,'date':newValue[0].time});
                $scope.flag = true;
                $scope.status.mainLoader = false;
        	}
            console.log($scope.items);

        }
        else
        {
           // alert('same');
           console.log('same');
        }

    	//console.log($scope.items);
  	}, true);

  	$scope.fun = function()
  	{
  		for (var i = 0; i < 10; i++) {
  			$scope.items.push({'message':'hia','user_id':205});
  		}
  	}

  	$scope.status = {
        loading: false,
        loaded: false,
        lastMessage: false,
        mainLoader: true
    };
  	var counter = 0;
  	var counters = 0
    $scope.loadMore = function() {
        var deferred = $q.defer();
        if (!$scope.status.loading && $scope.flag) {
        	counters += 1;
        	console.log(counters);
            $scope.status.loading = true;
            // simulate an ajax request
            /*$timeout(function() {
                for (var i = 0; i < 5; i++) {
                    $scope.items.unshift({'message':'hia','user_id':205});
                    counter += 10;
                }
                $scope.status.loading = false;
                $scope.status.loaded = ($scope.items.length > 0);
                deferred.resolve();
            }, 1000);*/

            var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId,'page_no':counters};
	        $http.post(apiurl+'api_queries_chatrefresh',data).then(function(response){
				console.log(response.data);
				if(response.data.Result==1)
				{	
					$scope.conversationData = response.data.queries_list;
				}
				else
				{
					$scope.status.lastMessage = true;
				}
				/*angular.forEach(response.data.queries_list,function(value,key){
					$scope.items.push({'message':value.message,'user_id':value.user_id});
				});*/
				
                $scope.status.loaded = ($scope.items.length > 0);
                deferred.resolve();
			},function(response){
				console.log('Service Error');
                swal("Unable to reach server. Try again later..");
			});
        } else {
            deferred.reject();
        }
        return deferred.promise;
    };


    $scope.$watch('conversationData', function(newValue, oldValue){
        /*console.log($scope.conversationData);
        console.log('being watched oldValue:', oldValue, 'newValue:', newValue);*/
        angular.forEach(newValue,function(value,key){
            $scope.items.unshift({'message':value.message,'user_id':value.user_id,'date':value.time});
        });
        window.scrollBy(0, 500);
        $scope.status.loading = false;
        //console.log($scope.items);
    }, true);

    /*window.onscroll = function(ev)
{
	var B= document.body; //IE 'quirks'
        var D= document.documentElement; //IE with doctype
        D= (D.clientHeight)? D: B;
	
	if (D.scrollTop == 0)
		{
			alert("top");
		}        
};*/


    /*$scope.loadMore = function() {
    	$scope.loader = true;
    	pageNo = pageNo+1;
    	console.log('loading = '+pageNo);
       	//$scope.getdata(pageNo);
       	$scope.fun();
    };*/
    //$scope.loadMore();
    
    //$scope.getdataRf();
	setInterval(function() {
  		
  		$scope.getdataRf();
	}, 2500);

	$scope.sendMessage = function()
	{
        if($scope.sendMessageData!='')
        {
    		var data = {'session_user_id':$scope.userId,'contact_transactioncode':$scope.userDetails.contact_transactioncode,'car_id':$scope.userDetails.car_id,'from_dealer_name':$scope.userDetails.from_dealer_name,'fromdealerid':$scope.userDetails.fromdealerid,'to_dealer_name':$scope.userDetails.to_dealer_name,'to_dealer_id':$scope.userDetails.to_dealer_id,'message':$scope.sendMessageData,'mobile':$scope.userDetails.mobile,'notification_type_id':2,'make':$scope.userDetails.make};
    		$scope.sendMessageData = '';
    		console.log(data);
    		$http.post(apiurl+'api_queries_chatinsert',data).then(function(response){
    			//console.log(response.data);
    			$scope.sendMessageData = '';
    			$scope.getdataRf();
    			
    		},function(response){
    			console.log('Service Error');
                swal("Unable to reach server. Try again later..");
    			//$scope.getdataRf();
    		});
        }
        else
        {
            console.log('no message');
        }
	}

	//buy page
    
    $scope.goToCarView = function()
    {
        transactinId  = conversationId+':buy';
        window.location = apiurl+'mobileweb/carview/index.html#/carview/'+$scope.userId+'/'+$scope.userDetails.car_id+'/'+transactinId;
    }

    $scope.back = function()
    {
        window.location = apiurl+'mobileweb/back.html';
    }


		
}]);

webChat.controller('sellCtrl',['$scope', '$http', '$routeParams', '$location', '$anchorScroll', '$timeout', '$q', 'apiurl',function($scope, $http, $routeParams, $location, $anchorScroll, $timeout, $q, apiurl){

    console.log("conversation controller");
        //buy page
    $scope.data_set = [];

    conversationId = $routeParams.cid;
    $scope.userId = $routeParams.uid;

    $scope.items = [];
    pageNo = -1;
    $scope.conversationDataRf = [];
    $scope.conversationData = [];

    $scope.sendMessageData = '';
    $scope.flag = false;

    $scope.gotoBottom = function() {
          // set the location.hash to the id of
          // the element you wish to scroll to.
          $location.hash('bottom');
          console.log('bottom');
          // call $anchorScroll()
          console.log('bottom');
          $anchorScroll();
        };

    $scope.getDetails = function(){
        var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId};
        $http.post(apiurl+'api_queries_chat',data).then(function(response){
            //console.log(response.data);
            $scope.userDetails = response.data.queries_list[0];

        },function(response){
            console.log('Service Error');
            swal("Unable to reach server. Try again later..");
        });
    }
    $scope.getDetails();

    /*$scope.getdata = function(page){

        var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId,'page_no':1};
        $http.post('http://52.221.57.201/dev/api_queries_chatrefresh',data).then(function(response){
            //console.log(response.data.queries_list);
            $scope.conversationData = response.data.queries_list;
            $scope.loader = false;
        },function(response){
            console.log('Service Error');
        });
        
    }*/

    

    $scope.getdataRf = function(){

        var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId,'page_no':0};
        //console.log(data);
        $http.post(apiurl+'api_queries_chatrefresh',data).then(function(response){
            //console.log(response.data.queries_list);
            $scope.conversationDataRf = response.data.queries_list;
            $scope.loader = false;
        },function(response){
            console.log('Service Error');
            swal("Unable to reach server. Try again later..");
        });
        
    }

    $scope.$watch('conversationDataRf', function(newValue, oldValue){
        console.log($scope.conversationDataRf);
        console.log('being watched oldValue:', oldValue, 'newValue:', newValue);
        var lastValue = newValue[newValue.length-1];
        //console.log(lastValue);
        if((oldValue=='' && newValue!='') || (oldValue[0].id!=newValue[0].id))
        {
            console.log('enter');
            if(oldValue.length==0)
            {
                console.log(newValue);
                angular.forEach(newValue,function(value,key){
                    //console.log(value);
                    $scope.items.unshift({'message':value.message,'user_id':value.user_id,'date':value.time});
                });
                $scope.flag = true;
                $scope.status.mainLoader = false;
            }
            else
            {
                console.log(newValue);
                $scope.items.push({'message':newValue[0].message,'user_id':newValue[0].user_id,'date':newValue[0].time});
                $scope.flag = true;
                $scope.status.mainLoader = false;
            }
            console.log($scope.items);

        }
        else
        {
           // alert('same');
           console.log('same');
        }

        //console.log($scope.items);
    }, true);

    $scope.fun = function()
    {
        for (var i = 0; i < 10; i++) {
            $scope.items.push({'message':'hia','user_id':205});
        }
    }

    $scope.status = {
        loading: false,
        loaded: false,
        lastMessage: false,
        mainLoader: true
    };
    var counter = 0;
    var counters = 0
    $scope.loadMore = function() {
        var deferred = $q.defer();
        if (!$scope.status.loading && $scope.flag) {
            counters += 1;
            console.log(counters);
            $scope.status.loading = true;
            // simulate an ajax request
            /*$timeout(function() {
                for (var i = 0; i < 5; i++) {
                    $scope.items.unshift({'message':'hia','user_id':205});
                    counter += 10;
                }
                $scope.status.loading = false;
                $scope.status.loaded = ($scope.items.length > 0);
                deferred.resolve();
            }, 1000);*/

            var data = {'session_user_id':$scope.userId,'contact_transactioncode':conversationId,'page_no':counters};
            $http.post(apiurl+'api_queries_chatrefresh',data).then(function(response){
                console.log(response.data);
                if(response.data.Result==1)
                {   
                    $scope.conversationData = response.data.queries_list;
                }
                else
                {
                    $scope.status.lastMessage = true;
                }
                /*angular.forEach(response.data.queries_list,function(value,key){
                    $scope.items.push({'message':value.message,'user_id':value.user_id});
                });*/
                
                $scope.status.loaded = ($scope.items.length > 0);
                deferred.resolve();
            },function(response){
                console.log('Service Error');
                swal("Unable to reach server. Try again later..");
            });
        } else {
            deferred.reject();
        }
        return deferred.promise;
    };


    $scope.$watch('conversationData', function(newValue, oldValue){
        /*console.log($scope.conversationData);
        console.log('being watched oldValue:', oldValue, 'newValue:', newValue);*/
        angular.forEach(newValue,function(value,key){
            $scope.items.unshift({'message':value.message,'user_id':value.user_id,'date':value.time});
        });
        window.scrollBy(0, 500);
        $scope.status.loading = false;
        //console.log($scope.items);
    }, true);

    /*window.onscroll = function(ev)
{
    var B= document.body; //IE 'quirks'
        var D= document.documentElement; //IE with doctype
        D= (D.clientHeight)? D: B;
    
    if (D.scrollTop == 0)
        {
            alert("top");
        }        
};*/


    /*$scope.loadMore = function() {
        $scope.loader = true;
        pageNo = pageNo+1;
        console.log('loading = '+pageNo);
        //$scope.getdata(pageNo);
        $scope.fun();
    };*/
    //$scope.loadMore();
    
    //$scope.getdataRf();
    setInterval(function() {
        
        $scope.getdataRf();
    }, 2500);

    $scope.sendMessage = function()
    {
        if($scope.sendMessageData!='')
        {
            var data = {'session_user_id':$scope.userId,'contact_transactioncode':$scope.userDetails.contact_transactioncode,'car_id':$scope.userDetails.car_id,'from_dealer_name':$scope.userDetails.from_dealer_name,'fromdealerid':$scope.userDetails.fromdealerid,'to_dealer_name':$scope.userDetails.to_dealer_name,'to_dealer_id':$scope.userDetails.to_dealer_id,'message':$scope.sendMessageData,'mobile':$scope.userDetails.mobile,'notification_type_id':1,'make':$scope.userDetails.make};
            $scope.sendMessageData = '';
            console.log(data);
            $http.post(apiurl+'api_queries_chatinsert',data).then(function(response){
                //console.log(response.data);
                $scope.sendMessageData = '';
                $scope.getdataRf();
                
            },function(response){
                console.log('Service Error');
                swal("Unable to reach server. Try again later..");
                //$scope.getdataRf();
            });
        }
        else
        {
            console.log('no message');
        }
    }

    //buy page
    
    $scope.goToCarView = function()
    {
        transactinId  = conversationId+':sell';
        window.location = apiurl+'mobileweb/carview/index.html#/carview/'+$scope.userId+'/'+$scope.userDetails.car_id+'/'+transactinId;
    }

    $scope.back = function()
    {
        window.location = apiurl+'mobileweb/back.html';
    }

        
}]);

webChat.directive('scrollBottomOn', ['$timeout', function($timeout) {
return function(scope, elm, attr) {
    scope.$watch(attr.scrollBottomOn, function(value) {
        if (value) {
            $timeout(function() {
            	console.log(elm[0].scrollHeight);
                elm[0].scrollTop = 500;

            });
        }
    });
}}]);


webChat.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown", function(e) {
            if(e.which === 13) {
                scope.$apply(function(){
                    scope.$eval(attrs.ngEnter, {'e': e});
                });
                e.preventDefault();
            }
        });
    };
});

webChat.directive('whenScrolled', ['$timeout', function($timeout) {
    return function(scope, elm, attr) {
        var raw = elm[0];
        
        $timeout(function() {
            raw.scrollTop = raw.scrollHeight;          
        });         
        
        elm.bind('scroll', function() {
            if (raw.scrollTop <= 100) { // load more items before you hit the top
                var sh = raw.scrollHeight
                scope.$apply(attr.whenScrolled);
                raw.scrollTop = raw.scrollHeight - sh;
                console.log(raw.scrollTop);
            }
        });
    };
}]);

webChat.run(function($rootScope, $templateCache) {
   $rootScope.$on('$viewContentLoaded', function() {
      $templateCache.removeAll();
   });
});