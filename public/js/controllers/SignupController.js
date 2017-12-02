angular.module('healthlink', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<<');
	$interpolateProvider.endSymbol('>>');
})
.controller('signup', function ($rootScope, $scope, $http, $timeout) {
})

.controller('signin', function ($rootScope, $scope, $http, $timeout) {


	$scope.loader = false;
	$scope.loader2 = false;
	$scope.signin_card = false;
	$scope.verification = false;

	$scope.findAccount = function(data){
		$scope.loader = true;
		$scope.error = false;

		$scope.signin_card = true;
		$scope.verification = true;
		$http.post("/api/signin/domain", data)
		.then(function(response) {
			if(response.data == 'undefined'){
				console.log(response.data)
				$scope.loader = false;
				$scope.error = true;
				$scope.data.domain = null;
			}else{
				console.log('success')
				window.location.reload();
			}
		});
	}

	$scope.loginAccount = function(){
		$scope.loader = true;
	}

	$scope.confirmEmail = function(data){
		$scope.loader2 = true;
		$http.post("/api/find/email", data)
		.then(function(response) {
			$scope.loader2 = false;
			$scope.data = null;
			$('#modal1').modal('close');
			if(response.data === "sent"){
				swal("Check your email!", "We've emailed a special link to " + data.email + ". Click the link to confirm your address and get started finding your domain.", "success");
			}else{
				swal("Error", "We can't send an email to " + data.email + " right now.", "error");
			}
		});
	}

	$scope.forgotPassword = function(data){
		$scope.loader2 = true;
		$http.post("api/send/reset/link", data)
		.then(function(response) {
			$scope.loader2 = false;
			$scope.data = null;
			$('#modal1').modal('close');
			if(response.data === "sent"){
				swal("Email sent!", "Check your " + data.email + " inbox for instructions from us on how to reset your password.", "success");
			}else{
				swal("Error", "We can't send an email to " + data.email + " right now.", "error");
			}
		});
	}

});