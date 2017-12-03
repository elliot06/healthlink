angular.module('healthlink', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<<');
	$interpolateProvider.endSymbol('>>');
})
.controller('accountSetup', function ($rootScope, $scope, $http, $timeout) {

	$scope.mybmi = function(){
		$scope.bmi = ($scope.weight / $scope.height) / $scope.height;

		if($scope.bmi < 18.25){
			$scope.category = "Underweight";
		}else if($scope.bmi == 18.25 || $scope.bmi < 24.9){
			$scope.category = "Normal";
		}else if($scope.bmi == 25 || $scope.bmi < 29.9){
			$scope.category = "Overweight";
		}else if($scope.bmi == 30 || $scope.bmi > 30){
			$scope.category = "Obesity";
		}
	}
	
});