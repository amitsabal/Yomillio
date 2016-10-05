'use strict'
//var thumbnail_image, banner_image, featured_image_small, featured_image_large = '';
var thumbnail_image, article_id, article_type_id;

app.config(['$stateProvider', '$urlRouterProvider','$httpProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('rti.articles-list', {
			url: '/articles-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/articles/articles.list.tpl.html'
				}
            },
			controller : 'articlesCntrl',
            data: {
                page : "Articles"
            }
		})
        .state('rti.articles-save', {
			url: '/articles-save',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/articles/articles.save.tpl.html'
				}
            },
			controller : 'articlesCntrl',
            data: {
                page : "Add New Article"
            }
		})
        .state('rti.articles-save/:id', {
			url: '/articles-save/:id',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/articles/articles.save.tpl.html'
				}
            },
			controller : 'articlesCntrl',
            data: {
                page : "Edit Article"
            }
		})
        .state('rti.submitted-articles-list', {
			url: '/submitted-articles-list',
			views: {
				'main-content@' : {
					templateUrl: 'partials/tpl/pages/articles/submitted.articles.list.tpl.html'
				}
            },
			controller : 'articlesCntrl',
            data: {
                page : "Articles"
            }
		});
    }]);

app.factory('articlesService', function($http, REST_API_URL, AuthTokenFactory, API){
    
	return {
		
		getall : function(query_params) {
			//console.log(query_params);
			return $http({ url: REST_API_URL + API.ARTICLES_LIST , method: "GET", params: query_params });
			//return $http.get( REST_API_URL + API.ARTICLES_LIST , query_params, {cache: false} );
		},
		
		create : function(Article) {
            Article.created_by = AuthTokenFactory.getAdminUserId();
			var createresult = $http.post( REST_API_URL + API.ARTICLES_CREATE, Article );
			return createresult;
		},
		
		get : function(Article) {
            return $http.get( REST_API_URL + API.ARTICLES_GET + "/" + Article.id, Article, {cache: false} );
			
        },
		
		update : function(Article) {
            Article.updated_by = AuthTokenFactory.getAdminUserId();
			var updateresult = $http.put( REST_API_URL + API.ARTICLES_UPDATE, Article );
			return updateresult;
		},
        
        getallsubmitted : function() {
            return $http.get( REST_API_URL + API.ARTICLES_LIST + "?status=3", {cache: false} );
        },
        
        delete: function(article_id) {
            var data = {deleted_by : AuthTokenFactory.getAdminUserId()}
            return $http.delete( REST_API_URL + API.ARTICLES_DELETE + "/" + article_id + "?deleted_by=" + AuthTokenFactory.getAdminUserId(), data );
        },
        
        fileUpload: function(Article) {
            Article.created_by = AuthTokenFactory.getAdminUserId();
			var url = "fileupload.php?item_id="+Article.id+'&item_type_id='+Article.type_id+'&item_type=article';
			var createresult = $http.post( REST_API_URL + url, Article );
			return createresult;
        }
	}
});

app.controller('articlesCntrl', ['$scope','$rootScope', '$state', 'noty', 'articlesService', 'tagsService','categoriesService', 'APP_URL',
                                   function($scope,$rootScope, $state,  noty, articlesService, tagsService, categoriesService, APP_URL){
	$scope.noty = $rootScope.noty;
    $scope.articles = [];
    $scope.Article = {};
    $scope.Article.status = 1;
	$scope.Article.is_featured = 1;
    $scope.Article.type_id = 1;
	$scope.hideContent = false;
	$scope.tags = [];
	$scope.app_url = APP_URL;
	$scope.hideImage = false;
    $scope.showFileUploadCntrl = false;
	$rootScope.item_type = 'article';
	$('#loadingRecord').html('<img src="'+APP_URL+ 'img/ajax_loader.gif" style="width:100px;height:100px;"> Please Wait...');
	
	var editor = null;
	// setup editor options
	$scope.ckEditorOptions = {
		language: 'en',
		//uiColor: '#000000',
		allowedContent: true,
		filebrowserBrowseUrl : 'js/ckfinder/ckfinder.html',
		filebrowserImageBrowseUrl : 'js/ckfinder/ckfinder.html?type=Images',
		filebrowserFlashBrowseUrl : 'js/ckfinder/ckfinder.html?type=Flash',
		filebrowserUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
	};
    
    $scope.tagsConfig = {
        create: true,
        valueField: 'name',
        labelField: 'name',
        delimiter: ',',
        placeholder: 'Enter Tags',
        onInitialize: function(selectize){
          // receives the selectize object as an argument
        },
        // maxItems: 1
    };
    
    $scope.timeConfig = {
        create: false,
        valueField: 'time',
        labelField: 'time',
        delimiter: ',',
        placeholder: 'Select Published Time',
        onInitialize: function(selectize){
          // receives the selectize object as an argument
        },
        maxItems: 1
    };
    
    $scope.time = [];
    var hIndex = 0; var mIndex = 0; var amPm = 0;
    //for(amPm = 0; amPm < 2; amPm++) {
        for(hIndex = 0; hIndex < 24; hIndex++) {
            for (mIndex = 0; mIndex < 60; mIndex += 5) {
                var hText = (hIndex.toString().length == 2) ? hIndex : "0"+hIndex;
                var mText = (mIndex.toString().length == 2) ? mIndex : "0"+mIndex;
                var tm =  hText + ":" + mText;// + " " + ((amPm == 0) ? "AM" : "PM");
                //console.log(tm);
                var t = {"time" : tm};
                $scope.time.push(t);
            }
        }
    //}

    if($state.current.name == "rti.articles-list") {
		var query_params = {
				status : [1,2,3],
			};
        articlesService.getall({})
            .success(function(response) {
                $scope.articles = response.articles;
				$('#loadingRecord').html('');
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
    
    if($state.current.name == "rti.submitted-articles-list") {
		
        articlesService.getallsubmitted($scope, $state)
            .success(function(response) {
                $scope.articles = response.articles;
				$('#loadingRecord').html('');				
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
    
    if($state.current.name == "rti.articles-save/:id" || $state.current.name == "rti.articles-save") {
        $("#thumbnail_display_image, #banner_display_image, #small_featured_display_image, #large_featured_display_image").css('display', 'none');
		$scope.hideImage = true;
        //editor = CKEDITOR.replace( 'content', {
        //    allowedContent: true,
        //    filebrowserBrowseUrl : 'js/ckfinder/ckfinder.html',
        //    filebrowserImageBrowseUrl : 'js/ckfinder/ckfinder.html?type=Images',
        //    filebrowserFlashBrowseUrl : 'js/ckfinder/ckfinder.html?type=Flash',
        //    filebrowserUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        //    filebrowserImageUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        //    filebrowserFlashUploadUrl : 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        //});
        //CKFinder.setupCKEditor( editor, '../' );
        
        $scope.categories = [];
        categoriesService.ddl()
            .success(function(response) {
                $scope.categories = response.categories;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
			
		tagsService.ddl()
            .success(function(response) {
				$scope.tags = response.tags;
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
    
    if($state.current.name == "rti.articles-save/:id") {
		$("#thumbnail_display_image, #banner_display_image, #small_featured_display_image, #large_featured_display_image").css('display', 'block');
		
        $scope.Article = {};
        $scope.Article.id = $state.current.data.params.id;
		
        articlesService.get($scope.Article)
            .success(function(response) {
                $("#title").focus();
                $scope.Article = response.article;
				$scope.showFeaturedImages = false;
				if ($scope.Article.is_featured == 1) {
					$scope.showFeaturedImages = true;	
				}
				$scope.showContent = false;
				$scope.showvideo = false;
				$scope.showimage = true;
                $scope.Article.user_submitted_image = 0;
                
				article_type_id = $scope.Article.type_id;
				if ($scope.Article.type_id == 1 || $scope.Article.type_id == 2) {
					$scope.showContent = true;
				}
				if ($scope.Article.type_id == 3) {
					$scope.showvideo = true;
				}
                
                if ($scope.Article.author_id > 0 &&
                    ($scope.Article.submitted_image != null && $scope.Article.submitted_image != '' && $scope.Article.submitted_image != undefined) &&
                    ($scope.Article.thumbnail_image == null || $scope.Article.thumbnail_image == '' || $scope.Article.thumbnail_image == undefined)) {
                    $scope.Article.user_submitted_image = 1;
                }
                
                if ( $scope.Article.author_id > 0 && $scope.Article.user_submitted_image == 1 ) {
                    $scope.showimage = false;
                }
               
//                try{
//					
//					editor.on('instanceReady', function() {
//						CKEDITOR.instances.content.setData(response.article.content);
//					});
//				}
//				catch(e){
//					
//				}
				
				var pathArray = window.location.href.split( '/' );
				var a_id = pathArray[(pathArray.length)-1];
				
				if ($scope.Article.thumbnail_image != '' && $scope.Article.thumbnail_image != null && $scope.Article.thumbnail_image != undefined) {
                    var image_url =  "src/image.php?file_name="+$scope.Article.id+'/'+$scope.Article.thumbnail_image;
					$("#thumbnail_display_image").attr('src', image_url );
				}
				else{
					$("#thumbnail_display_image").attr('src', "src/image.php");
				}
            })
            .error(function(error) {
                $rootScope.handleError(error);
            });
    }
	
    $scope.validateAndGoToPage = function(page) {
        //if ($scope.Article.id != undefined && $scope.Article.id != null && $scope.Article.id > 0) {
        //    if (($scope.Article.thumbnail_image == '' || $scope.Article.thumbnail_image == null || $scope.Article.thumbnail_image == undefined) &&
        //        ($scope.Article.status == 1 || $scope.Article.status == 2) &&
        //        (($scope.Article.author_id > 0 &&$scope.Article.submitted_image == '' || $scope.Article.submitted_image == null || $scope.Article.submitted_image == undefined))) {
        //        noty.error("Please upload an image to continue");
        //        return;
        //    }
        //}
        $rootScope.goToPage(page);
    }
	
	$scope.save = function(u) {
		//console.log(thumbnail_image);
		//console.log($scope.Article);
		$scope.Article.content = CKEDITOR.instances.content.getData();
        if (u == undefined) {
            noty.error("Fields marked with * are mandatory!");
            $("#title").focus();
            return;
        }
        if ($scope.Article.title == undefined || $scope.Article.title == null || $.trim($scope.Article.title) == "") {
            $scope.Article.title = "";
            noty.error("Please enter title");
            $("#title").focus();
            return;
        }
		else if ($scope.Article.summary == undefined || $scope.Article.summary == null || $.trim($scope.Article.summary) == "") {
            $scope.Article.summary = "";
            noty.error("Please enter summary");
            $("#summary").focus();
            return;
        }
        else if($scope.Article.category_id == undefined || $scope.Article.category_id == null || $scope.Article.category_id == ''){
        	noty.error("Please select Category");
            $("#category_id").focus();
            return;
        }
		else if (($scope.Article.type_id == 1 || $scope.Article.type_id == 2) && ( $scope.Article.content == "" || $.trim($scope.Article.content) == null ) ) {
            $scope.Article.content = "";
            noty.error("Please enter content");
            $("#content").focus();
            return;
        }
		else if ( $scope.Article.tags == '' || $scope.Article.tags == null || $scope.Article.tags == undefined) {
            noty.error("Please enter tags");
            $("#tags").focus();
            return;
		}
		else if ($scope.Article.tags != '' && $scope.Article.tags != null && $scope.Article.tags != undefined && $scope.Article.tags.length == 0) {
			noty.error("Please enter tags");
            $("#tags").focus();
            return;
		}
		if ($scope.Article.is_featured == undefined || $scope.Article.is_featured == null ) {
            noty.error("Please select if the article is featured or not");
            return;
        }
	
		else if ($scope.Article.status == undefined || $scope.Article.status == null ) {
            noty.error("Please select status");
            return;
        }
        if($scope.Article.type_id == 3 && ($scope.Article.video_id == undefined || $scope.Article.video_id == null || $scope.Article.video_id == '')){
        	noty.error("Please enter video url");
            $("#video_id").focus();
            return;
        }
        if ($scope.Article.status == 1 && ($scope.Article.published_at == undefined || $scope.Article.published_at == null)) {
            noty.error("Please enter published date");
            $("#published_at").focus();
            return;
        }
        if ($scope.Article.id == undefined || $scope.Article.id == null) {
			
            articlesService.create($scope.Article)
                .success(function (response){
                    if (response.error) {
                        noty.error(response.message);
                        return;
                    }
                    noty.success(response.message);
					thumbnail_image = '';
                    //$state.go("rti.articles-save/"+response.id);
					window.location.href = APP_URL+"#/articles-save/"+response.id;
                })
                .error(function(error){
                    $rootScope.handleError(error)    
                });
        }
        else {
            
            if ($scope.Article.status == 5 &&
                ($scope.Article.reasons_for_rejection == undefined || $scope.Article.reasons_for_rejection =='' || $.trim($scope.Article.reasons_for_rejection).length == 0))
            {
                noty.error("Please enter reasons for rejection");
                return;
            }
			
            if ($scope.Article.submitted_image != undefined &&
                ($scope.Article.thumbnail_image == null || $scope.Article.thumbnail_image == '' || $scope.Article.thumbnail_image == undefined) &&
                ($scope.Article.status == 1 || $scope.Article.status == 2 || $scope.Article.status == 3 || $scope.Article.status == 4) &&
                $scope.Article.author_id > 0) {
                articlesService.fileUpload($scope.Article)
                    .success(function (response){
                        angular.extend($scope.Article, response.uploadedFiles);
                        
                        articlesService.update($scope.Article)
                            .success(function (response){
                                if (response.error) {
                                    noty.error(response.message);
                                    return;
                                }
                                noty.success(response.message);
                                thumbnail_image = '';
                                $state.go("rti.articles-list");
                            })
                            .error(function(error){
                                $rootScope.handleError(error)    
                            });
                    })
                    .error(function(error){
                        
                    });
            }
            else {
				if (($scope.Article.id > 0) && ($scope.Article.type_id == 3) &&
					($scope.Article.thumbnail_image == '' || $scope.Article.thumbnail_image == null || $scope.Article.thumbnail_image == undefined)) {
					noty.error("Please upload video image");
					 return;
				  }
				  if (($scope.Article.id > 0) && ($scope.Article.type_id == 2) &&
					($scope.Article.thumbnail_image == '' || $scope.Article.thumbnail_image == null || $scope.Article.thumbnail_image == undefined)) {
					noty.error("Please upload infographics image");
					 return;
				  }
                if (($scope.Article.status == 1 || $scope.Article.status == 2) &&
                    ($scope.Article.thumbnail_image == '' || $scope.Article.thumbnail_image == null || $scope.Article.thumbnail_image == undefined)) {
                    noty.error("Please upload article image");
                    return;
                }
				
                
                articlesService.update($scope.Article)
                    .success(function (response){
                        if (response.error) {
                            noty.error(response.message);
                            return;
                        }
                        noty.success(response.message);
                        thumbnail_image = '';
                        $state.go("rti.articles-list");
                    })
                    .error(function(error){
                        $rootScope.handleError(error)    
                    });
            }
        }
    }
    
    $scope.deleteArticle = function(article_id) {
        articlesService.delete(article_id)
            .success(function (response){
                if (response.error) {
                    noty.error(response.message);
                    return;
                }
                noty.success(response.message);
                $state.go("rti.articles-list");
            })
            .error(function(error){
                $rootScope.handleError(error);    
            });
    }
    
    $scope.toggleDisplay = function(element) {        
        $scope[element] = ($scope[element]) ? false : true;
    }
}]);

