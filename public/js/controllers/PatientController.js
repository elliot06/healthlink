angular.module('healthlink', ['ngSanitize'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<<');
	$interpolateProvider.endSymbol('>>');
})
.controller('dashboard', function ($rootScope, $scope, $http, $timeout) {
	$scope.loading = false;
	
	$scope.myKey = function(){
		$scope.loading = true;

		$http({
			method: 'GET',
			url: '/api/key'
		}).then(function successCallback(response) {
			$scope.data.key = response.data.key;
			$scope.loading = false;
			Materialize.toast('Private Key has been generated.', 4000) 
		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}

	$scope.submitKey = function(data){
		$scope.loading = true;
		$http({
			method: 'POST',
			url: '/api/save/key',
			data: data
		}).then(function successCallback(response) {
			$scope.loading = false;
			if(response.data.result == 'Key is still valid.'){
				Materialize.toast($scope.data.email + ' has still a valid private key to use.', 4000) 
			}else{
				Materialize.toast('Private Key was sent to ' + $scope.data.email + '.', 4000) 
				Materialize.toast('Private Key was saved.', 4000) 
				$('#generateKey').modal('close');
				$scope.data = '';
			}
			
		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}

	
})


.controller('circle', function ($rootScope, $scope, $http, $timeout) {
	$scope.loading = false;

	$scope.searchUsername = function(data){

		if(data){
			$scope.loading = true;
			$http({
				method: 'GET',
				url: '/api/search/' + data,
			}).then(function successCallback(response) {
				$scope.loading = false;

				if(response.data.length > 0){
					$scope.results = response.data
					$scope.empty = false;
				}else{
					$scope.results = null;
					$scope.empty = true;
				}

			}, function errorCallback(response) {
				Materialize.toast('There was an error while processing the request.', 4000) 
			});
		}else{
			$scope.results = null;
		}

	}

	$scope.addCircle = function(data){
		$scope.loading = true;
		// console.log(data)
		data.recipient = data.id;
		$http({
			method: 'POST',
			url: '/api/add/circle',
			data: data
		}).then(function successCallback(response) {
			$scope.loading = false;
			if(response.data == 'isFriend'){
				Materialize.toast('You are already friends with ' + data.name, 4000);
			}else if(response.data == 'isPending'){
				Materialize.toast('You already sent a request to ' + data.name, 4000);
			}else{
				Materialize.toast('You sent a request to ' + data.name, 4000);
			}
			
		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}
	
})



.controller('records', function ($rootScope, $scope, $http, $timeout) {
	$scope.loading = false;

	$scope.shareRecord = function(data){
		// console.log(data)
		$http({
			method: 'GET',
			url: '/api/get/record/' + data,
		}).then(function successCallback(response) {
			$scope.record = response.data.record
			$scope.key = response.data.key.original.key
			$('#dataView').modal('open');
			// console.log(response.data)

		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}

	$scope.save = function(data){
		$scope.loading = true;
		// console.log(data)
		$http({
			method: 'POST',
			url: '/api/edit/record',
			data: data
		}).then(function successCallback(response) {
			$scope.data = response.data
			$scope.edit = 0;
			Materialize.toast('Record was updated.', 4000) 
			// $('#dataView').modal('close');
			// console.log(response.data)

		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}

	$scope.submitKey = function(data, id, key){
		// console.log(key);
		$scope.loading = true;
		data.record_id = id;
		data.key = key;
		$http({
			method: 'POST',
			url: '/api/save/key',
			data: data
		}).then(function successCallback(response) {
			$scope.loading = false;
			if(response.data.result == 'Key is still valid.'){
				Materialize.toast($scope.data.email + ' has still a valid private key to use.', 4000) 
			}else{
				Materialize.toast('Private Key was sent to ' + $scope.data.email + '.', 4000) 
				Materialize.toast('Private Key was saved.', 4000) 
				$('#generateKey').modal('close');
				$scope.data = '';
			}
			$('#dataView').modal('close');
			
		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}
	
})

.controller('navigation', function ($rootScope, $scope, $http, $interval) {
	console.log("sd")
	$scope.getNotif = function(data){
		$scope.loading = true;
		// console.log(data)
		$http({
			method: 'GET',
			url: '/api/notifications/',
		}).then(function successCallback(response) {
			$scope.notif = response.data.pending;
			// console.log(response)
			angular.forEach(response.data.notifs, function(response, data) {
				Materialize.toast(response.content, 7000);
				// console.log(response.content)
			});

		}, function errorCallback(response) {
			Materialize.toast('There was an error while processing the request.', 4000) 
		});

	}

	$scope.getNotif();
	// $interval($scope.getNotif, 5000);
});