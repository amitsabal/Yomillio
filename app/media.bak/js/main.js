'use strict'

var base_url = $APP_BASE_URL;

var rti_app = angular.module('zinnov-rti', []);

rti_app.constant('REST_API_URL', base_url);
rti_app.constant('MEDIA_FILES_URL', base_url + "media/");

rti_app.constant('API', {
        "LOGIN" : "login",
        "SHARE_COUNT" : "articles/updatesharecount",
        
        "CREATE_COMMENT" : "comments/create",
        
        "AUTHENTICATE" : "account/login",
        "REGISTER" : "account/signup",
        "LOGOUT" : "account/logout",
        "SESSION_USER" : "account/sessionuser",
        
        "USER_PROFILE" : "user/get",
        "UPDATE_SESSION" : "user/updatesession",
        "FORGOT_PASSWORD" : "user/forgotpassword",
        
        "CREATE_FORUM" : "forums/create",
        "SEARCH_FORUM" : "forums/search",
        "ANSWER_FORUM" : "forums/addanswer",
        "FORUM_VOTE"    : "forums/forumvote",
        "FORUM_ANSWER_VOTE"    : "forums/forumanswervote"
    });

rti_app.config(['$httpProvider',function ($httpProvider) {
    $httpProvider.interceptors.push('AuthInterceptor');
}]);
rti_app.factory('UserService', function($http, API, REST_API_URL) {
    return {
        get : function(id) {
            return $http.get( REST_API_URL + API.USER_PROFILE + "/" +id, {} );
        },
        updatesession : function() {
            return $http.get( REST_API_URL + API.UPDATE_SESSION, {} );
        }
    };
});

rti_app.factory('ArticleService', function($http, API, REST_API_URL) {
    
    return {
        updatesharecount : function(data) {
            return $http.post( REST_API_URL + API.SHARE_COUNT + "/" + data.id, data );
        }
    };
});

rti_app.factory('CommentService', function($http, API, REST_API_URL) {
    
    return {
        create : function(data) {
            return $http.post( REST_API_URL + API.CREATE_COMMENT, data );
        }
    };
});
rti_app.directive('singleArticleHover', function(){
    return {
        restrict: 'A',    
        link: function(scope, element, attrs){
            if($(window).width() > 992){
                $( element )
                .mouseover(function() {
                    $(this).children().find('.shareIcon').hide();
                    $(this).children().find('.articleShareIcon').show();
                })
                .mouseout(function() {
                    $(this).children().find('.articleShareIcon').hide();
                    $(this).children().find('.shareIcon').show();
                })
                // .css({'cursor':'pointer'});
            }
            else{
                $(element).children().find('.shareIcon').click(function(){
                    $(element).children().find('.shareIcon').hide();
                    $(element).children().find('.articleShareIcon').show();
                })
            }
            
        }  
    }
});

rti_app.directive('videoPlayHover', function(){
    return {
        restrict: 'A',    
        link: function(scope, element, attrs){
            $( element )
                .mouseover(function() {
                    $(this).children().find('.play').hide();
                    $(this).children().find('.playHover').show();
                })
                .mouseout(function() {
                    $(this).children().find('.playHover').hide();
                    $(this).children().find('.play').show();
                })
                .css({'cursor':'pointer'});
        }  
    }
});

rti_app.directive('shareIcons', ['MEDIA_FILES_URL',function(MEDIA_FILES_URL){
    return {
        restrict: 'E',    
        templateUrl : MEDIA_FILES_URL +'views/social.sharing.tpl.html'
    }
}]);

rti_app.directive('fixedShare', function(){
    return {
        restrict: 'A',    
        link: function(scope, element, attrs){
            $(element).css('top',($(window).height()/2)-30)
        }  
    }
});

rti_app.controller('sharingController', function($scope){
    
});

rti_app.controller('forumController',['MEDIA_FILES_URL', 'REST_API_URL', '$location', 'AuthTokenFactory','$scope','ForumService','$rootScope','$window',
                function(MEDIA_FILES_URL, REST_API_URL, $location, AuthTokenFactory, $scope, ForumService, $rootScope,$window){
    
    $rootScope.session_user;
    
    $scope.firstName = ($rootScope.session_user == null) ? "Anonymous" : $rootScope.session_user.first_name;
    $scope.lastName = ($rootScope.session_user == null) ? "" : $rootScope.session_user.last_name;
    $scope.forumanswer = {};
    $scope.forumanswer.user_id = ($rootScope.session_user == null) ? "" : $rootScope.session_user.id;
    $scope.disableSubmitButton = false;
    $scope.disablePost = false;
    
    
    if (AuthTokenFactory.isValidUser() && AuthTokenFactory.isValidToken()) {
        $(".commenterName .username").html($rootScope.session_user.first_name+" "+(($rootScope.session_user.last_name==null)?"":$rootScope.session_user.last_name));
        if ($rootScope.session_user.profile_pic != null) {
            $(".commentor-image").attr('src', MEDIA_FILES_URL + 'uploads/images/profile/' + $rootScope.session_user.profile_pic);
        }
        else if ($rootScope.session_user.linkedin_picture_url != null) {
            $(".commentor-image").attr('src', $rootScope.session_user.linkedin_picture_url);
        }
    }
    else{
        $(".commenterName .username").html("Anonymous");
    }
    
    $scope.searchForum = function(forum) {
        
        if (!AuthTokenFactory.isValidUser()) {
            alerts.add('Please login to continue!');
            return false;
        }
        
        if (forum == undefined || forum == null) {
            alerts.add('All fields are mandatory!');
            return false;
        }
        
        if (forum.category_id == undefined || $.trim(forum.category_id).length == 0 || parseInt(forum.category_id) <= 0) {
            alerts.add('Please select category!');
            return false;
        }
        
        forum.user_id = $rootScope.session_user.id;
        if (forum.title == undefined || $.trim(forum.title).length == 0) {
            alerts.add('Please enter heading!');
            return false;
        }
        
        if (forum.summary == undefined || $.trim(forum.summary).length == 0) {
            alerts.add('Please enter description!');
            return false;
        }
        if (forum.captcha_code == undefined || $.trim(forum.captcha_code).length == 0) {
            alerts.add('Please enter the captcha code!');
            return false;
        }
        $scope.disableSubmitButton = true;
        
        var data = {search_text : forum.title, captcha_code : forum.captcha_code};
      
        ForumService.search(data)
            .success(function (response){
               // alert(response);
                $scope.similarThreads = response.similar_threads;
        
                if ($scope.similar_threads == null || $scope.similarThreads.length == 0)
                {
                   $scope.addForum(forum);
                }
                else
                {
                    $('.similarThreadsPopup').show();
                    $('.newThreadsPopup').css('display','none');
                    $scope.disableSubmitButton = false;
                }
            })
            .error(function(error){
                //alert(response);
                if (error.message == "Undefined variable: arr") {
                    //$scope.addForum(forum);  //code
                }
                else {
                    alerts.add('The security code entered was incorrect!');
                }
            });
        
    }
    
    $scope.addForum = function(forum) {
        $scope.disableSubmitButton = true;
        ForumService.create(forum)
            .success(function (response){
                //console.log(response);
                $('.similarThreadsClosePopup').click();
                $('.newThreadsFull').hide();
                $('.similarThreadsPopup').css('display','none');
                $('.newThreadsPopup').show();
                $('.threadHeadingInput').val('');
                $('.threadContentInput').val('');
                $("#thread_category").find('option').removeAttr("selected");
                location.href=REST_API_URL+"forums";
            })
            .error(function(error){
                
            });
            
    }
    
    $scope.postAnswer = function(forumanswer) {
        if (!AuthTokenFactory.isValidUser()) {
            alerts.add('Please login to continue!');
            return false;
        }
        forumanswer.user_id = $rootScope.session_user.id;
        forumanswer.forum_id = $("#forum_id").val();
        if (forumanswer.answer == undefined || $.trim(forumanswer.answer).length == 0) {
            alerts.add('Please enter your answer!');
            return false;
        }
        if (forumanswer.captcha_code == undefined || $.trim(forumanswer.captcha_code).length == 0) {
            alerts.add('Please enter the captcha code!');
            return false;
        }
        $scope.disablePost = true;
        var data = {forum_id : forumanswer.forum_id,answer : forumanswer.answer, captcha_code : forumanswer.captcha_code, user_id : $rootScope.session_user.id};
       
        ForumService.answer(data)
            .success(function (response){
                
               $(".submitAnswerButton").removeAttr("disabled");
              // location.reload();
                 $window.location.reload();
                // location.href=REST_API_URL+"forums";                
            })
            .error(function(error){
                if (error.message == "Undefined variable: arr") {
                }
                else {
                       alerts.add('Entered security code is incorrect!');
                       $(".submitAnswerButton").removeAttr("disabled");
                }
            });
    }
    
    $scope.voteForForum = function(forumVote, vote)
    {
        forumVote = {};
        if (!AuthTokenFactory.isValidUser()) {
            alerts.add('Please login to continue!');
            return false;
        }
        forumVote.user_id = $rootScope.session_user.id;
        forumVote.forum_id = $("#forum_id").val();
        forumVote.vote = vote;
        ForumService.voteForum(forumVote)
            .success(function (response){
                $("#forumVoteDown").text(response.forum_vote_down);
                $("#forumVoteUp").text(response.forum_vote_up);
            })
            .error(function (error) {
            });
    }
    
    $scope.voteForAnswer = function(id, vote)
    {
        var forumAnswerVote = {};
        if (!AuthTokenFactory.isValidUser()) {
            alerts.add('Please login to continue!');
            return false;
        }
        forumAnswerVote.user_id = $rootScope.session_user.id;
        forumAnswerVote.forum_id = $("#forum_id").val();
        forumAnswerVote.vote = vote;
        forumAnswerVote.forum_answer_id = id;
        ForumService.voteForumAnswer(forumAnswerVote)
            .success(function (response){
                $("#forumAnswerVoteDown" + id).text(response.forum_answer_vote_down);
                $("#forumAnswerVoteUp" + id).text(response.forum_answer_vote_up);
            })
            .error(function (error) {
            });
    }
}]);
rti_app.controller('AppCtrl', ['$scope', 'ArticleService', 'UserService', 'CommentService', 'MEDIA_FILES_URL', 'REST_API_URL', '$location', 'AuthTokenFactory', '$window', 'AccountService', '$rootScope',
                               function($scope, ArticleService, UserService, CommentService,MEDIA_FILES_URL, REST_API_URL, $location, AuthTokenFactory, $window, AccountService, $rootScope){
    $scope.latestArticles = [];
    $scope.$MEDIA_FILES_URL = MEDIA_FILES_URL;
    $scope.showLatest = true;
    $scope.showPopular = false;
    $scope.selectedCategory = {id:0,title:"All"};
    $scope.videoIndex = 0;
    $scope.comment = {};
    
    
    
    $scope.comments = [];
    try {
        $scope.articleId = articleId;
        $scope.commentsCount = commentsCount;
    }
    catch(e) {
        
    }
    var absUrl = $location.absUrl();
    var curUrl = absUrl.replace(REST_API_URL, "");
    
    $scope.logout = function(){
        AccountService.logout()
            .success(function(response){
                AuthTokenFactory.removeToken();
                AuthTokenFactory.removeUser();
                $window.location.reload();
            })
            .error($scope.handleError);
    }
    
    if(AuthTokenFactory.isValidUser() && !AuthTokenFactory.isValidToken()) {
        $scope.logout();
        return;
    }
    $rootScope.session_user = {};
    AccountService.sessionuser()
        .success(function(response){
            $rootScope.session_user = response.user;
        });
    
    //$scope.updateSession = function() {
    //    if (AuthTokenFactory.isValidToken()) {
    //        UserService.updatesession()
    //            .success(function(response){
    //                var session_user = AuthTokenFactory.getUser();
    //                session_user.expires_at = response.session.expires_at;
    //            })
    //            .error($scope.handleError);
    //    }
    //}
    
    $scope.changePaginationURL = function(articleType) {
        
        $(".pagination a") .each(function() {
            var href = $(this).attr("href");
            
            if(href.indexOf("latest") == -1 && href.indexOf("popular") == -1)
            {
                href += "/" + articleType;
                $(this).attr("href", href);    
            }
            else if (href.indexOf("/latest") !== -1) {
                href = href.replace("/latest", "");
                href += "/" + articleType;
                $(this).attr("href", href);   
            }
            else if (href.indexOf("/popular") !== -1) {
                href = href.replace("/popular", "");
                href += "/" + articleType;
                $(this).attr("href", href);   
            }
        });
    }
    
    $scope.showLatestArticles = function() {
        $scope.showLatest = true;
        $scope.showPopular = false;
        
        $scope.changePaginationURL('latest');
    }
    
    $scope.showPopularArticles = function() {        
        $scope.showLatest = false;
        $scope.showPopular = true;
        setTimeout(function(){setArticleHomeContent();},100);
        $scope.changePaginationURL('popular');
    }
    
    if ($.trim($("#currentShowType").val()).length > 0) {
        if ($("#currentShowType").val() == "popular") {
            $scope.showPopularArticles();
        }
        else {
            $scope.showLatestArticles();
        }
    }

     $scope.showLatestInsights = function() {
        $scope.showLatest = true;
        $scope.showPopular = false;
        $scope.changePaginationURL('latest');
    }
    
    $scope.showPopularInsights = function() {        
        $scope.showLatest = false;
        $scope.showPopular = true;
        $scope.changePaginationURL('popular');
    }
    
    if ($.trim($("#currentShowInsightType").val()).length > 0) {
        if ($("#currentShowInsightType").val() == "popular") {
            $scope.showPopularInsights();
        }
        else {
            $scope.showLatestInsights();
        }
    }
    
    try {
        if (!AuthTokenFactory.isValidToken()) {
            $(".toCommentLogin").show();
            $(".commentsubmit").attr('disabled', 'true');
            //$(".logInButton, signUpButton").show();
            $(".profile-pic").hide();
        }
        else{
            $(".toCommentLogin").hide();
            $(".commentsubmit").removeAttr('disabled');
            //$(".logInButton, .signUpButton").hide();
        }
    }
    catch(e) {
        
    }
    $(".logindisplay").css('display','none');
    
    
	if (AuthTokenFactory.isValidToken()) {
        $(".logindisplay").css('display','block');
    }
    
    $scope.updateShareCount = function(type, id, article) {
        ArticleService.updatesharecount({type:type, id:id})
            .success(function(response){
                article.share_count += 1; 
            })
            .error($scope.handleError);
    }
    $rootScope.handleError = function(error){
        alerts.add(error.message);
        return;
    }
    
    $scope.addComment = function(comment) {
        if(AuthTokenFactory.isValidToken())
        {
           // $(".commentsubmit").attr("disabled", "disabled");
            comment.article_id = $scope.articleId;
            comment.user_id = $rootScope.session_user.id;
            if ($rootScope.session_user.profile_pic != null) {
                comment.profile_pic = $rootScope.session_user.profile_pic;
            }
            else if ($rootScope.session_user.linkedin_picture_url != null) {
                comment.linkedin_picture_url = $rootScope.session_user.inkedin_picture_url;
            }
             
        
        if (comment.comment == undefined || $.trim(comment.comment).length == 0) {
            alerts.add('Please enter your comment!');
            return false;
        }
        
        if (comment.captcha_code == undefined || $.trim(comment.captcha_code).length == 0) {
            alerts.add('Please enter the captcha code!');
            return false;
        }
        //console.log( $rootScope.session_user);
        $scope.disablePost = true;
        var data = {user_id : comment.user_id,comment : comment.comment, captcha_code : comment.captcha_code};
             //alert(data.captcha_code);
            CommentService.create(comment)
                .success(function(response){
                    
                if (comment.profile_pic != null) {
                    comment.profile_pic = MEDIA_FILES_URL + "uploads/images/profile/"+comment.profile_pic;
                }
                //location.href=$location.absUrl();
                //alert($location.absUrl());
                comment.created_at = response.created_at.date;
                $scope.comments.push(comment);
                $scope.comment = {};
                $scope.commentsCount++;
                $(".commentsubmit").removeAttr("disabled");
                $("#commentClause").text($scope.comments.length == 1 ? "IS" : "ARE");
                $("#commentClause1").text($scope.comments.length == 1 ? "" : "S");
                $("#reloadCaptcha").click();
            })
            .error(function(error){
                if (error.message == "Undefined variable: arr") {
                    
                }
                else {
                       alerts.add('Entered security code is incorrect!');
                }
            });
                   
        }
        else{
            alerts.add("Please login/signup to comment on this article");
        }
    }

    // Scroll
    $scope.articleCommentShow = function() { 
        event.preventDefault();
        $('html,body').animate({
            scrollTop: $("#article_comment_show").offset().top},
        'slow');
        $("#article_comment_show").find('textarea').focus();
    }
    
    $scope.infographicCommentShow = function() {
        event.preventDefault();
        $('html,body').animate({
            scrollTop: $("#infographic_comment_here").offset().top},
        'slow');
        $("#infographic_comment_here").find('textarea').focus();
    }

    $scope.showArticleComments = function(comment) {
        event.preventDefault();
        if($(window).width() > 768){
            $('html,body').animate({
                scrollTop: $(".numberOfArticleCommentDiv").offset().top - 180},
            '1000');
        }else{
            $('html,body').animate({
                scrollTop: $(".numberOfArticleCommentDiv").offset().top},
            '1000');
        }
    }
    
    $scope.showInfographicComments = function() {
        event.preventDefault();
        if($(window).width() > 768){
            $('html,body').animate({
                scrollTop: $(".numberOfInfographicCommentDiv").offset().top - 180},
            '1000');
        }else{
            $('html,body').animate({
                scrollTop: $(".numberOfInfographicCommentDiv").offset().top},
            '1000');
        }
    }
}]);
rti_app.filter("sanitize", ['$sce', function($sce) {
        return function(htmlCode){
            return $sce.trustAsHtml(htmlCode);
        }
    }]);

rti_app.filter('customDateFormat', function() {
        return function(item) {
            //2015-05-04 18:15:58
            var year = item.substring(0,4);
            var month = item.substring(5,7);
            var day = item.substring(8,10);
            var hour = item.substring(11,13);
            var min = item.substring(14,16);
            var sec = item.substring(17, 19);
            console.log(year, (month-1), day, hour, min, sec, 0)
            return new Date(year, (month-1), day, hour, min, sec, 0).getTime();
        }
    });
rti_app.service('noty', ['$rootScope', function( $rootScope ) {
        var queue = [];
        return {
            queue: queue,
            add: function( msg, type, icon ) {
                
                for(var i = 0; i < this.queue.length; i++)
                    this.remove();
                
                var item = {};
                item.body = msg;
                item.type = type;
                item.icon = icon;
                if(type == undefined) item.type = 'info';
                if(icon == undefined) item.icon = 'info';
                this.queue.push(item);
                
                
                setTimeout(this.remove,2000);
            },
            remove: function(){                
                // remove the alert after 2000 ms
                $('.alerts .alert').eq(0).remove();
                queue.shift();
            },
            success: function( msg ) {                
                this.add(msg, 'success', 'check');
            },
            error: function( msg ) {
                this.add(msg, 'danger', 'exclamation');
            },
            info: function( msg ) {
                this.add(msg);
            },
            pop: function(){
                return this.queue.pop();       
            },
            close: function(index){
                $('.alerts .alert').eq(index).remove();
            }
        };
    }]);



rti_app.factory('AuthInterceptor',['AuthTokenFactory',function AuthInterceptor(AuthTokenFactory) {

    return {
        request: addToken,
        response: function(response) {
            
            return response;
        }
    };

    function addToken(config)
    {
        var token = AuthTokenFactory.getToken();
        if (token) {
                config.headers = config.headers || { }; // existing headers or new ones.
                config.headers.Authorization = 'X-token ' + token;
                config.headers['X-token'] = token;
        }
        
        return config;
    }
}]);



rti_app.factory('AuthTokenFactory', function AuthTokenFactory($window) {
    var store = $window.localStorage;
    var key = 'auth-token';
    var user = 'user';
    var expires_at = 'expires-at';
    return {
        getToken: getToken,
        setToken: setToken,
        removeToken: removeToken,
        getUser: getUser,
        setUser: setUser,
        removeUser: removeUser,
        getExpiresAt: getExpiresAt,
        setExpiresAt: setExpiresAt,
        removeExpiresAt: removeExpiresAt,
        getField: getField,
        setField: setField,
        removeField: removeField,
        isValidUser : isValidUser,
        isValidToken : isValidToken,
        clearAll : clearAll
    };

    function getToken() {
      return store.getItem(key);
    }

    function setToken(token) {
        if (token) {
            store.setItem(key, token);
        } else {
            store.removeItem(key);
        }
    }

    function removeToken() {
      return store.removeItem(key);
    }
    
    function getUser() {
        return store.getItem(user);
    }

    function setUser(cUser) {
        if (cUser) {
            store.setItem(user, (cUser));
        } else {
            store.removeItem(user);
        }
    }

    function removeUser() {
        return store.removeItem(user);
    }
    
    function isValidUser() {
        var user = this.getUser();
        
        if (user == null || parseInt(user) <= 0)
        {
            //alerts.add("Not a valid user!!");
            return false;
        }
        return true;
    }
    
    function isValidToken() {
        var expires_at = this.getExpiresAt();
        var curTime = new Date().getTime();
        
        if ((expires_at*1000) < curTime ) {
           // alerts.add("Not a valid token!! cur : " + curTime + " Exp : " + expires_at*1000);
            return false;
        }
        
        return true;
    }
    
    function clearAll() {
        store.clear();
    }
    
    function getExpiresAt() {
      return store.getItem(expires_at);
    }

    function setExpiresAt(e_at) {
        if (expires_at) {
            store.setItem(expires_at, e_at);
        } else {
            store.removeItem(expires_at);
        }
    }

    function removeExpiresAt() {
        return store.removeItem(expires_at);
    }
    
    function getField(field) {
      return store.getItem(field);
    }

    function setField(field, value) {
        if (value) {
            store.setItem(field, value);
        } else {
            store.removeItem(field);
        }
    }

    function removeField(field) {
        return store.removeItem(field);
    }
});

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
        },
        sessionuser: function() {
            return $http.post( REST_API_URL + API.SESSION_USER, {} );
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
                $('#loadingPassword').html('');
                $("#forgotPasswordBtn").removeAttr('disabled');
                $(".forgotPasswordBtn, .emailfield").css('display','block');
                $rootScope.handleError(error) ;   
            });
    }
    
    $scope.error = {};    

    $scope.logout = function(){
        AccountService.logout()
            .success(function(response){
                AuthTokenFactory.removeToken();
                AuthTokenFactory.removeUser();
                AuthTokenFactory.removeExpiresAt();
                $window.location.reload();
            })
            .error($scope.handleError);
    }
}]);


var login = function() {       

    var email = $('#signInEmail').val();
    var password = $('#signInPassword').val();

     if (email.length == 0 && password.length == 0)
    {
        alerts.add("Please fill the fields");
        return false;
    }

    var regEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (email.length != 0) { 
        var varg = regEmail.test(email);
        if(!regEmail.test(email))
        {
            alerts.add("Please enter correct email id");
            return false;
        }
    }
    else
    {
        alerts.add("Please enter email id");
        return false;
    }

    if (password.length == 0) { 
        alerts.add("Please enter password");
        return false;
    }

    $.ajax({
        url : base_url+"account/login",
        type: "POST",
        data: {"email":email, "password":password},
        success: function(response, textStatus, jqXHR)
        {
            if (response.success == 0) {
                alerts.add(response.message);
                return;
            }
            else
            {
                localStorage.setItem("auth-token", response.user.token);
                localStorage.setItem("user", response.user.id);
                localStorage.setItem("expires_at", response.user.expires_at);
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
                    location.reload();
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            var responseMessage = jqXHR.responseJSON.message;
            alerts.add(responseMessage); 
        }
    });
}


var signup = function() {

        var email = $('#signUpEmail').val();
        var password = $('#signUpPassword').val();
        var confirmPassword = $('#signUpRePassword').val();
        var regEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

        if (email.length == 0 && password.length == 0 && confirmPassword.length == 0)
        {
            alerts.add("Please fill the fields");
            $("#signUpEmail").focus();
            return false;
        }

        if (email.length != 0) { 
            var varg = regEmail.test(email);
            if(!regEmail.test(email))
            {
                alerts.add("Please enter correct email id");
                $("#signUpEmail").focus();
                return false;
            }
        }
        else
        {
            alerts.add("Please enter email id");
            return false;
        }
        
        if (password.length == 0) { 
            alerts.add("Please enter password");
            $("#signUpPassword").focus();
            return false;
        }
        
        var regxLowerCase = /[a-z]/;
        var regxUpperCase = /[A-Z]/;
        var regxNumber = /[0-9]/;
        var regxSpecial = /[!@#$%^&*()_+~]/;
        
        if (password.search(regxLowerCase) == -1 ||
            password.search(regxUpperCase) == -1 ||
            password.search(regxNumber) == -1 ||
            password.search(regxSpecial) == -1 ||
            password.length < 8) {
            alerts.add("Password should contain atleast 1 Lowercase, 1 Uppercase, 1 Number, 1 Special character and should be 8 character long!");
            $("#signUpPassword").focus();
            return false;
        }
        
        if (confirmPassword.length == 0) {
            alerts.add("Please re-type password");
            $("#signUpRePassword").focus();
            return false;
        }
        
        if (password != confirmPassword) {
            alerts.add("Passwords entered doesn't match");
            $("#signUpRePassword").focus();
            return false;
        }
        else{
            $('#loadingSignUp').html('<img src="'+base_url + 'media/images/ajax_loader.gif" class="width_30"> Please Wait...');
            $(".signUpBtn").css('display','none');
        }
        

        $.ajax({
        url : base_url+"account/signup",
        type: "POST",
        data: {"email":email, "password":password},
        success: function(response, textStatus, jqXHR)
        {
            $('#loadingSignUp').html('');
            if (response.error) {
                $(".signUpBtn").css('display','block');
                alerts.add(response.message);
                return;
            }
            else
            {
                localStorage.setItem("auth-token", response.user.token);
                localStorage.setItem("user", response.user.id);
                localStorage.setItem("expires_at", response.user.expires_at);
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
                        location.reload();
                    }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            var responseMessage = jqXHR.responseJSON.message;
            alerts.add(responseMessage); 
        }
    });
        
}