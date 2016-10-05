var pageName = '';
var articleContentHeight = 0;
var setPopularButtonClick = 'false';
var setLatestButtonClick = 'false';
var isResetPage = 'false';

var alerts = function(){};
alerts.type = {
    error : 'alert-danger',
    info : "alert-info"
}
alerts.add = function( message, type ) {
    if (type == undefined || type == null) {
        type = alerts.type.error;
    }
    var alert = '<div class="alerts">' +
                    '<div class="alert ' + type + ' alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong>Error!</strong> ' + message +
                    '</div>' +
                '</div>';
    $("body").append(alert);
    hideAlertInterval = setInterval(hideAlerts,2000);
}

jQuery(window).load(function(event) {
    loadBannerImage();
	bindEvent();
	articleHover();
	videoPlayButton();
	forumImageDiv();
	setArticleHomeContent();
	//setArticleContent();
	//setGetResultPageContent();
    search();
    setProfileUI();
})

$(document).ready(function(){
	//stickyHeader();
	var queryString = window.location.search.substring(1);
    var varArray = queryString.split("="); //eg. index.html?msg=1

    isResetPage = varArray[1];

	if(isResetPage == 'true' && !validateSessionUser())
	{
		$('.loginContainerFull').show();
		$('#collapseLogin').collapse('show');
		$('input').val('');
	}

	$('.carousel-inner').carousel();
	if($('#dg-container').length == 1)
		$('#dg-container').gallery();
	if($('.pgwSlider').length == 1)
	{		
		if($(window).width() < 768) {
			var pgwSlider = $('.pgwSlider');
			$('.pgwSlider').pgwSlider();
			pgwSlider.startSlide({
				autoSlide: true,
				displayList: true,
				listPosition: 'right'
		    });
		}	
	}	
	if($('.filterArticlesbutton').length >= 1) {
		var selectedCategory = $('.filterArticlesbutton').next('.dropdown-menu').find('.active').html();
		$('.filterArticlesbutton .selectedCategory').html(selectedCategory);
	}
	if($('.filterForumButton').length >= 1) {
		var selectedCategory = $('.filterForumButton').next('.dropdown-menu').find('.active').html();
		$('.filterForumButton .selectedCategory').html(selectedCategory);
	}
});
$( window ).resize(function() {
	//stickyHeader();
});
$(document).keyup(function(event) { 
    if (event.which == 27) 
    {
    	if($('.loginContainerFull').is(":visible")){
    		$('.closePopup').click(); 
    	}
    	if($('.signupPopupContainer').is(":visible")){
    		$('.linkedInClosePopupIcon').click(); 
    	}
    	if($('.forgotPasswordFull').is(":visible")){
    		$('.forgotPasswordClosePopup').click(); 
    	}
    	if($('.newThreadsFull').is(":visible")){
    		$('.newThreadsClosePopupIcon').click(); 
    	}
    }
});

var stickyHeader = function(){
	$(window).scroll( function() {
		if($( window ).width() > 995)
		{
		    if( $(this).scrollTop() > 1 ) {
		       $('.headerColor').addClass("navbar-fixed-top");
		    }
		    else {
		        $('.headerColor').removeClass("navbar-fixed-top");
		    }
		}
	});
}

var articleHover = function(){
	$( ".socialLinks")
		.mouseover(function() {
			$(this).find('.articleFooter').css('display','block');
			$(this).find('.articleShareIcon').show();
		});
	$( ".socialLinks")
		.mouseout(function() {
			$(this).find('.articleFooter').css('display','none');
			$(this).find('.articleShareIcon').hide();
		});
}

var setArticleHomeContent = function() {
	if($(window).width() >= 768 && pageName != 'ARTICLES')
	{
		articleContentHeight = 0;
		if($('.singleArticle').length >= 1)
		{
			$('.articleContent p').each(function(){
				if($(this).parents('.ng-hide').length != 1)
				{
					if(articleContentHeight < parseInt($(this).height()))
					{
						articleContentHeight = parseInt($(this).height());
					}
				}
			});
			
			$('.articleContent p').each(function(){
				if($(this).parents('.ng-hide').length != 1)
				{
					$(this).css({'max-height':articleContentHeight,'min-height':articleContentHeight});	
				}
			});
		}
	}
}

/*var setArticleContent = function() {
	if($(window).width() >= 768 && (pageName == 'ARTICLES' || pageName == 'INSIGHTS'))
	{
		if($('.singleArticle').length >= 1)
		{
			$('.singleArticle').each(function(){
				if($(this).parents('.article.ng-hide').length < 1)
				{					
					if($(this).find('.articleImg img').length == 0 || $(this).find('.articleImg .videoLink').length == 0)
					{
						$(this).find('.singleArticle').css('margin', '0 0 20px 0');
						$(this).find('.socialLinks').css({'position':'relative','bottom':'0px','marginTop':'10px','float':'left'});
						$(this).find('.articlereadmore').css({'position':'relative','float':'right','marginTop':'16px'});
					}
					else
					{
						var articleHeadHeight = parseInt($(this).find('.articleContent').find('h3').height());
						articleHeadHeight += parseInt($(this).find('.articleContent').find('p').height());
						articleHeadHeight += parseInt($(this).find('.articleContent').find('.articlereadmore').height());

						var articleContainerHeight = parseInt($(this).height());
						$(this).find('.articleContent').css('height',articleContainerHeight);	

						articleContainerHeight = articleContainerHeight-articleHeadHeight;
						if(articleContainerHeight < 0)
							articleContainerHeight += 50;

						$(this).find('.articleContentDesc').css({'max-height': articleContainerHeight , 'overflow': 'hidden'});
				
					}
				}
			});
		}
	}
}*/

/*var setGetResultPageContent = function() {
	if($(window).width() >= 768 && pageName == 'SEARCH RESULTS')
	{
		if($('.singleSearchResult').length >= 1)
		{
			$('.singleSearchResult').each(function(){
				if($(this).find('.resultTypeImg img').height() < $(this).find('.searchResultContent').height())
				{
					$(this).find('.singleSearchResult').css('margin', '0 0 20px 0');
					$(this).find('.socialLinks').css({'position':'relative','bottom':'0px','marginTop':'10px','float':'left'});
					$(this).find('.articlereadmore').css({'position':'relative','float':'right','marginTop':'16px'});
				}
				else
				{
					var searchResultHeadHeight = parseInt($(this).find('.searchResultContent').find('h3').height());
					searchResultHeadHeight += parseInt($(this).find('.searchResultContent').find('p').height());
					searchResultHeadHeight += parseInt($(this).find('.searchResultContent').find('.articlereadmore').height());

					var searchResultContainerHeight = parseInt($(this).height());
					$(this).find('.searchResultContent').css('height',searchResultContainerHeight);	

					searchResultContainerHeight = searchResultContainerHeight-searchResultHeadHeight;
					if(searchResultContainerHeight < 0)
						searchResultContainerHeight += 50;

					$(this).find('.searchResultContentDesc').css({'max-height': searchResultContainerHeight , 'overflow': 'hidden'});				
				}				
			});
		}
	}
}*/

var videoPlayButton = function(){
	$(".videoImgContent")
		.mouseover(function() {
			$(this).children().find('.play').hide();
			$(this).children().find('.playHover').show();
		})
		.mouseout(function() {
			$(this).children().find('.playHover').hide();
			$(this).children().find('.play').show();
		});
}
var forumImageDiv = function(){
	$(".forumImageDiv")
	.mouseover(function() {
			$(this).children().find('.forumImageInnerContent span').show();
		})
		.mouseout(function() {
			$(this).children().find('.forumImageInnerContent span').hide();
		});
}



function imageIsLoaded(e, id) {
    console.log(id, e.target.result);
    $('#'+id).attr('src', e.target.result);
};

var bindEvent = function(){
	    
	$('.logInButton').unbind('click');
	$('.logInButton').bind('click', function(event){
		$('.loginContainerFull').show();
		$('#loginTab a:first').tab('show');
		$('#collapseLogin').collapse('show');
		$('input').val('');
		//$("#signInEmail, #signInPassword, #signUpEmail, #signUpPassword, #signUpRePassword").val("");
	});

	$('.registerButton').unbind('click');
	$('.registerButton').bind('click', function(event){
		$('.loginContainerFull').show();
		$('#collapseSignup').collapse('show');
		$('input').val('');	
		//$("#signInEmail, #signInPassword, #signUpEmail, #signUpPassword, #signUpRePassword").val("");
	})

	$('#signInTab .panel-heading').on('click', function(){
		$('.panel-collapse').collapse('toggle');
	});

	$('.signUpButton').unbind('click');
	$('.signUpButton').bind('click', function(event){
    
		event.preventDefault();
		$('.loginContainerFull').show();
		$('#loginTab a:last').tab('show');
		$(".signUpBtn").css('display','block');
		//$("#signInEmail, #signInPassword, #signUpEmail, #signUpPassword, #signUpRePassword").val("");
	})

	$('.forgot').unbind('click');
	$('.forgot').bind('click', function(event){
		event.preventDefault();
		$('.loginContainerFull').hide();
		$('.forgotPasswordFull').show();
	})

	$('.closePopup').unbind('click');
	$('.closePopup').bind('click', function(event){
		event.preventDefault();
		$('.loginContainerFull').hide();
		$(".signUpBtn").css('display','block');		
		$('.panel-collapse').collapse('hide');
		isResetPage == 'false';
	})
	
	$('.forgotPasswordClosePopup, .ForgotPasswordContainer').unbind('click');
	$('.forgotPasswordClosePopup, .ForgotPasswordContainer').bind('click', function(){
		$(".forgotPasswordBtn, .emailfield").css('display','block');
		$(".forgotPasswordText").css('display','none');
		$("#registeredEmail").val("");
		$('.forgotPasswordFull').hide();	
		$('.panel-collapse').collapse('hide');
	})

	$('#loginTab a').click(function (event) {
		event.preventDefault()
		$(this).tab('show')
	})

	$('.dropdown-menu').find('form').click(function(e) {
		e.stopPropagation();
	});

	// Threads Popup
	//$('#add_new_threads').unbind('click');
	$('.newThread').on('click', function(event){
		//event.preventDefault();
        if (validateSessionUser()) {
        	document.getElementById('thread_category').selectedIndex = 0;
        	//$('select option:disabled').attr('selected','selected');
            $('.newThreadsFull').show();
        }
	})

	$('.newThreadsClosePopupIcon, .similarThreadsClosePopupIcon').unbind('click');
	$('.newThreadsClosePopupIcon, .similarThreadsClosePopupIcon').bind('click', function(event){
		event.preventDefault();
		$('.newThreadsFull').hide();
		$('.similarThreadsPopup').css('display','none');
		$('.newThreadsPopup').show();
		$('.threadHeadingInput').val('');
		$('.threadContentInput').val('');
		$("#thread_category").find('option').removeAttr("selected");
	})

	//$('#thread_submit_btn').unbind('click');
	//$('#thread_submit_btn').bind('click', function(event){
	//	event.preventDefault();
	//	$('.similarThreadsPopup').show();
	//	$('.newThreadsPopup').css('display','none');
	//})	
	
	$('#back_add_thread').unbind('click');
	$('#back_add_thread').bind('click', function(event){
		event.preventDefault();
		$('.similarThreadsPopup').css('display','none');
		$('.newThreadsPopup').show();
	})	;

	$("input:file").change(function () {
        if (this.files && this.files[0]) {
            console.log(this.files[0]);
            //Validate file upload type
            if (this.files[0].type != "image/jpeg" &&
                this.files[0].type != "image/jpg" &&
                this.files[0].type != "image/png") {
                alerts.add("Please select only 'jpeg/jpg/png' file types!", alerts.type.error);
                //this.files = null;
                return false;
            }
            
            var reader = new FileReader();
            
            reader.onload = function(e){ 
                $('#profile_pic').attr('src', e.target.result);
                $('.articleImg').attr('src', e.target.result);
            	$('.articleImg').show();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#add_new_article').unbind();
    $('#add_new_article').bind('click', function(event) {
        event.preventDefault();
        if (!validateSessionUser()) {
            return false;
        }
    	$('.addNewArticle').show();
    	$("#myTags").tagit();
		//Intialise the editor
		initSample();
        
        return true;
    });


    $('.closeNewArticlePopup').unbind('click');
	$('.closeNewArticlePopup').bind('click', function(event){
		event.preventDefault();
		$('.addNewArticle').hide();
	});

	$('.filterArticlesbutton').on( 'click', function( event ) {
		var selectedCategory = $(this).next('.dropdown-menu').find('.active').html();
		$(this).find('.selectedCategory').html(selectedCategory);
	});

	$('.filterForumButton').on( 'click', function( event ) {
		var selectedCategory = $(this).next('.dropdown-menu').find('.active').html();
		$(this).find('.selectedCategory').html(selectedCategory);
	});

	$('#forumMore').on('click',function(){
		$('.categorydropdown').toggle();
		$(this).find('span').toggle();
	});

	/*$('.pagination li a').on('click', function(){
		setArticleContent();
	});

	$('.filterArticles li a').on('click', function(){
		setArticleContent();
	});

	$('.popularButton').on('click', function(){
		if(setPopularButtonClick == 'false')
			setArticleContent();		
		setPopularButtonClick = 'true';
	});

	$('.latestButton').on('click', function(){
		if(setLatestButtonClick == 'false')
			setArticleContent();		
		setLatestButtonClick = 'true';
	});*/

	if(pageName == "EVENTS") {
		if(upcomingEventCount > 4)
			upcomingEventCount = 4;

		$("#owl-events").owlCarousel({ 
		    // Most important owl features		    
		    items : upcomingEventCount,
		    itemsCustom : false,
		    itemsDesktop : [1199,upcomingEventCount],
		    itemsDesktopSmall : [980,upcomingEventCount],
		    itemsTablet: [768,2],
		    itemsTabletSmall: false,
		    itemsMobile : [479,1],
		    singleItem : false,
		    itemsScaleUp : false,
		 
		    //Basic Speeds
		    slideSpeed : 200,
		    paginationSpeed : 800,
		    rewindSpeed : 1000,
		 
		    //Autoplay
		    autoPlay : false,
		    stopOnHover : false,
		 
		    // Navigation
		    navigation : true,
		    navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
		    rewindNav : false,
		    scrollPerPage : false,
		 
		    //Pagination
		    pagination : false,
		    paginationNumbers: false,
		 
		    // Responsive 
		    responsive: true,
		    responsiveRefreshRate : 200,
		    responsiveBaseWidth: window,
		 
		    // CSS Styles
		    baseClass : "owl-carousel",
		    theme : "owl-theme",
		 
		    //Lazy load
		    lazyLoad : false,
		    lazyFollow : true,
		    lazyEffect : "fade",
		 
		    //Auto height
		    autoHeight : false,
		 
		    //JSON 
		    jsonPath : false, 
		    jsonSuccess : false,
		 
		    //Mouse Events
		    dragBeforeAnimFinish : true,
		    mouseDrag : true,
		    touchDrag : true,
		 
		    //Transitions
		    transitionStyle : false,
		 
		    // Other
		    addClassActive : false		 
		});

		if(upcomingEventCount < 4) {
			var outerEventWidth = upcomingEventCount * 270;
			$('#owl-events .owl-wrapper').css({'width':outerEventWidth,'margin':'auto'});
			$('#owl-events .owl-item').css('width','270px');
		}

		if(pastEventCount > 4)
			pastEventCount = 4;


		$("#owl-past-events").owlCarousel({ 
		    // Most important owl features		    
		    items : pastEventCount,
		    itemsCustom : false,
		    itemsDesktop : [1199,pastEventCount],
		    itemsDesktopSmall : [980,pastEventCount],
		    itemsTablet: [768,2],
		    itemsTabletSmall: false,
		    itemsMobile : [479,1],
		    singleItem : false,
		    itemsScaleUp : false,
		 
		    //Basic Speeds
		    slideSpeed : 200,
		    paginationSpeed : 800,
		    rewindSpeed : 1000,
		 
		    //Autoplay
		    autoPlay : false,
		    stopOnHover : false,
		 
		    // Navigation
		    navigation : true,
		    navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
		    rewindNav : false,
		    scrollPerPage : false,
		 
		    //Pagination
		    pagination : false,
		    paginationNumbers: false,
		 
		    // Responsive 
		    responsive: true,
		    responsiveRefreshRate : 200,
		    responsiveBaseWidth: window,
		 
		    // CSS Styles
		    baseClass : "owl-carousel",
		    theme : "owl-theme",
		 
		    //Lazy load
		    lazyLoad : false,
		    lazyFollow : true,
		    lazyEffect : "fade",
		 
		    //Auto height
		    autoHeight : false,
		 
		    //JSON 
		    jsonPath : false, 
		    jsonSuccess : false,
		 
		    //Mouse Events
		    dragBeforeAnimFinish : true,
		    mouseDrag : true,
		    touchDrag : true,
		 
		    //Transitions
		    transitionStyle : false,
		 
		    // Other
		    addClassActive : false		 
		});

		if(pastEventCount < 4) {
			var outerEventWidth = pastEventCount * 270;
			$('#owl-past-events .owl-wrapper').css({'width':outerEventWidth,'margin':'auto'});
			$('#owl-past-events .owl-item').css('width','270px');
		}

		if(upcomingEventCount == 0 && pastEventCount == 0){
			$('#noEvent').show();
		}
	}

	$('.readmoreEvent').mouseover(function(){
		$(this).next('.showOnHoverEventContent').show();
	});

	$('.readmoreEvent').mouseout(function(){
		console.log('in');
		$(this).next('.showOnHoverEventContent').hide();
	});

	$('#owl-events .owl-item').mouseover(function(){
		console.log('out');
		$(this).find('.showOnHoverEventContent').show();
	});

	$('#owl-events .owl-item').mouseout(function(){
		$(this).find('.showOnHoverEventContent').hide();
	});

	$('#owl-past-events .owl-item').mouseover(function(){
		$(this).find('.showOnHoverEventContent').show();
	});

	$('#owl-past-events .owl-item').mouseout(function(){
		$(this).find('.showOnHoverEventContent').hide();
	});
    
    $('#edit_profile').on('click',function(){
        $('#profileListView').hide();
        $('#profileUpdate').removeClass('no-display');
    });

    $('#cancel_profile').on('click',function(){
        $('#profileListView').show();
        $('#profileUpdate').addClass('no-display');
    });

    
	$("#profilePicUpload").change(function(){
	    readURL(this);
	});

	$("#profileUploadSignUp").change(function(){
	    readProfile(this);
	});
}

function search() {
    $(".searchControl").keyup(function(e, keyCode){
        $(".searchControl").val($(this).val().toLowerCase());
        if(e.keyCode == 13) {
            searchFormSubmit();
        }
    });
}

function searchFormSubmit() {
    document.forms['searchForm'].action=$APP_BASE_URL+'search/'+document.getElementById('searchControl').value;
    document.forms['searchForm'].submit();
}

function ValidateProfile() {
    if($.trim($("form[name='profileUpdate'] #firstname").val()).length == 0) {
        alerts.add("Firstname is required!");
        $("form[name='profileUpdate'] #firstname").focus();
        return false;
    }
    
    if($.trim($("form[name='profileUpdate'] #jobtitle").val()).length == 0) {
        alerts.add("Job title is required!");
        $("form[name='profileUpdate'] #jobtitle").focus();
        return false;
    }
    
    if($.trim($("form[name='profileUpdate'] #biodata").val()).length == 0) {
        alerts.add("Bio data is required!");
        $("form[name='profileUpdate'] #biodata").focus();
        return false;
    }
    return true;
}

// Change Password functionality
function ChangePassword(){
   
    if($.trim($("form[name='changePassword'] #oldPassword").val()).length == 0) {
        alerts.add("Old Password is required!");
        $("form[name='changePassword'] #oldPassword").focus();
        return false;
    }
    
    if($.trim($("form[name='changePassword'] #password").val()).length == 0) {
        alerts.add("New Password is required!");
        $("form[name='changePassword'] #password").focus();
        return false;
    }
        
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();
    
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
        $("form[name='changePassword'] #password").focus();
        return false;
    }
    
    if($.trim($("form[name='changePassword'] #confirmPassword").val()).length == 0) {
        alerts.add("Confirm Password is required!");
        $("form[name='changePassword'] #confirmPassword").focus();
        return false;
    }
    
    if (password != confirmPassword) {
        alerts.add("Passwords entered doesn't match");
        $("form[name='changePassword'] #confirmPassword").focus();
        return false;
    }
    return true;
}

function validateSessionUser()
{
    var user = localStorage['user'];
    var authToken = localStorage['auth-token'];
    var exipresAt = localStorage['expires-at'];
    
    if(user == undefined || user == null || authToken == undefined || authToken == null ||
        parseInt(user) <= 0 )
    {
        alerts.add("Please login/sign up to continue", alerts.type.error);
        return false;
    }
    
    var curTime = new Date().getTime();
    if ((exipresAt*1000) < curTime ) {
        alerts.add("Please login/sign up to continue", alerts.type.error);
        window.location.reload();
        return false;
    }
    
    return true;
}

function ValidateArticle() {
    
    if (!validateSessionUser()) {
        return false;
    }
    
    if ($.trim($("form#addArticleForm #article_title").val()).length <= 0) {
        alerts.add("Please enter article title!", alerts.type.error);
        $("form#addArticleForm #article_title").focus();
        return false;
    }
    
    var data = CKEDITOR.instances.editor.getData();
    
    $("form#addArticleForm #article_content").val(data);
    
    if ($.trim($("form#addArticleForm #article_content").val()).length <= 0) {
        //alerts.add("Please enter article content!");
        alerts.add("Please enter article content!", alerts.type.error);
        $("form#addArticleForm #article_content").focus();
        return false;
    }
    
    if ($.trim($("form#addArticleForm #article_category").val()).length <= 0) {
        //alerts.add("Please choose article category!");
        alerts.add("Please choose article category!", alerts.type.error);
        $("form#addArticleForm #article_category").focus();
        return false;
    }
    
    var tagsLength = $("#myTags .tagit-choice").length;
    
    if (tagsLength == 0) {
        alerts.add("Please enter article tags", alerts.type.error);
        $("form#addArticleForm #myTags").focus();
        return false;
    }
    
    if ($.trim($("form#addArticleForm #article_image").val()).length <= 0) {
        //alerts.add("Please upload an article image!");
        alerts.add("Please upload an article image!", alerts.type.error);
        $("form#addArticleForm #article_image").focus();
        return false;
    }
    
    var article_image = $.trim($("form#addArticleForm #article_image").val());
    var extension = article_image.split('.').pop().toUpperCase();
    if (extension!="PNG" && extension!="JPG" && extension!="GIF" && extension!="JPEG"){
        alerts.add("Invalid file type. Please choose only jpg/jpeg/png files!", alerts.type.error);
        return false;
    }
    $("form#addArticleForm #articleSubmitButton").attr('disabled','disabled');
    return true;
}

function ValidateInquiry()
{
    var name = $('#name').val();
    if (name == '')
    {
	alerts.add("Please enter your name!", alerts.type.error);
	$("#name").focus();
	return false;
    }

    var email = $('#email').val();
    var emailExpression = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (!email.match(emailExpression))
    {
	alerts.add("Please enter valid email id!", alerts.type.error);
	$("#email").focus();
        return false;
    }

//    var website = $('#website').val();
//    if (website == '')
//    {
//	alerts.add("Please enter the name of the website!", alerts.type.error);
//	$("#website").focus();
//        return false;
//    }
    
    var text = $('#message').val();
    if (text == '')
    {
	alerts.add("Please fill the message section!", alerts.type.error);
	$("#text").focus();
        return false;
    }

    return true;
}

function loadBannerImage(){
	var image = new Image();
	image.src = $APP_BASE_URL + 'media/images/Cover Page.jpg';
}

function hideAlerts() {
    $('.alerts').remove();
    clearInterval(hideAlertInterval);
}

function setProfileUI() {
    $(".profile-tab").hide();
    $(".profile-tab#update-profile").show();
    $(".profile-list li a").click(function() {
        var href = $(this).attr("href");
        $(".profile-tab").hide();
        $(".profile-tab" + href).show();
    })
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile_pic').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function readProfile(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

     var fileType = input.files[0].type.split('/');
     console.log(fileType[0]);
    if(fileType[0] == 'image')
    	$('#signUpSave').show();
    else
    	$('#signUpSave').hide();

        reader.readAsDataURL(input.files[0]);
    }
}
