'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.forum-list', {
			url: '/forum-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/forums/forums.list.tpl.html'
				}
            },
			controller : 'forumsCntrl',
			data: {
                page : "Forums"
            }
		})
        .state('rti.forum-save', {
			url: '/forum-save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/forums/forums.save.tpl.html'
				}
            },
			controller : 'forumsCntrl',
			data: {
                page : "Forum View"
            }
		})
        .state('rti.forum-save/:id', {
			url: '/forum-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/forums/forums.save.tpl.html'
				}
            },
			controller : 'forumsCntrl',
			data: {
                page : "Forum View"
            }
		});
    }]);

app.factory('forumsService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		//getall : function(user_id) {
			//return $http.get( REST_API_URL + API.FORUMS_LIST + "?status[]=1&status[]=2"+ '&user_id='+ user_id,{cache: false} );
		
		getall : function(forum_param) {
			return $http({ url: REST_API_URL + API.FORUMS_LIST , method: "GET", params: forum_param });
		},
		
		get : function(Forum) {
            return $http.get( REST_API_URL + API.FORUMS_GET + "/" + Forum.id, Forum );
        },
		
		update : function(Forum) {           
			return $http.put( REST_API_URL + API.FORUMS_UPDATE + "/" + Forum.id, Forum );
		},
		
		delete: function(forum_id) {
            var data = {deleted_by : AuthTokenFactory.getAdminUserId()}
            return $http.delete( REST_API_URL + API.FORUMS_DELETE + "/" + forum_id + "?deleted_by=" + AuthTokenFactory.getAdminUserId(), data );
        }
	}
});

app.controller('forumsCntrl', ['$scope','$rootScope', '$state', 'noty', 'forumsService','APP_URL',
                                   function($scope,$rootScope, $state,  noty, forumsService, APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.forums = [];
    $scope.Forum = {};
	$scope.Forum.status = 1;
	$('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
    
    if($state.current.name == "rti.forum-list") {
		var forum_param = {
				status : [1,2] 
			};
        forumsService.getall(forum_param)
            .success(function(response) {
                $scope.forums = response.forums;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	if($state.current.name == "rti.forum-save/:id") {
        //Get User details
        $scope.Forum = {};
        $scope.Forum.id = $state.current.data.params.id;
        forumsService.get($scope.Forum)
            .success(function(response) {
                $scope.Forum = response.forum;
				$scope.comments = response.comments;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	$scope.save = function(u) {
//        if (u == undefined) {
//            noty.error("Fields marked with * are mandatory!");
//            $("#title").focus();
//            return;
//        }
//        if ($scope.Category.title == undefined || $scope.Category.title == null || $.trim($scope.Category.title) == "") {
//            $scope.Category.title = "";
//            noty.error("Please enter title");
//            $("#title").focus();
//            return;
//        }
//		else if ($scope.Category.description == undefined || $scope.Category.description == null || $.trim($scope.Category.description) == "") {
//            $scope.Category.description = "";
//            noty.error("Please enter description");
//            $("#description").focus();
//            return;
//        }
//		else if ($scope.Category.status == undefined || $scope.Category.status == null ) {
//            noty.error("Please select status");
//            return;
//        }
//        
//        if ($scope.Category.id == undefined || $scope.Category.id == null) {
//            categoriesService.create($scope.Category)
//                .success(function (response){
//                    if (response.error) {
//                        noty.error(response.message);
//                        return;
//                    }
//                    noty.success(response.message);
//                    $state.go("rti.forum-categories-list");
//                })
//                .error(function(error){
//                    $rootScope.handleError(error)    
//                });
//        }
//        else {
//            categoriesService.update($scope.Category)
//                .success(function (response){
//                    if (response.error) {
//                        noty.error(response.message);
//                        return;
//                    }
//                    noty.success(response.message);
//                    $state.go("rti.forum-categories-list");
//                })
//                .error(function(error){
//                    $rootScope.handleError(error)    
//                });
//        }
		
    }
	$scope.unpublishForum = function(u) {
		   forumsService.update($scope.Forum)
			   .success(function (response){
				   if (response.error) {
					   noty.error(response.message);
					   return;
				   }
				   noty.success(response.message);
				   $state.go("rti.forum-list");
			   })
			   .error(function(error){
				   $rootScope.handleError(error);    
			   });
		}
	$scope.publishForum = function(u) {
		   forumsService.update($scope.Forum)
			   .success(function (response){
				   if (response.error) {
					   noty.error(response.message);
					   return;
				   }
				   noty.success(response.message);
				   $state.go("rti.forum-list");
			   })
			   .error(function(error){
				   $rootScope.handleError(error);    
			   });
		}	
	$scope.deleteForum = function(forum_id) {
        forumsService.delete(forum_id)
            .success(function (response){
                if (response.error) {
                    noty.error(response.message);
                    return;
                }
                noty.success(response.message);
                $state.go("rti.forum-list");
            })
            .error(function(error){
                $rootScope.handleError(error);    
            });
    }
}]);