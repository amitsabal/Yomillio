'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state( 'login', {
			url: '/login',
			views: {
				'header': {
					templateUrl: 'partials/tpl/common/login-header.tpl.html'
				},
				'main-content': {
					templateUrl: 'partials/tpl/pages/login.tpl.html'
				},
				'footer': {
					templateUrl: 'partials/tpl/common/footer.tpl.html'
				}
            },
			controller : 'loginCntrl',			
			data : {
				layout : "login",
				requireLogin : false,
                page : "Login"
			}
		})
    }]);

app.controller('loginCntrl', function($scope, loginService, $rootScope, $state) {
});

app.factory('loginService', function($http, REST_API_URL, AuthTokenFactory,API){
	return {
		login : function(user) {
			return $http.post( REST_API_URL + API.LOGIN, user );
		},
        logout : function(user) {
            return $http.post( REST_API_URL + API.LOGOUT, user );
        },
		sessionCheck : function() {
			return $http.post(REST_API_URL + API.SESSION_CHECK );
		}
	}
});