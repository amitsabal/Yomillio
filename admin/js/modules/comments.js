'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.comments-list', {
			url: '/comments-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/comments/comments.list.tpl.html'
				}
            },
			controller : 'commentsCntrl',
			data: {
                page : "Comments"
            }
		})
        .state('rti.comments-save/:id', {
			url: '/comments-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/comments/comments.save.tpl.html'
				}
            },
			controller : 'commentsCntrl',
			data: {
                page : "Edit Comment"
            }
		});
    }]);

app.factory('commentsService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.COMMENTS_LIST );
		},
		
		/*create : function(Comment) {
            Comment.created_by = AuthTokenFactory.getAdminUserId();
			return $http.post( REST_API_URL + API.COMMENTS_CREATE, Comment );
		},*/
		
		get : function(Comment) {
            return $http.get( REST_API_URL + API.COMMENTS_GET + "/" + Comment.id, Comment );
        },
		
		update : function(Comment) {
            Comment.published_by = AuthTokenFactory.getAdminUserId();
			return $http.put( REST_API_URL + API.COMMENTS_UPDATE, Comment );
		},
        
        ddl : function() {
            return $http.get( REST_API_URL + API.COMMENTS_DDL );
        }
	}
});

app.controller('commentsCntrl', ['$scope','$rootScope', '$state', 'noty', 'commentsService','APP_URL',
                                   function($scope,$rootScope, $state,  noty, commentsService,APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.comments = [];
    $scope.Comment = {};
    $scope.Comment.status = 1;
    $('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
	
    if($state.current.name == "rti.comments-list") {
        commentsService.getall($scope, $state)
            .success(function(response) {
                $scope.comments = response.comments;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	if($state.current.name == "rti.comments-save/:id") {
        //Get comment details
        $scope.Comment = {};
        $scope.Comment.id = $state.current.data.params.id;
        commentsService.get($scope.Comment)
            .success(function(response) {
                $scope.Comment = response.comment;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	$scope.save = function(u) {
        if ($scope.Comment.status == undefined || $scope.Comment.status == null ) {
            noty.error("Please select status");
            return;
        }
        
        if ($scope.Comment.id == undefined || $scope.Comment.id == null) {
            commentsService.create($scope.Comment)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.comments-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
        else {
            commentsService.update($scope.Comment)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.comments-list");
					$('#loadingRecord').html('');
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
    }
}]);