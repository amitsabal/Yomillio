'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.categories-list', {
			url: '/categories-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/categories/categories.list.tpl.html'
				}
            },
			controller : 'categoriesCntrl',
			data: {
                page : "Categories"
            }
		})
        .state('rti.categories-save', {
			url: '/categories-save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/categories/categories.save.tpl.html'
				}
            },
			controller : 'categoriesCntrl',
			data: {
                page : "Add Category"
            }
		})
        .state('rti.categories-save/:id', {
			url: '/categories-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/categories/categories.save.tpl.html'
				}
            },
			controller : 'categoriesCntrl',
			data: {
                page : "Edit Category"
            }
		});
    }]);

app.factory('categoriesService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.CATEGORIES_LIST );
		},
		
		create : function(Category) {
            Category.created_by = AuthTokenFactory.getAdminUserId();
			return $http.post( REST_API_URL + API.CATEGORIES_CREATE, Category );
		},
		
		get : function(Category) {
            return $http.get( REST_API_URL + API.CATEGORIES_GET + "/" + Category.id, Category );
        },
		
		update : function(Category) {
            Category.updated_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.CATEGORIES_UPDATE, Category );
		},
        
        ddl : function() {
            return $http.get( REST_API_URL + API.CATEGORIES_DDL );
        }
	}
});

app.controller('categoriesCntrl', ['$scope','$rootScope', '$state', 'noty', 'categoriesService','APP_URL',
                                   function($scope,$rootScope, $state,  noty, categoriesService,APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.categories = [];
    $scope.Category = {};
    $scope.Category.status = 1;
    $('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
	
    if($state.current.name == "rti.categories-list") {
        categoriesService.getall($scope, $state)
            .success(function(response) {
                $scope.categories = response.categories;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	if($state.current.name == "rti.categories-save/:id") {
        //Get User details
        $scope.Category = {};
        $scope.Category.id = $state.current.data.params.id;
        categoriesService.get($scope.Category)
            .success(function(response) {
                $scope.Category = response.category;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	$scope.save = function(u) {
        if (u == undefined) {
            noty.error("Fields marked with * are mandatory!");
            $("#title").focus();
            return;
        }
        if ($scope.Category.title == undefined || $scope.Category.title == null || $.trim($scope.Category.title) == "") {
            $scope.Category.title = "";
            noty.error("Please enter title");
            $("#title").focus();
            return;
        }
		else if ($scope.Category.summary == undefined || $scope.Category.summary == null || $.trim($scope.Category.summary) == "") {
            $scope.Category.summary = "";
            noty.error("Please enter summary");
            $("#summary").focus();
            return;
        }
		else if ($scope.Category.status == undefined || $scope.Category.status == null ) {
            noty.error("Please select status");
            return;
        }
        
        if ($scope.Category.id == undefined || $scope.Category.id == null) {
            categoriesService.create($scope.Category)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.categories-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
        else {
            categoriesService.update($scope.Category)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.categories-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
    }
}]);