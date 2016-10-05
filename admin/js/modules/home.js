'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.home', {
			url: '/home',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/home.tpl.html'
				}
            },
			controller : 'homeCntrl',
			data : {
				page : "Home",
				layout : "site",
				requireLogin : true
			}
		})
    }]);

app.controller('homeCntrl', ['$scope','$rootScope', function($scope,$rootScope){
}]);