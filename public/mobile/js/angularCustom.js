var sampleApp = angular.module('firstApplication', ['ngMaterial']);
sampleApp.controller('inputController',['$scope','$mdDialog',function($scope,$mdDialog){

	$scope.project = {
				  comments: 'Comments',    
			   };

   	$scope.status = '  ';
  	$scope.customFullscreen = false;
		
			  
  	$scope.showTabDialog = function(ev,page) {
		$mdDialog.show({
		  
		  templateUrl: page,
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

}]);
			