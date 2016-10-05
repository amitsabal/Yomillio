<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-09-23 16:20:15
         compiled from "application/views/templates/user/profile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:86311295857e508e7a3ec23-79049454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac9447f2961d97eb367c15a043e63facd16a7ecc' => 
    array (
      0 => 'application/views/templates/user/profile.tpl',
      1 => 1441782451,
      2 => 'file',
    ),
    '069bd8554e1abb237af788c4cd60bf31b39aba31' => 
    array (
      0 => 'application/views/templates/layouts/layout.tpl',
      1 => 1441879242,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '86311295857e508e7a3ec23-79049454',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'name' => 0,
    'MEDIA_FILES_URL' => 0,
    'APP_BASE_URL' => 0,
    'successMessage' => 0,
    'errorMessage' => 0,
    'response' => 0,
    'JS_FILES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57e508e7ca3383_42764284',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57e508e7ca3383_42764284')) {function content_57e508e7ca3383_42764284($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/YomillioApp/app/system/libraries/smarty/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/html/YomillioApp/app/system/libraries/smarty/libs/plugins/modifier.truncate.php';
?><!DOCTYPE html>
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
	
	
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</title>

	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/bootstrap/dist/css/?f=bootstrap.min">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/bootstrap/dist/css/?f=bootstrap-theme.min">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/font-awesome/css/?f=font-awesome.min">

	<!-- Page CSS -->
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
css/?f=checkbox,font,utilities,media,extensions,base">

	
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
css/profile.css">


    <?php echo '<script'; ?>
 type="text/javascript">
        var $APP_BASE_URL = "<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
";
        var $MEDIA_FILES_URL = "<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
";
        
        //localStorage.clear();
        <?php if (isset($_SESSION)&&isset($_SESSION['session_user'])) {?>
            localStorage.setItem('user', <?php if (isset($_SESSION['session_user']->id)) {?>'<?php echo $_SESSION['session_user']->id;?>
'<?php } else { ?>''<?php }?>);
            localStorage.setItem('expires-at', <?php if (isset($_SESSION['session_user']->expires_at)) {?>'<?php echo $_SESSION['session_user']->expires_at;?>
'<?php } else { ?>''<?php }?>);
            localStorage.setItem('auth-token', <?php if (isset($_SESSION['session_token'])) {?>'<?php echo $_SESSION['session_token'];?>
'<?php } else { ?>''<?php }?>);
        <?php } else { ?>
            localStorage.removeItem('user');
            localStorage.removeItem('auth-token');
            localStorage.removeItem('expires-at');
            //localStorage.clear();
        <?php }?>     
    <?php echo '</script'; ?>
>

    <?php if ($_smarty_tpl->tpl_vars['APP_BASE_URL']->value=='http://r2i.zinnov.com/') {?>
	
	<?php }?>
	
</head>
	<body data-ng-cloak data-ng-controller="AppCtrl">
        
        <!-- Alerts & Messages -->
        <?php if ((isset($_smarty_tpl->tpl_vars['successMessage']->value)&&strlen(trim($_smarty_tpl->tpl_vars['successMessage']->value))>0)||(isset($_smarty_tpl->tpl_vars['errorMessage']->value)&&strlen(trim($_smarty_tpl->tpl_vars['errorMessage']->value))>0)) {?>
        <div class="alerts">
            <?php if (isset($_smarty_tpl->tpl_vars['successMessage']->value)&&strlen(trim($_smarty_tpl->tpl_vars['successMessage']->value))>0) {?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> <?php echo $_smarty_tpl->tpl_vars['successMessage']->value;?>

            </div>
            <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['errorMessage']->value)&&strlen(trim($_smarty_tpl->tpl_vars['errorMessage']->value))>0) {?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> <?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>

            </div>
            <?php }?>
        </div>
        <?php }?>
			<nav class="navbar-default headerColor">
				<img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/scale.png" class="img-reponsive bottom-left width_100" />
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
							<a class="navbar-brand height-auto no-padding" href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/logo.png" class="img-responsive"></a>
						</div>

						<!-- Search box login -->
						<div class="col-xs-12 col-sm-6 col-md-2 col-lg-3 pull-right padding-top-5 no-padding searchBox hidden-md hidden-lg hidden-sm">
							<div class="input-group padding-vertical-5 width_100">
								<form  name="searchForm" method="post">
                                    <div class="input-group">
                                        <input type="text" class="form-control searchControl" placeholder="Search" id="searchControl" value="<?php if (isset($_smarty_tpl->tpl_vars['response']->value['keyword'])) {
echo mb_strtoupper($_smarty_tpl->tpl_vars['response']->value['keyword'], 'UTF-8');
}?>"/>
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
                                style="display:<?php if (isset($_SESSION)&&isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->id)) {?>block;<?php } else { ?>none;<?php }?>" >
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">									
                                    <?php if (isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->profile_pic)) {?>
                                    <img  src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
uploads/images/profile/<?php echo $_SESSION['session_user']->profile_pic;?>
" width="38" height="38" class="img-circle profile-pic" />
                                    <?php } elseif (isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->linkedin_picture_url)&&strlen(trim($_SESSION['session_user']->linkedin_picture_url))>0) {?>
                                    <img  src="<?php echo $_SESSION['session_user']->linkedin_picture_url;?>
" class="img-circle profile-pic" width="38" height="38" />
                                    <?php } else { ?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/user.png" class="img-circle profile-pic" width="38" height="38">
                                    <?php }?>
								</a>
								<ul class="dropdown-menu loginProfileDropdown" role="menu">
									<li>
										<form>
											<div class="searchBox width-300">
												<div class="col-xs-12">
													<div class="col-xs-5">
                                                        <?php if (isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->profile_pic)) {?>
                                                        <img  src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
uploads/images/profile/<?php echo $_SESSION['session_user']->profile_pic;?>
" class="img-responsive width_100 profile-big-image" />
                                                        <?php } elseif (isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->linkedin_picture_url)&&strlen(trim($_SESSION['session_user']->linkedin_picture_url))>0) {?>
                                                        <img  src="<?php echo $_SESSION['session_user']->linkedin_picture_url;?>
" class="img-responsive width_100 profile-big-image" />
                                                        <?php } else { ?>
														<img  src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/user1.png" class="img-responsive width_100 profile-big-image" />
                                                        <?php }?>
													</div>
													<div class="col-xs-7 no-left-padding">
														<p class="profileName"><?php if (isset($_SESSION['session_user'])) {
if (isset($_SESSION['session_user']->first_name)) {
echo $_SESSION['session_user']->first_name;?>
 <?php if (isset($_SESSION['session_user']->last_name)) {
echo $_SESSION['session_user']->last_name;
}
} else { ?>Anonymoous<?php }?> <?php }?></p>
														<a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
user/profile" class="linkBlack viewProfile">View Profile</a>
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
									<span class="logIN-signUp" before-log-in-display <?php if (isset($_SESSION)&&isset($_SESSION['session_user'])) {?> style="display: none;"<?php }?>>										 
										<a href="#" class="fa fa-chevron-down btn logInButton " id="login">&nbsp;&nbsp; LOG IN</a>
									</span>
								</div>
							</div>
							<ul class="nav navbar-nav pull-right">
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
">HOME</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
articles/">ARTICLES</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insights">INSIGHTS</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
events/">EVENTS</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
forums/">FORUMS</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
contact/">CONTACT US</a></li>
							</ul>
							<!--Mobile-->
							<div class="hidden-md hidden-lg hidden-sm">
                                <?php if (isset($_SESSION)&&isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->id)) {?>
                                <div class="logOutMenu">
									<hr>
									<div class="clearfix"></div>
									<div class="searchBox col-xs-12 no-padding">
										<div class="col-xs-12 no-padding">
													<div class="col-xs-5 no-padding">
                                                        <?php if (isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->profile_pic)) {?>
                                                        <img  src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
uploads/images/profile/<?php echo $_SESSION['session_user']->profile_pic;?>
" class="img-responsive width_80 profile-big-image radius-10" />
                                                        <?php } elseif (isset($_SESSION['session_user'])&&isset($_SESSION['session_user']->linkedin_picture_url)&&strlen(trim($_SESSION['session_user']->linkedin_picture_url))>0) {?>
                                                        <img  src="<?php echo $_SESSION['session_user']->linkedin_picture_url;?>
" class="img-responsive width_80 profile-big-image radius-10" />
                                                        <?php } else { ?>
														<img  src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/user1.png" class="img-responsive width_80 profile-big-image radius-10" />
                                                        <?php }?>
													</div>
													<div class="col-xs-7 no-left-padding">
														<p class="profileName"><?php if (isset($_SESSION['session_user'])) {
if (isset($_SESSION['session_user']->first_name)) {
echo $_SESSION['session_user']->first_name;?>
 <?php if (isset($_SESSION['session_user']->last_name)) {
echo $_SESSION['session_user']->last_name;
}
} else { ?>Anonymous<?php }?> <?php }?></p>
														<a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
user/profile" class="linkBlack text-white viewProfile">View Profile</a>
														<br>
														<button class="btn btn-blue margin-top-30" ng-click="logout();">LOG OUT</button>
													</div>
												</div>
									</div>
						            <div class="clearfix"></div>
						            <hr>
								</div>
                                <?php } else { ?>
								<div class="logIN-signUp">
									<div class="clearfix"></div>
									<div class="loginbtn pull-right">      
										<i class="fa fa-chevron-down margin-left-10"></i>                  
										<span class="logIN-signUp" before-log-in-display <?php if (isset($_SESSION)&&isset($_SESSION['session_user'])) {?> style="display: none;"<?php }?>>
											<a href="#" class="btn logInButton" id="login">LOG IN</a>
										</span>
									</div>
									<div class="clearfix"></div>
								</div>
                                <?php }?>
								<div class="clearfix"></div>
							</div>
						</div><!-- /.navbar-collapse -->
					</div>
				</div><!-- /.container-fluid -->
			</nav>
		</div>
        <div class="clearfix"></div>
        
		<?php if (isset($_SESSION)&&isset($_SESSION['session_user'])&&$_SESSION['session_user']->is_activated!=1) {?>
		<div class="site-wide-alert no-padding">
			<div class="container ">
				<div class="col-xs-12 no-padding">
					<div class="font-family-light text-20 margin-vertical-10 text-center">
						<span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Please activate your account by visiting the link sent to your email or
						click <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
account/resetactivationkey/<?php echo $_SESSION['session_user']->activation_key;?>
">here</a> to resend new activation link!
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php }?>
        
<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>My Profile</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
" class="text-dark-gray">Home</a></li>
              <li class="active">My Profile</li>
            </ol>
        </div>
    </div>
</div>

<div class="container bg-white" ng-model="user">
    <div class="col-xs-12 col-md-12 no-padding margin-top-30">
        <div class="col-xs-12 no-padding">
            <div class="col-xs-12 col-sm-4 no-left-padding">
                <?php if (isset($_smarty_tpl->tpl_vars['response']->value['profile']->user->profile_pic)) {?>
                <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
uploads/images/profile/<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->profile_pic;?>
" class="img-responsive pull-left">
                <?php } elseif (isset($_smarty_tpl->tpl_vars['response']->value['profile']->user->linkedin_picture_url)&&strlen(trim($_smarty_tpl->tpl_vars['response']->value['profile']->user->linkedin_picture_url))>0) {?>
                <img src="<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->linkedin_picture_url;?>
" class="img-responsive pull-left">
                <?php } else { ?>
                <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/profile.png" class="img-responsive pull-left">
                <?php }?>
                <div class="text-blue pull-left profileUserName padding-left-10 col-xs-8"><?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->last_name;?>
</div>
                <div class="col-xs-4 pull-right">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
account/logout"><button class="btn btn-blue margin-top-20 profile-logout ">LOG OUT</button></a>
                </div>
                <div class="col-xs-12 no-left-padding margin-top-20">
                    <fieldset>
                        <legend>Profile</legend>
                        <ul class="profile-list list-group">
                            <li class="list-group-item"><a href="#update-profile"><i class="fa fa-user"></i>  My Profile</a></li>
                            <?php if (($_smarty_tpl->tpl_vars['response']->value['profile']->user->login_type!="linkedin")) {?>
                            <li class="list-group-item"><a href="#account-settings"><i class="fa fa-cogs"></i>  Account Settings</a></li>
                            <?php }?>
                            <li class="list-group-item"><a href="#articles"><i class="fa fa-cogs"></i>  Articles</a></li>
                            <li class="list-group-item"><a href="#forums"><i class="fa fa-cogs"></i>  Forums</a></li>
                            <li class="list-group-item"><a href="#recent-activity"><i class="fa fa-paw"></i>  Recent Comments</a></li>
                            <li class="list-group-item">
                                <i class="fa fa-exclamation-triangle"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
account/resetactivationkey/<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->activation_key;?>
">Resend Activation Key</a>
                            </li>
                        </ul>
                    </fieldset>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 no-right-padding">
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="update-profile">
                                        
                    <div class="col-xs-12 no-padding padding-10" >
                        <h3 class="no-margin">Update Profile</h3>
                        <div class="col-xs-12" id="profileListView">
                            <div class="col-xs-12 col-sm-4 no-padding">
                                <div class="profileupload  margin-top-20">   
                                    <?php if (isset($_smarty_tpl->tpl_vars['response']->value['profile']->user->profile_pic)) {?> 
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
uploads/images/profile/<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->profile_pic;?>
" class="img-responsive pull-left" alt="profile" id="profile_pic" style="height: 140px;">
                                    <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/profile.png" class="img-responsive" alt="profile" id="profile_pic" style="height: 140px;" />
                                    <?php }?>                               
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">                                
                                <span class="input-icon margin-top-20">
                                    <label>Name :</label> <?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->last_name;?>

                                </span>
                                <span class="input-icon margin-top-20">
                                    <label>Job Title :</label> <?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->linkedin_job_title;?>

                                </span>
                                <span class="input-icon margin-top-20">
                                    <label>Biodata :</label> <?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->bio;?>

                                 </span>
                            </div>
                            <div class="clearfix"></div>
                                    <input type="button" value="EDIT" id="edit_profile" class="col-xs-4 col-sm-3 col-md-2 btn btn-blue margin-right-5 pull-right">
                        </div>
                        <form name="profileUpdate" action="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
user/updateprofile" method="post" enctype="multipart/form-data" id="profileUpdate" class="no-display" onsubmit="return ValidateProfile();">
                            <input type="hidden" name="curUrl" value="" />
                            <div class="col-xs-12 col-sm-4 no-padding">
                                <div class="profileupload  margin-top-20">
                                    <?php if (isset($_smarty_tpl->tpl_vars['response']->value['profile']->user->profile_pic)) {?> 
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
uploads/images/profile/<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->profile_pic;?>
" class="img-responsive pull-left" alt="profile" id="profile_pic" style="height: 140px;">
                                    <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/profile.png" class="img-responsive" alt="profile" id="profile_pic" style="height: 140px;" />
                                    <?php }?> 
                                    <div class="col-xs-12 uploadimg padding-5"><input type="file" name="profile_pic" id="profilePicUpload" data-file-type="png,jpg,jpeg" /><img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/upload.png" /><span> UPLOAD</span></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <span class="input-icon margin-top-20">
                                    <input type="text" class="form-control" id="firstname" name="first_name" placeholder="First Name" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->first_name;?>
" />
                                </span>
                                <span class="input-icon margin-top-20">
                                    <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Last Name" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->last_name;?>
"/>
                                </span>	
                                <div class="clearfix"></div>
                                <span class="input-icon margin-top-20">
                                    <input type="text" class="form-control" id="jobtitle" name="linkedin_job_title" placeholder="Job Title" maxlength="256" value="<?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->linkedin_job_title;?>
" />
                                </span>	
                                <div class="clearfix"></div>
                                <span class="input-icon margin-top-20">
                                    <textarea type="text" class="form-control" id="biodata" name="bio" placeholder="Biodata" rows="4" ><?php echo $_smarty_tpl->tpl_vars['response']->value['profile']->user->bio;?>
</textarea>
                                </span>
                                
                                <div class="col-xs-12 padding-vertical-10 padding-right-20">
                                    <button type="submit" class="col-xs-4 col-sm-3 btn btn-blue pull-right"> SAVE </button>
                                    <input type="button" value="CANCEL" id="cancel_profile" class="col-xs-4 col-sm-3 col-md-3 btn btn-blue margin-right-5 pull-right">
                                </div>	
                            </div>	
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="account-settings">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Change Password</h3>
                        <form name="changePassword" id="changepassword-form" action="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
user/changepassword" method="post" onsubmit="return ChangePassword();">
                            <div class="form-group col-xs-12 floating-label-form-group">
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <input class="form-control" type="password" id="oldPassword" name="oldPassword" placeholder="Old Password" ng-model="user.oldPassword" />
                                </div>
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <input class="form-control" type="password" id="password" name="password" placeholder="New Password" ng-model="user.password" />
                                </div>                              
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" ng-model="user.confirmPassword" />
                                </div>    
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <label>&nbsp;</label>
                                    <div>                                
                                        <button type="submit" class="btn btn-md btn-blue pull-right">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php $_smarty_tpl->tpl_vars['articles'] = new Smarty_variable($_smarty_tpl->tpl_vars['response']->value['profile']->user->articles, null, 0);?>
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="articles">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Submitted Articles</h3>
                        <div class="activityContentDiv padding-top-10 col-xs-12 no-padding">
                            <?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['articles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['popular']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['article']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['popular']['index']++;
?>
                            
                            <div class="col-xs-12 col-sm-6 col-md-4 singleArticle" single-article-hover>
                                <div class="clearfix"></div>
                                <div class="col-md-12 no-padding articleImg">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
">
                                        <?php if ($_smarty_tpl->tpl_vars['article']->value->published_by=='') {?>      
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/article?file_name=<?php echo $_smarty_tpl->tpl_vars['article']->value->id;?>
/<?php echo $_smarty_tpl->tpl_vars['article']->value->submitted_image;?>
" class="img-responsive width_100">                                         
                                        <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/article?file_name=<?php echo $_smarty_tpl->tpl_vars['article']->value->id;?>
/<?php echo $_smarty_tpl->tpl_vars['article']->value->thumbnail_image;?>
" class="img-responsive width_100">     
                                        <?php }?>
                                    </a>
                                    <h4 class="text-bold left">
                                       <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="text-dark-gray"><?php echo $_smarty_tpl->tpl_vars['article']->value->title;?>
</a></h4>
                                    
                                    <div class="text-medium text-gray margin-bottom-10">- <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['article']->value->created_at,'d M Y');?>
, Time <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['article']->value->created_at,'h:i A');?>
</div>
                                </div>
                                 <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['popular']['index']%2==0) {?>
                                    <div class="clearfix visible-xs"></div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['popular']['index']%2==1) {?>
                                    <div class="clearfix visible-sm"></div>
                                    <?php }?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php $_smarty_tpl->tpl_vars['comments'] = new Smarty_variable($_smarty_tpl->tpl_vars['response']->value['profile']->user->comments, null, 0);?>
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="recent-activity">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Recent Comments</h3>
                        <div class="activityContentDiv padding-top-10 col-xs-12 no-padding">
                            <?php $_smarty_tpl->tpl_vars['curArticleId'] = new Smarty_variable(0, null, 0);?>
                            <?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['comment']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['popular']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['comment']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['popular']['index']++;
?>

                            
                            <?php if ($_smarty_tpl->tpl_vars['curArticleId']->value!=$_smarty_tpl->tpl_vars['comment']->value->article_id) {?>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 singleArticle" single-article-hover>
                                <div class="clearfix"></div>
                                <div class="col-md-4 no-padding articleImg">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['comment']->value->article->perma_link, 'UTF-8');?>
">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/article?file_name=<?php echo $_smarty_tpl->tpl_vars['comment']->value->article->id;?>
/<?php echo $_smarty_tpl->tpl_vars['comment']->value->article->thumbnail_image;?>
" class="img-responsive width_100">
                                    </a>
                                    
                                </div>
                                
                                <div class="col-md-8 articleContent homePageArticle no-padding padding-left-20">
                                    <h4 class="text-bold left">
                                       <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['comment']->value->article->perma_link, 'UTF-8');?>
" class="text-dark-gray"><?php echo $_smarty_tpl->tpl_vars['comment']->value->article->title;?>
</a></h4>
                                    <ul>
                            <?php }?>
                                    <li>
                                        <div><?php echo $_smarty_tpl->tpl_vars['comment']->value->comment;?>
</div>
                                        <div class="text-medium text-gray margin-bottom-10">- <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['comment']->value->created_at,'d M Y');?>
, Time <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['comment']->value->created_at,'h:i A');?>
</div>
                                    </li>
                            <?php $_smarty_tpl->tpl_vars['curArticleId'] = new Smarty_variable($_smarty_tpl->tpl_vars['comment']->value->article_id, null, 0);?>
                            
                             <?php if (!isset($_smarty_tpl->tpl_vars['comments']->value[$_smarty_tpl->tpl_vars['k']->value+1])||$_smarty_tpl->tpl_vars['curArticleId']->value!=$_smarty_tpl->tpl_vars['comments']->value[$_smarty_tpl->tpl_vars['k']->value+1]->article_id) {?>       
                                </div>
                                <div class="clearfix"></div>
                                <hr/>
                            </div>
                            <?php }?>
                            
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php $_smarty_tpl->tpl_vars['forums'] = new Smarty_variable($_smarty_tpl->tpl_vars['response']->value['profile']->user->forums, null, 0);?>
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="forums">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Submitted Forums</h3>
                        <div class="activityContentDiv padding-top-10 col-xs-12 no-padding">
                            
                            <?php  $_smarty_tpl->tpl_vars['forum'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['forum']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['forums']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['popular']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['forum']->key => $_smarty_tpl->tpl_vars['forum']->value) {
$_smarty_tpl->tpl_vars['forum']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['forum']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['popular']['index']++;
?>
                                <div class="col-xs-12 no-padding padding-bottom-10">
                                    <div class="row no-margin forumList border-bottom-light-grey border-right-light-grey border-width-1 bg-glass-grey">
                                        
                                        <div class="col-xs-6 col-sm-9 border-horizontal-light-grey border-width-1 padding-20">
                                            <h4 class="no-top-margin"><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
forum/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['forum']->value->perma_link, 'UTF-8');?>
" class="text-sky-blue"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['forum']->value->title,45);?>
</a></h4>
                                            Posted in <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
forums/category/<?php echo urlencode(mb_strtolower($_smarty_tpl->tpl_vars['forum']->value->category->title, 'UTF-8'));?>
" class="text-gray"><?php echo $_smarty_tpl->tpl_vars['forum']->value->category->title;?>
</a>, <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['forum']->value->created_at,'M d, Y');?>
 at <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['forum']->value->created_at,'h:i A');?>
 </span> </p>
                                            
                                        </div>
                                        <div class="col-xs-3 col-sm-2 border-width-1 padding-20">
                                            <div class="col-xs-7 no-padding">
                                                <div class="comments text-gray margin-bottom-10"><?php echo $_smarty_tpl->tpl_vars['forum']->value->view_count;?>
</div>
                                            </div>
                                            <div class="col-xs-2 no-padding"> <i class="fa fa-eye"></i></div>
                                            <div class="clearfix"></div>
                                            <div class="col-xs-7 no-padding"><div class="replies text-gray"><?php echo count($_smarty_tpl->tpl_vars['forum']->value->answers);?>
</div></div>
                                            <div class="col-xs-2 no-padding"> <i class="fa fa-reply"></i></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            <?php }
if (!$_smarty_tpl->tpl_vars['forum']->_loop) {
?>
                                <h3 class="no-top-margin">No Forums Found!</h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        
        <!-- Footer -->
		<div class="footer bg-light-blue margin-top-50">
			<img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/scale1.png" class="img-responsive footer-scale" />
			<div class="container padding-top-30">
				<div class="col-xs-12 col-sm-4 col-md-4 no-padding">
					<img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/logo_footer.png" class="img-responsive" />
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
						<p><i class="fa fa-chevron-right"></i><span> <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
rss">Rss</a></span></p>
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
						<p class="text-black"><i class="fa fa-chevron-right"></i><span> <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
rss">Rss</a></span></p>
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
					                                <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/facebook.png">
					                            </a>
					                            <a href="https://www.linkedin.com/company/zinnov">
					                                <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/social network106.png">
					                            </a>
					                            <a href="https://twitter.com/Zinnov">
					                                <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/twitter.png">
					                            </a>
					                            <a href="http://www.slideshare.net/zinnov">
					                                <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/slideshare2.png">
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
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/jquery/dist/?f=jquery.min"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/bootstrap/dist/js/?f=bootstrap.min"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/angular/angular.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['JS_FILES']->value;?>
?f=home"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['JS_FILES']->value;?>
?f=main"><?php echo '</script'; ?>
>
        
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/user.js"><?php echo '</script'; ?>
>

        <?php if ($_smarty_tpl->tpl_vars['APP_BASE_URL']->value=='http://r2i.zinnov.com/') {?>
	        
	        
	        	<?php echo '<script'; ?>
 type="text/javascript">
	        		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					  ga('create', 'UA-64814866-1', 'auto');
					  ga('send', 'pageview');
	        	<?php echo '</script'; ?>
>
	    	
	        
		<?php }?>
		
		<?php echo '<script'; ?>
 type="text/javascript">
			<?php if (isset($_SESSION)&&isset($_SESSION['session_user'])) {?>
				<?php if ($_SESSION['session_user']->is_activated&&!isset($_SESSION['session_user']->first_name)) {?>
					$(document).ready(function(){
						$('.signupPopupContainer').show();
					})
				<?php }?>
			<?php }?>
		<?php echo '</script'; ?>
>

        <?php echo $_smarty_tpl->getSubTemplate ("account/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        
    </body>
</html>
<?php }} ?>
