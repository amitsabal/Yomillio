'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.admin-users', {
			url: '/admin/users',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/admin/users/list.tpl.html'
				}
            },
			controller : 'adminUsersCntrl',
			data: {
                page : "Admin Users"
            }
		})
        .state('rti.admin-users-save', {
			url: '/admin/users/save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/admin/users/save.tpl.html'
				}
            },
			controller : 'adminUsersCntrl',
			data: {
                page : "Add Admin User"
            }
		})
        .state('rti.admin-users-save/:id', {
			url: '/admin/users/save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/admin/users/save.tpl.html'
				}
            },
			controller : 'adminUsersCntrl',
			data: {
                page : "Edit Admin User"
            }
		})
        ;
}]);

app.factory('adminUsersService', function($http, REST_API_URL, AuthTokenFactory,API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.ADMIN_USERS_LIST, {} );
		},
        
        create : function(User) {
            User.created_by = AuthTokenFactory.getAdminUserId();
			return $http.post( REST_API_URL + API.ADMIN_USERS_CREATE, User );
		},
        
        get : function(User) {
            return $http.get( REST_API_URL + API.ADMIN_USERS_GET + "/" + User.id, User );
        },
        
        update : function(User) {
            User.updated_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.ADMIN_USERS_UPDATE, User );
		},
        
        changepassword : function(User) {
            User.updated_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.ADMIN_USERS_CHANGE_PASSWORD, User );
        }
	}
});

app.controller('AdminUsersCntrl', ['$scope','$rootScope', '$state', 'adminUsersService', 'noty','APP_URL', 
                                   function($scope,$rootScope, $state, adminUsersService, noty,APP_URL){
    $scope.noty = $rootScope.noty;
    $scope.adminusers = [];
    $scope.User = {};
    $scope.User.status = 1;
	$('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
    
    if($state.current.name == "rti.admin-users") {        
        adminUsersService.getall()
            .success(function (response){
                $scope.adminusers = response.admin_users;
				$('#loadingRecord').html('');
            })
            .error(function(error){
                $rootScope.handleError(error)    
            });
    }
    
    if($state.current.name == "rti.admin-users-save/:id") {
        //Get User details
        $scope.User = {};
        $scope.User.id = $state.current.data.params.id;
        
        adminUsersService.get($scope.User)
            .success(function (response){
                $scope.User = response.admin_user;
                $scope.User.password = null;
            })
            .error(function(error){
                $rootScope.handleError(error)    
            });;
        
        $scope.hidePassword = true;
    }
    
    $scope.save = function(u) {
		
        if (!$scope.validate(u)) {
            return;
        }
        
        
        if ($scope.User.id == undefined || $scope.User.id == null) {
            adminUsersService.create($scope.User)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.admin-users");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
        else {
            //$scope.User.password = "welcome";
            adminUsersService.update($scope.User)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.admin-users");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
    }
    
    $scope. validate = function ( u ) {
        if (u == undefined) {
            noty.error("Fields marked with * are mandatory!");
            $("#username").focus();
            return false;
        }
        if ($scope.User.username == undefined || $scope.User.username == null || $.trim($scope.User.username) == "") {
            $scope.User.username = "";
            noty.error("Please enter username");
            $("#username").focus();
            return false;
        }
        if ($scope.User.id == undefined) {
            //code
            if ($scope.User.password == undefined || $scope.User.password == null || $.trim($scope.User.password) == "") {
                $scope.User.password = null;
                noty.error("Please enter password");
                $("#password").focus();
                return false;
            }
        }
        if ($scope.User.first_name == undefined ||$scope.User.first_name == null || $.trim($scope.User.first_name) == "") {
            $scope.User.first_name = ""
            noty.error("Please enter first name");
            $("#first_name").focus();
            return false;
        }
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!(filter.test($scope.User.email))) {
			noty.error("Invalid email format");
            $("#email").focus();
            return false;
		}
        if ($scope.User.email == undefined ||$scope.User.email == null || $.trim($scope.User.email) == "") {
            $scope.User.email = ""
            noty.error("Please enter email");
            $("#email").focus();
            return false;
        }

        if ($scope.User.admin_groups_id == undefined ||$scope.User.admin_groups_id == null || $.trim($scope.User.admin_groups_id) == "") {
            $scope.User.admin_groups_id = "";
            noty.error("Please select group");
            $("#admin_groups_id").focus();
            return false;
        }
        if ($scope.User.status == undefined ||$scope.User.status == null) {
            noty.error("Please select status");
            return fasle;
        }
        return true;
    }
    
    $scope.values = [{"id" :1, "name" : "Admin"}, {"id":2, "name": "User"}];
}]);