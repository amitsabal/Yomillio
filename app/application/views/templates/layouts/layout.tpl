<!DOCTYPE html>
<html lang="en" data-ng-app="zinnov-rti" data-ng-cloak>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="Zinnov,Blog,Article,Infographic,Video,Insight,Event">
	<meta http-equiv="description" content="Zinnov Return to India">
	
	
	<title>{$title} - {$name}</title>

	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/css/?f=bootstrap.min">
	<link rel="stylesheet" href="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/css/?f=bootstrap-theme.min">
	<link rel="stylesheet" href="{$MEDIA_FILES_URL}js/bower_components/font-awesome/css/?f=font-awesome.min">

	<!-- Page CSS -->
	<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/?f=checkbox,font,utilities,media,extensions,base">

	{block name="css"}{/block}
    <script type="text/javascript">
        var $APP_BASE_URL = "{$APP_BASE_URL}";
        var $MEDIA_FILES_URL = "{$MEDIA_FILES_URL}";
        
        //localStorage.clear();
        {if isset($smarty.session) && isset($smarty.session.session_user)}
            localStorage.setItem('user', {if isset($smarty.session.session_user->id)}'{$smarty.session.session_user->id}'{else}''{/if});
            localStorage.setItem('expires-at', {if isset($smarty.session.session_user->expires_at)}'{$smarty.session.session_user->expires_at}'{else}''{/if});
            localStorage.setItem('auth-token', {if isset($smarty.session.session_token)}'{$smarty.session.session_token}'{else}''{/if});
        {else}
            localStorage.removeItem('user');
            localStorage.removeItem('auth-token');
            localStorage.removeItem('expires-at');
            //localStorage.clear();
        {/if}     
    </script>

    {if $APP_BASE_URL == 'http://r2i.zinnov.com/'}
	{block name="ga"}{/block}
	{/if}
	{block name="meta"}{/block}
</head>
	<body data-ng-cloak data-ng-controller="AppCtrl">
        
        <!-- Alerts & Messages -->
        {if (isset($successMessage) && strlen(trim($successMessage)) > 0) || (isset($errorMessage) && strlen(trim($errorMessage)) > 0)}
        <div class="alerts">
            {if isset($successMessage) && strlen(trim($successMessage)) > 0 }
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {$successMessage}
            </div>
            {/if}
            {if isset($errorMessage)  && strlen(trim($errorMessage)) > 0}
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> {$errorMessage}
            </div>
            {/if}
        </div>
        {/if}
			<nav class="navbar-default headerColor">
				<img src="{$MEDIA_FILES_URL}images/scale.png" class="img-reponsive bottom-left width_100" />
				<div class="container">
					<div class="headder">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<div class="pull-right no-padding">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<a class="navbar-brand height-auto no-padding" href="{$APP_BASE_URL}"><img src="{$MEDIA_FILES_URL}images/logo.png" class="img-responsive"></a>
						</div>

						<!-- Search box login -->
						<div class="col-xs-12 col-sm-6 col-md-2 col-lg-3 pull-right padding-top-5 no-padding searchBox hidden-md hidden-lg hidden-sm">
							<div class="input-group padding-vertical-5 width_100">
								<form  name="searchForm" method="post">
                                    <div class="input-group">
                                        <input type="text" class="form-control searchControl" placeholder="Search" id="searchControl" value="{if isset($response.keyword)}{$response.keyword|upper}{/if}"/>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn user-btn" onClick="searchFormSubmit();">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div><!-- /btn-group -->
                                    </div>
                                </form>
				            </div><!-- /input-group -->
				         </div>
						<!-- Collect the nav links, forms, and other content for toggling  -->
						

						<div class="collapse navbar-collapse no-padding" id="bs-example-navbar-collapse-1">
							<span class="pull-right dropdown hidden-xs">
								<a href="#" class="dropdown-toggle linkBlack" data-toggle="dropdown" role="button" aria-expanded="true">
									<i class="fa fa-search searchIcon"></i>
								</a>
								<ul class="dropdown-menu searchDropdown" role="menu">
									<li>
										<form class="searchForm" name="searchForm">
											<div class="input-group searchBox width-250">
												<input type="text" class="form-control searchControl no-border" placeholder="Search" id="searchControl">
												<div class="input-group-btn">
								                  	<button type="button" class="btn user-btn no-border" id="search" onClick="searchFormSubmit();">
									                  	<i class="fa fa-search"></i>
								                  	</button>
												</div><!-- /btn-group -->
								            </div><!-- /input-group -->
								        </form>
									</li>
								</ul>
							</span>
                            
							<span class="pull-right dropdown hidden-xs" class="loginProfile" ng-controller="AccountCtrl"
                                style="display:{if isset($smarty.session) && isset($smarty.session.session_user) && isset($smarty.session.session_user->id)}block;{else}none;{/if}" >
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">									
                                    {if isset($smarty.session.session_user) && isset($smarty.session.session_user->profile_pic)}
                                    <img  src="{$MEDIA_FILES_URL}uploads/images/profile/{$smarty.session.session_user->profile_pic}" width="38" height="38" class="img-circle profile-pic" />
                                    {elseif isset($smarty.session.session_user) && isset($smarty.session.session_user->linkedin_picture_url) && strlen(trim($smarty.session.session_user->linkedin_picture_url)) > 0}
                                    <img  src="{$smarty.session.session_user->linkedin_picture_url}" class="img-circle profile-pic" width="38" height="38" />
                                    {else}
                                    <img src="{$MEDIA_FILES_URL}images/user.png" class="img-circle profile-pic" width="38" height="38">
                                    {/if}
								</a>
								<ul class="dropdown-menu loginProfileDropdown" role="menu">
									<li>
										<form>
											<div class="searchBox width-300">
												<div class="col-xs-12">
													<div class="col-xs-5">
                                                        {if isset($smarty.session.session_user) && isset($smarty.session.session_user->profile_pic)}
                                                        <img  src="{$MEDIA_FILES_URL}uploads/images/profile/{$smarty.session.session_user->profile_pic}" class="img-responsive width_100 profile-big-image" />
                                                        {elseif isset($smarty.session.session_user) && isset($smarty.session.session_user->linkedin_picture_url) && strlen(trim($smarty.session.session_user->linkedin_picture_url)) > 0}
                                                        <img  src="{$smarty.session.session_user->linkedin_picture_url}" class="img-responsive width_100 profile-big-image" />
                                                        {else}
														<img  src="{$MEDIA_FILES_URL}images/user1.png" class="img-responsive width_100 profile-big-image" />
                                                        {/if}
													</div>
													<div class="col-xs-7 no-left-padding">
														<p class="profileName">{if isset($smarty.session.session_user)}{if isset($smarty.session.session_user->first_name)}{$smarty.session.session_user->first_name} {if isset($smarty.session.session_user->last_name)}{$smarty.session.session_user->last_name}{/if}{else}Anonymoous{/if} {/if}</p>
														<a href="{$APP_BASE_URL}user/profile" class="linkBlack viewProfile">View Profile</a>
														<br>
														<button class="btn btn-blue pull-right margin-top-30" ng-click="logout();">LOG OUT</button>
													</div>
												</div>
								            </div>
								        </form>
									</li>
								</ul>
							</span>
							<div class="hidden-xs xs-no-padding">
								<div class="loginbtn pull-right">                       
									<span class="logIN-signUp" before-log-in-display {if isset($smarty.session) && isset($smarty.session.session_user)} style="display: none;"{/if}>										 
										<a href="#" class="fa fa-chevron-down btn logInButton " id="login">&nbsp;&nbsp; LOG IN</a>
									</span>
								</div>
							</div>
							<ul class="nav navbar-nav pull-right">
								<li><a href="{$APP_BASE_URL}">HOME</a></li>
								<li><a href="{$APP_BASE_URL}articles/">ARTICLES</a></li>
								<li><a href="{$APP_BASE_URL}insights">INSIGHTS</a></li>
								<li><a href="{$APP_BASE_URL}events/">EVENTS</a></li>
								<li><a href="{$APP_BASE_URL}forums/">FORUMS</a></li>
								<li><a href="{$APP_BASE_URL}contact/">CONTACT US</a></li>
							</ul>
							<!--Mobile-->
							<div class="hidden-md hidden-lg hidden-sm">
                                {if isset($smarty.session) && isset($smarty.session.session_user) && isset($smarty.session.session_user->id)}
                                <div class="logOutMenu">
									<hr>
									<div class="clearfix"></div>
									<div class="searchBox col-xs-12 no-padding">
										<div class="col-xs-12 no-padding">
													<div class="col-xs-5 no-padding">
                                                        {if isset($smarty.session.session_user) && isset($smarty.session.session_user->profile_pic)}
                                                        <img  src="{$MEDIA_FILES_URL}uploads/images/profile/{$smarty.session.session_user->profile_pic}" class="img-responsive width_80 profile-big-image radius-10" />
                                                        {elseif isset($smarty.session.session_user) && isset($smarty.session.session_user->linkedin_picture_url) && strlen(trim($smarty.session.session_user->linkedin_picture_url)) > 0}
                                                        <img  src="{$smarty.session.session_user->linkedin_picture_url}" class="img-responsive width_80 profile-big-image radius-10" />
                                                        {else}
														<img  src="{$MEDIA_FILES_URL}images/user1.png" class="img-responsive width_80 profile-big-image radius-10" />
                                                        {/if}
													</div>
													<div class="col-xs-7 no-left-padding">
														<p class="profileName">{if isset($smarty.session.session_user)}{if isset($smarty.session.session_user->first_name)}{$smarty.session.session_user->first_name} {if isset($smarty.session.session_user->last_name)}{$smarty.session.session_user->last_name}{/if}{else}Anonymous{/if} {/if}</p>
														<a href="{$APP_BASE_URL}user/profile" class="linkBlack text-white viewProfile">View Profile</a>
														<br>
														<button class="btn btn-blue margin-top-30" ng-click="logout();">LOG OUT</button>
													</div>
												</div>
									</div>
						            <div class="clearfix"></div>
						            <hr>
								</div>
                                {else}
								<div class="logIN-signUp">
									<div class="clearfix"></div>
									<div class="loginbtn pull-right">      
										<i class="fa fa-chevron-down margin-left-10"></i>                  
										<span class="logIN-signUp" before-log-in-display {if isset($smarty.session) && isset($smarty.session.session_user)} style="display: none;"{/if}>
											<a href="#" class="btn logInButton" id="login">LOG IN</a>
										</span>
									</div>
									<div class="clearfix"></div>
								</div>
                                {/if}
								<div class="clearfix"></div>
							</div>
						</div><!-- /.navbar-collapse -->
					</div>
				</div><!-- /.container-fluid -->
			</nav>
		</div>
        <div class="clearfix"></div>
        
		{if isset($smarty.session) && isset($smarty.session.session_user) && $smarty.session.session_user->is_activated != 1}
		<div class="site-wide-alert no-padding">
			<div class="container ">
				<div class="col-xs-12 no-padding">
					<div class="font-family-light text-20 margin-vertical-10 text-center">
						<span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Please activate your account by visiting the link sent to your email or
						click <a href="{$APP_BASE_URL}account/resetactivationkey/{$smarty.session.session_user->activation_key}">here</a> to resend new activation link!
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		{/if}
        {block name="content"}{/block}
        
        <!-- Footer -->
		<div class="footer bg-light-blue margin-top-50">
			<img src="{$MEDIA_FILES_URL}images/scale1.png" class="img-responsive footer-scale" />
			<div class="container padding-top-30">
				<div class="col-xs-12 col-sm-4 col-md-4 no-padding">
					<img src="{$MEDIA_FILES_URL}images/logo_footer.png" class="img-responsive" />
					<address class="margin-top-50">
						<p>Bangalore Office: 69 “Prathiba Complex”, 4th ‘A’ Cross Koramangala Ind. Layout, Koramangala 5th Block, Bangalore-560 095. </p>
						<p>Phone: 080 4112 7925</p>
						<p>e-mail: <a href="mailto:R2i@zinnov.com" target="_top" class="text-white">media@zinnov.com.</a></p>
					</address>
				</div>
				<div class="hidden-xs col-sm-4 col-md-5 no-padding">
					<div class="col-xs-6 innerdetails no-padding pull-right">
						<h3 class="margin-bottom-25 text-brickblue margin-top-0">Company</h3>
						<p><i class="fa fa-chevron-right"></i><span> About</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Jobs</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Ethic Statement</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Terms</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Privacy</span></p>
						<p><i class="fa fa-chevron-right"></i><span> <a href="{$APP_BASE_URL}rss">Rss</a></span></p>
					</div>
				</div>
				<div class="hidden-xs col-sm-4 col-md-3 no-padding">
					<div class="col-xs-6 innerdetails no-padding pull-right">
						<h3 class="margin-bottom-25 text-brickblue margin-top-0">Community</h3>
						<p><i class="fa fa-chevron-right"></i><span> Blog</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Forum</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Guideline</span></p>
						<p><i class="fa fa-chevron-right"></i><span> Newsletter</span></p>
					</div>
				</div>
				<div class="visible-xs col-xs-12 no-padding panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
				    <div class="panel-heading background-brickblue" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCompany" aria-expanded="false" aria-controls="collapseOne" class="collapsed text-white width_100">
				          <div class="width_100 padding-10">Company</div>
				        </a>
				      </h4>
				    </div>
				    <div id="collapseCompany" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
				        <p class="text-black"><i class="fa fa-chevron-right"></i><span> About</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Jobs</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Ethic Statement</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Terms</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Privacy</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> <a href="{$APP_BASE_URL}rss">Rss</a></span></p>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading background-brickblue" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed text-white" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCommunity" aria-expanded="false" aria-controls="collapseTwo">
				          <div class="width_100 padding-10">Community</div>
				        </a>
				      </h4>
				    </div>
				    <div id="collapseCommunity" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <div class="panel-body">
				        <p class="text-black"><i class="fa fa-chevron-right"></i><span> Blog</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Forum</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Guideline</span></p>
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> Newsletter</span></p>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
			<div class="container-fluid bg-dark-blue padding-vertical-10">
				<div class="container no-padding text-white">
					<div class="display-table width_100 row margin-left-0">
						<div class="display-table-cell vertical-align-middle">
							<div class="col-xs-12">
									<div class="col-xs-6 no-padding">
										<p class="text-small font-family-light padding-top-10 no-margin">@ 2015 ZINNOV ALL RIGHTS RESERVED</p>
									</div>
									<div class="col-xs-6 no-padding">
										<div class="pull-right">
											<div class="socicalIcon footerShareIcon pull-right">
												<a href="https://www.facebook.com/pages/Zinnov/111718952202627?ref=hl">
					                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.png">
					                            </a>
					                            <a href="https://www.linkedin.com/company/zinnov">
					                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/social network106.png">
					                            </a>
					                            <a href="https://twitter.com/Zinnov">
					                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.png">
					                            </a>
					                            <a href="http://www.slideshare.net/zinnov">
					                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/slideshare2.png">
					                            </a>
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <script src="{$MEDIA_FILES_URL}js/bower_components/jquery/dist/?f=jquery.min"></script>
		<script src="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/js/?f=bootstrap.min"></script>
        <script src="{$MEDIA_FILES_URL}js/bower_components/angular/angular.min.js"></script>
		<script src="{$JS_FILES}?f=home"></script>
        <script src="{$JS_FILES}?f=main"></script>
        {block name="js"}{/block}
        {if $APP_BASE_URL == 'http://r2i.zinnov.com/'}
	        {block name="ga"}
	        {literal}
	        	<script type="text/javascript">
	        		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					  ga('create', 'UA-64814866-1', 'auto');
					  ga('send', 'pageview');
	        	</script>
	    	{/literal}
	        {/block}
		{/if}
		
		<script type="text/javascript">
			{if isset($smarty.session) && isset($smarty.session.session_user)}
				{if $smarty.session.session_user->is_activated && !isset($smarty.session.session_user->first_name)}
					$(document).ready(function(){
						$('.signupPopupContainer').show();
					})
				{/if}
			{/if}
		</script>

        {include file="account/login.tpl"}
        
    </body>
</html>
