'use strict'
app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.users-list', {
			url: '/users-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/users/users.list.tpl.html'
				}
            },
			controller : 'usersCntrl',
			data: {
                page : "Users"
            }
		})
        .state('rti.users-details/:id', {
			url: '/users-details/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/users/users.details.tpl.html'
				}
            },
			controller : 'usersCntrl',
			data: {
                page : "User Details"
            }
		});
    }]);

app.factory('usersService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.USERS_LIST );
		},
		
		get : function(User) {
            return $http.get( REST_API_URL + API.USERS_GET + "/" + User.id, User );
        },
		
		update : function(User) {
            User.updated_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.USERS_UPDATE, User );
		},
        
        /*ddl : function() {
            return $http.get( REST_API_URL + API.USERS_DDL );
        }*/
	}
});

app.controller('usersCntrl', ['$scope','$rootScope', '$state', 'noty', 'usersService','articlesService','APP_URL','forumsService',
                                   function($scope,$rootScope, $state,  noty, usersService,articlesService,APP_URL,forumsService){
	$scope.noty = $rootScope.noty;
    $scope.users = [];
    $scope.User = {};
	$('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
    
    if($state.current.name == "rti.users-list") {
        usersService.getall($scope, $state)
            .success(function(response) {
				//console.log(response);
                $scope.users = response.users;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	if($state.current.name == "rti.users-details/:id") {
        //Get User details
        $scope.User = {};
        $scope.User.id = $state.current.data.params.id;
        usersService.get($scope.User)
            .success(function(response) {
				//console.log(response);
                $scope.User = response;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
		var query_params = {
			"status[]" : [1,2,3] ,
			author_id : $scope.User.id,
			author_type : 2
		};
		//alert(query_params['author_id']);
		articlesService.getall(query_params)
            .success(function(response) {
				$scope.articles = response.articles;
				//console.log(query_params);
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
		var forum_param = {
			status : [1,2] ,
			user_id : $scope.User.id,
		};
		forumsService.getall(forum_param)
		.success(function(response) {
			$scope.forums = response.forums;
		})
		.error(function(error) {
			$rootScope.handleError(error);
		});
    }
	$scope.save = function(u) {
        if (u == undefined) {
            noty.error("Fields marked with * are mandatory!");
            $("#status").focus();
            return;
        }
		usersService.update($scope.User.user)
			.success(function (response){
				if (response.error) {
					noty.error(response.message);
					return;
				}
				noty.success(response.message);
				$state.go("rti.users-list");
				$('#loadingRecord').html('');
			})
			.error(function(error){
				$rootScope.handleError(error)    
			});
    }
}]);