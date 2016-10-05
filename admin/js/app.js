'use strict';

//var host_base_url = 'http://localhost/R2I/';
var host_base_url = "http://" + window.location.hostname + window.location.pathname;

// Declare app level module which depends on views, and components
var app = angular.module('zinnovRtiApp',[
            'ui.router',
            'ui.footable',
            'rt.select2',
            'ngFileUpload',
            'selectize',
            'angularUtils.directives.dirPagination',
            'angular-timezone-selector',
            'ngSanitize',
            'ngCkeditor'
        ]);

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    	$httpProvider.interceptors.push('AuthInterceptor');
        $httpProvider.interceptors.push('noCacheInterceptor');
        $stateProvider.state('rti', {
            abstract: true,
			views: {
				'main-content' : {
					templateUrl: 'partials/tpl/pages/home.tpl.html'
				},
				'header': {
					templateUrl: 'partials/tpl/common/header.tpl.html'
				},
				'footer': {
					templateUrl: 'partials/tpl/common/footer.tpl.html'
				},
				'sidebar' : {
					templateUrl: 'partials/tpl/common/sidebar.tpl.html'	
				}
            },
			data : {
				layout : "site",
				requireLogin : true
			}
		})
        .state('rti.change-password', {
			url: '/change-password',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/change_password.tpl.html'
				}
            },
			controller : 'ApplicationController',
            data : {
                page : "Change Password"
            }
		});
		$urlRouterProvider.otherwise('/login');
	}]);

app.config(function(paginationTemplateProvider) {
    paginationTemplateProvider.setPath('partials/tpl/common/pagination.tpl.html');
});