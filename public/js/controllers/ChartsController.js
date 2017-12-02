'use strict';

angular.module('korraApp', ['chart.js','angular-svg-round-progressbar','ngSanitize'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<<');
	$interpolateProvider.endSymbol('>>');
})
.value('url', 'http://localhost/korra-client/public/')

.controller('dashboard', function ($scope, $http, $interval, url) {
	$scope.bar_labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	$scope.bar_series = ['Low Level', 'Medium Level','High Level'];

	$scope.bar_data = [
	[6, 9, 20, 1, 6, 5, 0],
	[6, 5, 10, 8, 26, 15, 20],
	[8, 4, 4, 9, 16, 17, 10]
	];

	$scope.init = function(){
		$http.get("/api/dashboard/data")
		.then(function(response) {
			$scope.data = response.data;
			// console.log($scope.data);
		});
	}

	$scope.getReportData = function(id){
		console.log(id)
		$http.get("/api/report/" + id)
		.then(function(response) {
			$scope.report = response.data;
		}, function errorCallback(response) {
		});
	}

	$scope.init();

	$interval($scope.init, 10000)


})

.controller('subscriptions', function ($scope, $http, $interval, url) {
	
	$scope.subscriptions = function(id){
		console.log(id)
		$scope.subscription = [];
		if(id == 1){
			$scope.subscription.id = id;
			$scope.subscription.type = 'Basic';
			$scope.subscription.price = 5000;
		}else if(id == 2){
			$scope.subscription.id = id;
			$scope.subscription.type = 'Professional | Popular';
			$scope.subscription.price = 15000;
		}else if(id == 3){
			$scope.subscription.id = id;
			$scope.subscription.type = 'Premium';
			$scope.subscription.price = 30000;
		}

		console.log($scope.subscription)
		// $http.get("/api/report/" + id)
		// .then(function(response) {
		// 	$scope.report = response.data;
		// }, function errorCallback(response) {
		// });
	}


})

.controller('findings', function ($scope, $http, $interval, url) {
	
	
	$scope.init = function(){
		$http.get("/api/findings/data")
		.then(function(response) {
			$scope.data = response.data;
		});
	}

	$scope.init();


})

.controller('integrations', function ($scope, $http, $interval, url) {
	
	$scope.testLoader = false;

	$scope.testNotification = function($provider){
		$scope.testLoader = true;
		$http.get("test/integration/" + $provider)
		.then(function(response) {
			$scope.testLoader = false;
			swal("Check your " +  response.data + "!", "We've sent you a test notification message.", "success");
		});
	}

})

.controller('scopes', function ($scope, $http, $interval, url) {
	
	$scope.getScopes = function(){
		$http.get("/api/scopes/")
		.then(function(response) {
			$scope.scopes = response.data;
			// console.log(response);
		}, function errorCallback(response) {
		});
	}

	$scope.addScope = function(data){
		// console.log(data)
		if($scope.isSubdomain(data.subdomain)){
			$http.post("/api/add/scope", data)
			.then(function(response) {
				if(response.data == 'invalid'){
					Materialize.toast('Invalid Domain from your subdomain.', 4000);
				}else if(response.data == 'maximum'){
					Materialize.toast('You have reached the maximum number of your included subdomain.', 4000);
				}else if(response.data == 'exist'){
					Materialize.toast('This subdomain already exists in your list.', 4000);
				}else{
					$scope.getScopes();
					Materialize.toast('New item has been added to your subdomain list.', 4000);
				}
			}, function errorCallback(response) {
			});
		}else{
			Materialize.toast('This is not a valid subdomain.', 4000);
		}
	}

	$scope.isSubdomain = function(url) {
		url = url.replace(new RegExp(/^\s+/),"");
		url = url.replace(new RegExp(/\s+$/),"");

		url = url.replace(new RegExp(/\\/g),"/");

		url = url.replace(new RegExp(/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i),"");

		url = url.replace(new RegExp(/^www\./i),"");

		url = url.replace(new RegExp(/\/(.*)/),"");

		if(url.match(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i))) {
			url = url.replace(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i),"");

		}else if (url.match(new RegExp(/\.[a-z]{2,4}$/i))) {
			url = url.replace(new RegExp(/\.[a-z]{2,4}$/i),"");
		}

		var subDomain = (url.match(new RegExp(/\./g))) ? true : false;

		return(subDomain);
	}

	$scope.remove = function(data){
		$http.get("/api/remove/scope/" + data.id)
		.then(function(response) {
			if(response.data == 'invalid'){
				Materialize.toast('This is an invalid request.', 4000);
			}else if(response.data == 'unauthenticated'){
				Materialize.toast('You are unauthenticated to do this request.', 4000);
			}else{
				$scope.getScopes();
				Materialize.toast('Subdomain was removed from your list.', 4000);
			}
		}, function errorCallback(response) {
		});
	}

	$scope.status = function(data){
		$http.get("/api/status/scope/" + data.id)
		.then(function(response) {
			if(response.data == 'invalid'){
				Materialize.toast('This is an invalid request.', 4000);
			}else if(response.data == 'unauthenticated'){
				Materialize.toast('You are unauthenticated to do this request.', 4000);
			}else{
				$scope.getScopes();
				Materialize.toast(response.data, 4000);
			}
		}, function errorCallback(response) {
		});
	}

	$scope.getScopes();

});