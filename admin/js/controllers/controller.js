'use strict';

$(document).ready(function(){
	try{
		CKEDITOR.replace('content', {
			'toolbar' : 'Standard'
		});
	}
	catch(e){
		
	}
});

app.controller('ApplicationController', ['$scope', '$rootScope', '$state', 'loginService','AuthTokenFactory', 'noty', 'adminUsersService','LIST_PAGE_SIZE', '$interval',
		function($scope, $rootScope, $state, loginService, AuthTokenFactory, noty, adminUsersService, LIST_PAGE_SIZE, $interval){
	$rootScope.noty = noty;
    $scope.User = {};
    $rootScope.currentPage = 1;
    $rootScope.pageSize = LIST_PAGE_SIZE;
    
    //Handle default page if no login
    var token = AuthTokenFactory.getToken();
    if(typeof token === 'undefined' || token == null)
    {
        $state.go('login');
    }
    
    $rootScope.concat_n_show = function(a, b) {
        return a + ' ' + b;
    }
    
	$scope.login = function(user) {
		loginService.login(user, $scope, $state)
            .success(function (response){
                AuthTokenFactory.setToken(response.admin_user.token);
                AuthTokenFactory.setUsername(response.admin_user.username);
                AuthTokenFactory.setAdminUserId(response.admin_user.id);
                $state.go('rti.home');
            })
            .error(function(error){
                $scope.User.username = "";
                $scope.User.password = "";
                $rootScope.handleError(error);
            }); //Call login service
	}

	$scope.logout = function(user) {
		AuthTokenFactory.removeToken();
        AuthTokenFactory.removeUsername();
        AuthTokenFactory.removeAdminUserId();
		$state.go('login');
	}
    
    $rootScope.clearText = function(search) {
        search.text = "";
    }
    
    $rootScope.goToPage = function(page) {
        $state.go(page)
    }
    
    $rootScope.handleError = function (error) {
        
        //code
		if (error.message == "Session Expired") {
			noty.error("Session Expired");
            $state.go("login");
			return;
        }
		
        noty.error("Error : " + error.message );
    }
    
    $scope.changePassword = function(u) {
        if (u == undefined) {
            noty.error("Fields marked with * are mandatory!");
            $("#password").focus();
            return false;
        }
        if ($scope.User.current_password == undefined || $scope.User.current_password == null || $.trim($scope.User.current_password) == "") {
            $scope.User.current_password = "";
            noty.error("Please enter your current password");
            $("#password").focus();
            return false;
        }
        if ($scope.User.password == undefined || $scope.User.password == null || $.trim($scope.User.password) == "") {
            $scope.User.password = "";
            noty.error("Please enter your new password");
            $("#newPassword").focus();
            return false;
        }
        if ($scope.User.password.length < 6)
        {
            $scope.User.password = "";
            noty.error("Your new password must be of 6 characters long!");
            $("#newPassword").focus();
            return false;
        }
        if ($scope.User.confirm_password == undefined || $scope.User.confirm_password == null || $.trim($scope.User.confirm_password) == "") {
            $scope.User.confirm_password = "";
            noty.error("Please re-type your new password");
            $("#reTypePassword").focus();
            return false;
        }
        if ($scope.User.password != $scope.User.confirm_password) {
            $scope.User.confirm_password = "";
            noty.error("Passwords do not match! Please re-type your new password");
            $("#reTypePassword").focus();
            return false;
        }
        
        $scope.User.id = AuthTokenFactory.getAdminUserId();
        adminUsersService.changepassword($scope.User)
                .success(function (response){
                    if (response.error) {
                        $scope.User.current_password = "";
                        $scope.User.password = "";
                        $scope.User.confirm_password = "";
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
                    $state.go("rti.admin-users");
                })
                .error(function(error){
                    $scope.User.current_password = "";
                    $scope.User.password = "";
                    $scope.User.confirm_password = "";
                    $rootScope.handleError(error)    
                });
        
        return true;
    }

	$scope.sessionCheck = function() {
		var token = AuthTokenFactory.getToken();
		if (!AuthTokenFactory.isLoggedIn() && $rootScope.requireLogin) {
			noty.error("Session Expired");
			$state.go('login');
		}
		else if (AuthTokenFactory.isLoggedIn() && $rootScope.requireLogin) {
			loginService.sessionCheck()
				.success(function (response){
				})
				.error(function(error){
					$scope.User.username = "";
					$scope.User.password = "";
					$rootScope.handleError(error);
					//$state.go("login");
				}); //Call login service
		}
	}
	
	//if ($rootScope.requireLogin) {
	var stop = $interval(function() {
		$scope.sessionCheck();
	}, 5000);
	//}
}]);

app.controller('fileUploadCtrl', ['$scope', 'Upload', 'REST_API_URL', 'APP_URL', 'noty', function ($scope, Upload, REST_API_URL, APP_URL, noty) {
    $scope.$watch('thumbnail_image', function () {
		if ($scope.thumbnail_image != undefined) {
			$scope.selectedFileName = thumbnail_image = $scope.thumbnail_image[0].name;
			var pathArray = window.location.href.split( '/' );
			var a_id = pathArray[(pathArray.length)-1];
			$scope.upload($scope.thumbnail_image);
			setTimeout(function(){
			}, 1000);		
		}
    });

    $scope.upload = function (files) {
        if (files && files.length) {
			$("#saveBtn, #listAll").attr('disabled', 'true');
			$('#loadingImage').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:60px;height:60px;" > Please Wait...');
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
				var pathArray = window.location.href.split( '/' );
				var a_id = pathArray[(pathArray.length)-1];
                Upload.upload({
                    url: REST_API_URL + "fileupload.php?item_id="+a_id+'&item_type_id='+article_type_id+'&item_type='+$scope.item_type,
                    fields: {'username': $scope.username},
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                }).success(function (data, status, headers, config) {
                    console.log(data);
                    if (data.error == false) {
						if ($scope.item_type == 'article') {
							angular.extend($scope.Article, data.uploadedFiles);
						}
						else if ($scope.item_type == 'events') {
							angular.extend($scope.Event, data.uploadedFiles);
						}
						else if ($scope.item_type == 'participants') {
							angular.extend($scope.Participant, data.uploadedFiles);
						}
                    }
                    
					if ($scope.item_type == 'article') {
						$("#thumbnail_display_image").css('display', 'block');
						var imgsrc = "src/image.php?file_name="+$scope.Article.id+'/'+$scope.Article.thumbnail_image;
						$("#thumbnail_display_image").attr('src', imgsrc);
					}
					else if ($scope.item_type == 'events') {
						$("#thumbnail_display_image").css('display', 'block');
						var imgsrc = "src/image.php?file_name="+$scope.Event.id+'/'+$scope.Event.thumbnail_image;
						$("#thumbnail_display_image").attr('src', imgsrc);
					}
					else if ($scope.item_type == 'participants') {
						$("#thumbnail_display_image").css('display', 'block');
						var imgsrc = "src/image.php?file_name="+$scope.Participant.id+'/'+$scope.Participant.thumbnail_image;
						$("#thumbnail_display_image").attr('src', imgsrc);
					}
					$('#loadingImage').html('');
					$("#saveBtn, #listAll").removeAttr('disabled');
                })
				.error(function(error){
					
					var errorM = "";
					$(error.message).each(function(){
						errorM += this +"<br/>";
					});
					noty.error(errorM)
				});
            }
        }
    };
}]);

app.controller('sideBarCntrl', ['$scope',function($scope){
	console.log($("#sidemenu .submenu-name").length);
	$("#sidemenu h6").click(function()
    {
		$("#sidemenu .sidemenuwrapper .submenu-name").slideUp();
		
		var elem = $(this).parent().next();
		
		if($(".submenu-name", elem).is(":hidden"))
		{
			$(".submenu-name", elem).slideDown();
		}
	});
}]);
