'use strict'

rti_app.factory('AccountService', function($http, API, REST_API_URL) {
    return {
        login : function(data) {
            data.url = window.location.href;
            return $http.post( REST_API_URL + API.AUTHENTICATE, data );
        },
        register : function(data) {
            data.url = window.location.href;
            return $http.post( REST_API_URL + API.REGISTER, data );
        },
        forgotpassword : function(data) {
            data.environment_url = REST_API_URL;
            return $http.post( REST_API_URL + API.FORGOT_PASSWORD, data );
        },
        logout : function() {
            return $http.post( REST_API_URL + API.LOGOUT, {} );
        }
	}
});

rti_app.factory('ForumService', function($http, API, REST_API_URL) {
    return {
        create : function(data) {
            return $http.post( REST_API_URL + API.CREATE_FORUM, data );
        },
        search : function(data) {
            return $http.post( REST_API_URL + API.SEARCH_FORUM, data );
        },
        answer : function(data) {
            return $http.post( REST_API_URL + API.ANSWER_FORUM, data );
        },
        voteForum : function(data) {
            return $http.post( REST_API_URL + API.FORUM_VOTE, data );
        },
        voteForumAnswer : function(data) {
            return $http.post( REST_API_URL + API.FORUM_ANSWER_VOTE, data );
        },
	}
});

rti_app.controller('AccountCtrl', ['$scope', 'AccountService', 'ForumService', 'REST_API_URL', 'AuthTokenFactory', '$window', '$rootScope', 'MEDIA_FILES_URL',
                               function($scope, AccountService, ForumService, REST_API_URL, AuthTokenFactory, $window, $rootScope, MEDIA_FILES_URL){
    
    $scope.user = {email : "", password: ""};
    $scope.forgotpassword = function(){
        $("#forgotPasswordBtn").attr('disabled', 'true');
        if ($scope.user == undefined || $scope.user.email == '' || $scope.user.email == null || $scope.user.email == undefined){
            alerts.add("Please enter registered email id");
            $("#forgotPasswordBtn").removeAttr('disabled');
            return false;
        }
        
        else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($scope.user.email)))  
        {  
            alerts.add("Please enter a valid email id");
            $("#forgotPasswordBtn").removeAttr('disabled');
            return false;
        }
        else{
            $('#loadingPassword').html('<img src="'+REST_API_URL + 'media/images/ajax_loader.gif" class="width_30"> Please Wait...');
            $('.forgotPasswordBtn').css('display','none');
        }
        
        
        AccountService.forgotpassword($scope.user)
            .success(function (response){
                $('#loadingPassword').html('');
                if (response.result == undefined || response.result == 0) {
                    $('.forgotPasswordBtn').css('display','block');
                    alerts.add(response.message);
                    return;
                }
                else{
                    $(".forgotPasswordBtn, .emailfield").css('display','none');
                    $(".forgotPasswordText").css('display','block');
                    $("#registeredEmail").val("");
                    $("#forgotPasswordBtn").removeAttr('disabled');
                }
            })
            .error(function(error){
                $rootScope.handleError(error)    
            });
    }
    
    $scope.error = {};
    $scope.signup = function() {
        console.log($scope.user);
        if ($scope.user == undefined || $scope.user.email == '' || $scope.user.email == null || $scope.user.email == undefined ) {//
            alerts.add("Please enter valid email");
            $("#signUpEmail").focus();
            return false;
        }
        
        if ($scope.user == undefined || $scope.user.password == '' || $scope.user.password == null || $scope.user.password == undefined ) {
            alerts.add("Please enter password");
            $("#signUpPassword").focus();
            return false;
        }
        
        var regxLowerCase = /[a-z]/;
        var regxUpperCase = /[A-Z]/;
        var regxNumber = /[0-9]/;
        var regxSpecial = /[!@#$%^&*()_+~]/;
        
        if ($scope.user.password.search(regxLowerCase) == -1 ||
            $scope.user.password.search(regxUpperCase) == -1 ||
            $scope.user.password.search(regxNumber) == -1 ||
            $scope.user.password.search(regxSpecial) == -1 ||
            $.trim($scope.user.password).length < 8) {
            alerts.add("Password should contain atleast 1 Lowercase, 1 Uppercase, 1 Number, 1 Special character and should be 8 character long!");
            $("#signUpPassword").focus();
            return false;
        }
        
        if ($scope.user.retypepassword == '' || $scope.user.retypepassword == null || $scope.user.retypepassword == undefined) {
            alerts.add("Please re-type password");
            $("#signUpRePassword").focus();
            return false;
        }
        
        if ($scope.user.password != $scope.user.retypepassword) {
            alerts.add("Passwords entered doesn't match");
            $("#signUpRePassword").focus();
            return false;
        }
        else{
            $('#loadingSignUp').html('<img src="'+REST_API_URL + 'media/images/ajax_loader.gif" class="width_30"> Please Wait...');
            $(".signUpBtn").css('display','none');
        }
        
        AccountService.register($scope.user)
            .success(function (response){
                $('#loadingSignUp').html('');
                if (response.error) {
                    $(".signUpBtn").css('display','block');
                    alerts.add(response.message);
                    return;
                }
                else{
                    AuthTokenFactory.setToken(response.user.token);
                    AuthTokenFactory.setUser(response.user);
                    
                    $scope.loggedInUser = response.user;
                    
                    //:ToDo
                    //Check if necessary data present in user object
                    //If exists, reload the page, otherwise show profile update popup
                    if ((response.user.first_name == null || response.user.last_name == null ||
                        (response.user.profile_pic == null && response.user.linkedin_picture_url == null) ||
                        response.user.bio == null || response.user.linkedin_job_title == null) ||
                        (response.user.first_name == '' || response.user.last_name == '' ||
                        (response.user.profile_pic == '' && response.user.linkedin_picture_url == '') ||
                        response.user.bio == '' || response.user.linkedin_job_title == '')
                    ) {
                        $('.loginContainerFull').hide();
                        $('.signupPopupContainer').show();
                        
                        $(".signupPopupContainer #firstname").val(response.user.first_name);
                        $(".signupPopupContainer #lastname").val(response.user.last_name);
                        $(".signupPopupContainer #biodata").val(response.user.bio);
                        $(".signupPopupContainer #jobtitle").val(response.user.linkedin_job_title);
                        if (response.user.profile_pic != null) {
                            $(".signupPopupContainer #profile_pic").attr('src',response.user.profile_pic);
                        }
                        else if (response.user.linkedin_picture_url != null) {
                            $(".signupPopupContainer #profile_pic").attr('src',response.user.linkedin_picture_url);
                        }
                        
                        return;
                    }
                    else {
                        $window.location.reload();
                    }
                }
            })
            .error(function(error){
                //$rootScope.handleError(error)    
            });
    }
    
    $scope.login = function() {
        
        if ($scope.user == undefined || $scope.user.email == '' || $scope.user.email == null || $scope.user.email == undefined || $scope.user.password == '' || $scope.user.password == null || $scope.user.password == undefined ) {
            alerts.add("Please enter all the fields");
            return false;
        }
        
        AccountService.login($scope.user)
            .success(function (response){
                console.log(response);
                if (response.success == 0) {
                    alerts.add(response.message);
                    return;
                }
                else{
                    AuthTokenFactory.setToken(response.user.token);
                    AuthTokenFactory.setUser(response.user);
                    
                    $scope.loggedInUser = response.user;
                    
                    //:ToDo
                    //Check if necessary data present in user object
                    //If exists, reload the page, otherwise show profile update popup
                    if ((response.user.first_name == null || 
                        (response.user.profile_pic == null && response.user.linkedin_picture_url == null) ||
                        response.user.bio == null || response.user.linkedin_job_title == null) ||
                        (response.user.first_name == '' || 
                        (response.user.profile_pic == '' && response.user.linkedin_picture_url == '') ||
                        response.user.bio == '' || response.user.linkedin_job_title == '')
                    ) {
                        $('.loginContainerFull').hide();
                        $('.signupPopupContainer').show();
                        
                        $(".signupPopupContainer #firstname").val(response.user.first_name);
                        $(".signupPopupContainer #lastname").val(response.user.last_name);
                        $(".signupPopupContainer #biodata").val(response.user.bio);
                        $(".signupPopupContainer #jobtitle").val(response.user.linkedin_job_title);
                        if (response.user.profile_pic != null) {
                            $(".signupPopupContainer #profile_pic").attr('src',MEDIA_FILES_URL + "uploads/images/profile/" + response.user.profile_pic);
                        }
                        else if (response.user.linkedin_picture_url != null) {
                            $(".signupPopupContainer #profile_pic").attr('src',response.user.linkedin_picture_url);
                        }
                        
                        return;
                    }
                    else {
                        $window.location.reload();
                    }
                }
            })
            .error(function(error){
                alerts.add(error.message);   
            });
    }

    $scope.logout = function(){
        AccountService.logout()
            .success(function(response){
                AuthTokenFactory.removeToken();
                AuthTokenFactory.removeUser();
                $window.location.reload();
            })
            .error($scope.handleError);
    }
}]);