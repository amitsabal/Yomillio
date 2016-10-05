'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.tags-list', {
			url: '/tags-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/tags/tags.list.tpl.html'
				}
            },
			controller : 'tagsCntrl',
			data: {
                page : "Tags"
            }
		})
        .state('rti.tags-save', {
			url: '/tags-save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/tags/tags.save.tpl.html'
				}
            },
			controller : 'tagsCntrl',
			data: {
                page : "Add Tag"
            }
		})
        .state('rti.tags-save/:id', {
			url: '/tags-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/tags/tags.save.tpl.html'
				}
            },
			controller : 'tagsCntrl',
			data: {
                page : "Edit Tag"
            }
		});
    }]);

app.factory('tagsService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.TAGS_LIST );
		},
		
		create : function(Tag) {
            Tag.created_by = AuthTokenFactory.getAdminUserId();
			return $http.post( REST_API_URL + API.TAGS_CREATE, Tag );
		},
		
		get : function(Tag) {
            return $http.get( REST_API_URL + API.TAGS_GET + "/" + Tag.id, Tag );
        },
		
		update : function(Tag) {
            Tag.updated_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.TAGS_UPDATE, Tag );
		},
        
        ddl : function() {
            return $http.get( REST_API_URL + API.TAGS_DDL );
        }
	}
});

app.controller('tagsCntrl', ['$scope','$rootScope', '$state', 'noty', 'tagsService','APP_URL',
                                   function($scope,$rootScope, $state,  noty, tagsService, APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.tags = [];
    $scope.Tag = {};
    $scope.Tag.status = 1;
	$('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
    
    if($state.current.name == "rti.tags-list") {
        tagsService.getall($scope, $state)
            .success(function(response) {
                $scope.tags = response.tags;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	if($state.current.name == "rti.tags-save/:id") {
        //Get User details
        $scope.Tag = {};
        $scope.Tag.id = $state.current.data.params.id;
        tagsService.get($scope.Tag)
            .success(function(response) {
                $scope.Tag = response.tag;
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
        if ($scope.Tag.name == undefined || $scope.Tag.name == null || $.trim($scope.Tag.name) == "") {
            $scope.Tag.name = "";
            noty.error("Please enter name");
            $("#name").focus();
            return;
        }
		
		else if ($scope.Tag.status == undefined || $scope.Tag.status == null ) {
            noty.error("Please select status");
            return;
        }
        
        if ($scope.Tag.id == undefined || $scope.Tag.id == null) {
            tagsService.create($scope.Tag)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.tags-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
        else {
            tagsService.update($scope.Tag)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.tags-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
    }
}]);