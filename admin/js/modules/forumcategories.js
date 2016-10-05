'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.forum-categories-list', {
			url: '/forum-categories-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/forumcategories/categories.list.tpl.html'
				}
            },
			controller : 'forumCategoriesCntrl',
			data: {
                page : "Categories"
            }
		})
        .state('rti.forum-categories-save', {
			url: '/forum-categories-save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/forumcategories/categories.save.tpl.html'
				}
            },
			controller : 'forumCategoriesCntrl',
			data: {
                page : "Add Category"
            }
		})
        .state('rti.forum-categories-save/:id', {
			url: '/forum-categories-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/forumcategories/categories.save.tpl.html'
				}
            },
			controller : 'forumCategoriesCntrl',
			data: {
                page : "Edit Category"
            }
		});
    }]);

app.factory('forumCategoriesService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.FORUM_CATEGORIES_LIST );
		},
		
		create : function(Category) {
            Category.created_by = AuthTokenFactory.getAdminUserId();
			return $http.post( REST_API_URL + API.FORUM_CATEGORIES_CREATE, Category );
		},
		
		get : function(Category) {
            return $http.get( REST_API_URL + API.FORUM_CATEGORIES_GET + "/" + Category.id, Category );
        },
		
		update : function(Category) {
            Category.updated_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.FORUM_CATEGORIES_UPDATE, Category );
		},
        
        ddl : function() {
            return $http.get( REST_API_URL + API.FORUM_CATEGORIES_DDL );
        }
	}
});

app.controller('forumCategoriesCntrl', ['$scope','$rootScope', '$state', 'noty', 'forumCategoriesService','APP_URL',
                                   function($scope,$rootScope, $state,  noty, categoriesService,APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.categories = [];
    $scope.Category = {};
    $scope.Category.status = 1;
	$('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
    
    if($state.current.name == "rti.forum-categories-list") {
        categoriesService.getall($scope, $state)
            .success(function(response) {
                $scope.categories = response.categories;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	if($state.current.name == "rti.forum-categories-save/:id") {
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
		else if ($scope.Category.description == undefined || $scope.Category.description == null || $.trim($scope.Category.description) == "") {
            $scope.Category.description = "";
            noty.error("Please enter description");
            $("#description").focus();
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
                    $state.go("rti.forum-categories-list");
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
                    $state.go("rti.forum-categories-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
    }
}]);