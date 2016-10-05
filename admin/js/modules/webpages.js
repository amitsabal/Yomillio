'use strict'

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.webpages-list', {
			url: '/webpages-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/webpages/webpages.list.tpl.html'
				}
            },
			controller : 'webpagesCntrl',
            data: {
                page : "Webpages"
            }
		})
        .state('rti.webpages-save', {
			url: '/webpages-save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/webpages/webpages.save.tpl.html'
				}
            },
			controller : 'webpagesCntrl',
            data: {
                page : "Add New Webpage"
            }
		})
        .state('rti.webpages-save/:id', {
			url: '/webpages-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/webpages/webpages.save.tpl.html'
				}
            },
			controller : 'webpagesCntrl',
            data: {
                page : "Edit Webpage"
            }
		});
    }]);

app.factory('webpagesService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		getall : function() {
			return $http.get( REST_API_URL + API.WEBPAGES_LIST );
		},
		
		create : function(Webpage) {
            Webpage.created_by = AuthTokenFactory.getAdminUserId();
			var createresult = $http.post( REST_API_URL + API.WEBPAGES_CREATE, Webpage );
			return createresult;
		},
		
		get : function(Webpage) {
            return $http.get( REST_API_URL + API.WEBPAGES_GET + "/" + Webpage.id, Webpage );
			
        },
		
		update : function(Webpage) {
            Webpage.updated_by = AuthTokenFactory.getAdminUserId();
			
			var updateresult = $http.put( REST_API_URL + API.WEBPAGES_UPDATE, Webpage );
			return updateresult;
		}
	}
});

app.controller('webpagesCntrl', ['$scope','$rootScope', '$state', 'noty', 'webpagesService', 'APP_URL',
                                   function($scope,$rootScope, $state,  noty, webpagesService, APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.webpages = [];
    $scope.Webpage = {};
    $scope.Webpage.status = 1;
	$scope.app_url = APP_URL;
    
    if($state.current.name == "rti.webpages-list") {
        webpagesService.getall($scope, $state)
            .success(function(response) {
                $scope.webpages = response.webpages;
				$scope.webpages.app_url = APP_URL;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
    
    if($state.current.name == "rti.webpages-save/:id" || $state.current.name == "rti.webpages-save") {
		$scope.hideImage = true;
        var editor = CKEDITOR.replace( 'content', {
            allowedContent: true,
            filebrowserBrowseUrl : 'js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : 'js/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : 'js/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
        CKFinder.setupCKEditor( editor, '../' );
    }
    
    if($state.current.name == "rti.webpages-save/:id") {
		
        $scope.Webpage = {};
        $scope.Webpage.id = $state.current.data.params.id;
		
        webpagesService.get($scope.Webpage)
            .success(function(response) {
                $("#title").focus();
                $scope.Webpage = response.webpage;
				$("#url").attr('disabled', 'disabled');
                console.log($scope);
                
                try{
					var fooCallback = function(){
						CKEDITOR.instances.content.focus();
						CKEDITOR.instances.content.insertHtml(response.webpage.content);
					};
					CKEDITOR.instances.content.setData("", fooCallback);
				}
				catch(e){
					
				}
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	
	
	$scope.save = function(u) {
		$scope.Webpage.content = CKEDITOR.instances.content.getData();
		var regexp = /^[a-z_]+$/;
        if (u == undefined) {
            noty.error("Fields marked with * are mandatory!");
            $("#title").focus();
            return;
        }
        if ($scope.Webpage.title == undefined || $scope.Webpage.title == null || $.trim($scope.Webpage.title) == "") {
            $scope.Webpage.title = "";
            noty.error("Please enter title");
            $("#title").focus();
            return;
        }
		else if ($scope.Webpage.url == undefined || $scope.Webpage.url == null || $.trim($scope.Webpage.url) == "") {
            $scope.Webpage.url = "";
            noty.error("Please enter url");
            $("#url").focus();
            return;
        }
		else if ($scope.Webpage.url.indexOf(' ') >= 0) {
            noty.error("URL should be a single word");
            $("#url").focus();
            return;
		}
		else if (!($scope.Webpage.url.match(regexp))) {
			noty.error("URL can contain only lower case alphabets and _");
            $("#url").focus();
            return;
		}
		else if ($.trim($scope.Webpage.content) == "" || $.trim($scope.Webpage.content) == null ) {
            $scope.Webpage.content = "";
            noty.error("Please enter content");
            $("#content").focus();
            return;
        }
	
		else if ($scope.Webpage.status == undefined || $scope.Webpage.status == null ) {
            noty.error("Please select status");
            return;
        }
        else {
			console.log($scope.Webpage);
			if ($scope.Webpage.id == undefined || $scope.Webpage.id == null) {
				var r = confirm("URL cannot be changed once it is saved. Click OK to continue");
				if (r == false) {
					return;
				}
				else{
					webpagesService.create($scope.Webpage)
					.success(function (response){
						if (response.error) {
							noty.error(response.message);
							return;
						}
						noty.success(response.message);
						$state.go("rti.webpages-list");
					})
					.error(function(error){
						$rootScope.handleError(error)    
					});	
				}
			}
			else {
				webpagesService.update($scope.Webpage)
					.success(function (response){
						if (response.error) {
							noty.error(response.message);
							return;
						}
						noty.success(response.message);
						$state.go("rti.webpages-list");
					})
					.error(function(error){
						$rootScope.handleError(error)    
					});
			}
        }
    }
}]);