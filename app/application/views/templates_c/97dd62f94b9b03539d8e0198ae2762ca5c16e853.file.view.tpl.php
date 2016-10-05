<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-16 12:41:37
         compiled from "application/views/templates/events/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17872308785620a22c7573e2-46138737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97dd62f94b9b03539d8e0198ae2762ca5c16e853' => 
    array (
      0 => 'application/views/templates/events/view.tpl',
      1 => 1444979489,
      2 => 'file',
    ),
    'cf2c00c58f4a9db1888caab6cae4f2839e47de69' => 
    array (
      0 => 'application/views/templates/layouts/layout.tpl',
      1 => 1441879242,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17872308785620a22c7573e2-46138737',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5620a22c935138_21766706',
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
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5620a22c935138_21766706')) {function content_5620a22c935138_21766706($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/R2I/app/system/libraries/smarty/libs/plugins/modifier.date_format.php';
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
css/event_view.css">

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
        
<?php $_smarty_tpl->tpl_vars['event'] = new Smarty_variable($_smarty_tpl->tpl_vars['response']->value['event'], null, 0);?>
<?php $_smarty_tpl->tpl_vars['default_timezone'] = new Smarty_variable(date_default_timezone_set($_smarty_tpl->tpl_vars['event']->value->timezone), null, 0);?>

	<?php if (empty($_smarty_tpl->tpl_vars['event']->value)) {?>
	
		<!-- Forum Headding -->
		<div class="viewAllArticle bg-light-gray" ng-model="type_id">
			<div class="container">
				<div class="col-xs-7 no-padding">
					<div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['response']->value['pageTitle'], 'UTF-8');?>
 </div>
				</div>
				<div class="col-xs-5 no-padding">
					<ol class="breadcrumb">
					  <li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
" class="text-dark-gray">Home</a></li>
					  <li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
events" class="text-dark-gray">Events</a></li>
					  <li class="active">View</li>
					</ol>
				</div>
			</div>
		</div>
		<br/>
		<h3 class="no-top-margin" style="text-align:center;">Event Not Found!</h3>
		
	<?php } else { ?>
		<?php $_smarty_tpl->tpl_vars['events_eb_detail'] = new Smarty_variable($_smarty_tpl->tpl_vars['event']->value->eb_details->event, null, 0);?>
		<!-- Forum Headding -->
		<div class="viewAllArticle bg-light-gray" ng-model="type_id">
			<div class="container">
				<div class="col-xs-7 no-padding">
					<div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['response']->value['pageTitle'], 'UTF-8');?>
 </div>
				</div>
				<div class="col-xs-5 no-padding">
					<ol class="breadcrumb">
					  <li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
" class="text-dark-gray">Home</a></li>
					  <li><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
events" class="text-dark-gray">Events</a></li>
					  <li class="active">View</li>
					</ol>
				</div>
			</div>
		</div>
		
		<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->status!='Draft') {?>
			<div class="container bg-white" ng-controller="eventController">
			
				<div class="col-xs-12 padding-vertical-50">	
					<div class="col-xs-12 col-sm-9 no-padding">
						<div class="col-xs-12 no-padding">
							<p class="text-45 font-family-bold text-metallic-blue"> <?php echo $_smarty_tpl->tpl_vars['event']->value->name;?>
</p>
							<p class="text-bold"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event']->value->start_date,'M d, Y ');?>
 @ <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event']->value->start_date,'h:i A ');?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event']->value->end_date,'M d, Y ');?>
 @ <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['event']->value->end_date,'h:i A ');?>
 (<?php echo date("T");?>
)</p>
							<img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/events?file_name=<?php echo $_smarty_tpl->tpl_vars['event']->value->id;?>
/<?php echo $_smarty_tpl->tpl_vars['event']->value->banner_image;?>
" class="img-responsive" <?php if ($_smarty_tpl->tpl_vars['event']->value->banner_image=='') {?>style="display:none;"<?php }?>>
							<div class="text-45">
								<p><?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->description;?>
</p>
							</div>
							<p class="text-brightorange text-30 margin-bottom-20">Venue</p>
								<h3 class="name text-metallic-blue"><?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->name;?>
</h3>
								<p class="company text-gray text-bold no-margin">
									<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->address) {?> <?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->address;?>
,<br/><?php }?>
									<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->address_2) {
echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->address_2;?>
,<br/><?php }?>
									<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->city) {
echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->city;?>
,<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->region) {
echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->region;?>
,<br/><?php }?>
									<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->country) {
echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->venue->country;
}?>
								</p><br/>
						</div>
						<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->status=='Live') {?>
							<div class="col-xs-12 no-padding margin-top-20">
							   <div style="width:100%; text-align:left;" ><iframe  src="//eventbrite.com/tickets-external?eid=<?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->id;?>
&ref=etckt" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe></div>
							</div>
						<?php }?>
						<?php $_smarty_tpl->tpl_vars['speakerCount'] = new Smarty_variable(0, null, 0);?>						
						<div class="col-xs-12 no-padding margin-bottom-20"  id="speakers">
							<br/><br/>
							<p class="text-brightorange text-30 margin-bottom-20">Speakers</p>
							<div class="col-xs-12 no-padding">
								<?php  $_smarty_tpl->tpl_vars['participants'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['participants']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['response']->value['event']->participants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['participants']->key => $_smarty_tpl->tpl_vars['participants']->value) {
$_smarty_tpl->tpl_vars['participants']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['participants']->key;
?>
								<?php if ($_smarty_tpl->tpl_vars['participants']->value->participant->type=='Speaker') {?>
									<?php $_smarty_tpl->tpl_vars['speakerCount'] = new Smarty_variable($_smarty_tpl->tpl_vars['speakerCount']->value+1, null, 0);?>
									<div class="col-xs-4 col-sm-3">
										<div class="participantImg">
											<img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/participants?file_name=<?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->id;?>
/<?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->thumbnail_image;?>
&w=270&h=270" class="img-responsive radius-100">
										</div>
										<div class="participantDesc center">
											<h3 class="name text-metallic-blue"><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['participants']->value->participant->first_name, 'UTF-8');?>
 <?php echo mb_strtoupper($_smarty_tpl->tpl_vars['participants']->value->participant->last_name, 'UTF-8');?>
</h3>
											<p class="company text-gray text-bold no-margin"><?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->company;?>
</p>
											<div class="profile"><?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->position;?>
</div>
										</div>
									</div>
									<?php if ($_smarty_tpl->tpl_vars['speakerCount']->value%3==0) {?>
										<div class="clearfix visible-xs"></div>
									<?php } elseif ($_smarty_tpl->tpl_vars['speakerCount']->value%2==1) {?>
										<div class="clearfix visible-sm"></div>
									<?php } elseif ($_smarty_tpl->tpl_vars['speakerCount']->value%2==2) {?>
										<div class="clearfix visible-md visible-lg"></div>
									<?php }?>
								<?php }?>
								<?php } ?>
							</div>
						</div>
						<?php $_smarty_tpl->tpl_vars['sponsorCount'] = new Smarty_variable(0, null, 0);?>
						<div class="col-xs-12 no-padding" id="sponsors"><br/>
							<p class="text-brightorange text-30 margin-bottom-10">Sponsors</p>
							<div class="col-xs-12 no-padding">
								<?php  $_smarty_tpl->tpl_vars['participants'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['participants']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['response']->value['event']->participants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['participants']->key => $_smarty_tpl->tpl_vars['participants']->value) {
$_smarty_tpl->tpl_vars['participants']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['participants']->key;
?>
								<?php if ($_smarty_tpl->tpl_vars['participants']->value->participant->type=='Sponsor') {?>
									<?php $_smarty_tpl->tpl_vars['sponsorCount'] = new Smarty_variable($_smarty_tpl->tpl_vars['sponsorCount']->value+1, null, 0);?>
									<div class="col-xs-4 col-sm-3">
										<div class="participantImg">
											<img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/participants?file_name=<?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->id;?>
/<?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->thumbnail_image;?>
&w=270&h=270" class="img-responsive radius-100">
										</div>
										<div class="participantDesc center">
											<h3 class="name text-metallic-blue"><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['participants']->value->participant->first_name, 'UTF-8');?>
 <?php echo mb_strtoupper($_smarty_tpl->tpl_vars['participants']->value->participant->last_name, 'UTF-8');?>
</h3>
											<p class="company text-gray text-bold no-margin"><?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->company;?>
</p>
											<div class="profile"><?php echo $_smarty_tpl->tpl_vars['participants']->value->participant->position;?>
</div>
										</div>
									</div>
									<?php if ($_smarty_tpl->tpl_vars['sponsorCount']->value%3==0) {?>
										<div class="clearfix visible-xs"></div>
									<?php } elseif ($_smarty_tpl->tpl_vars['sponsorCount']->value%2==1) {?>
										<div class="clearfix visible-sm"></div>
									<?php } elseif ($_smarty_tpl->tpl_vars['sponsorCount']->value%2==2) {?>
										<div class="clearfix visible-md visible-lg"></div>
									<?php }?>
								<?php }?>
								<?php } ?>
							</div>
						</div>
						<!-- <div class="col-xs-12 no-padding">
							<p class="text-brightorange center text-45 margin-bottom-10">Sponsors</p>
							<div class="col-xs-12 no-padding">
								<?php  $_smarty_tpl->tpl_vars['participant'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['participant']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['response']->value['participants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['participant']->key => $_smarty_tpl->tpl_vars['participant']->value) {
$_smarty_tpl->tpl_vars['participant']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['participant']->key;
?>
									<div class="col-xs-3">
										<div class="participantImg">
											<img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/participants?file_name=<?php echo $_smarty_tpl->tpl_vars['participant']->value->thumbnail_image;?>
" class="img-responsive">
										</div>
										<div class="participantDesc">
											<div class="name"><?php echo $_smarty_tpl->tpl_vars['participant']->value->first_name;?>
</div>
											<div class="company"><?php echo $_smarty_tpl->tpl_vars['participant']->value->company;?>
</div>
											<div class="profile"><?php echo $_smarty_tpl->tpl_vars['participant']->value->position;?>
</div>
										</div>
									</div>
									<?php if ($_smarty_tpl->tpl_vars['key']->value%3==0) {?>
										<div class="clearfix visible-xs"></div>
									<?php } elseif ($_smarty_tpl->tpl_vars['key']->value%3==1) {?>
										<div class="clearfix visible-sm"></div>
									<?php } elseif ($_smarty_tpl->tpl_vars['key']->value%3==2) {?>
										<div class="clearfix visible-md visible-lg"></div>
									<?php }?>
								<?php } ?>
							</div>
						</div> -->
					</div>
					
					<div class="col-xs-9 col-sm-3 no-padding">
						<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->status=='Live') {?>
							<div class="width_100 center margin-top-20" >
								<iframe  src="https://www.eventbrite.com/countdown-widget?eid=<?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->id;?>
" frameborder="0" width="195" height="400" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true" class="pull-right widgetIframe"></iframe>
							</div>
						<?php }?>
						<div class="col-xs-12 no-padding">
							<div class="pull-right bg-light-gray radius-5 organisedBy">
								<div class="border-1-gray margin-5 radius-1">
									<p class="text-medium no-margin text-bold no-margin padding-5 bg-white"> ORGANISED BY : </p>
									<p class="text-large text-blue no-margin padding-5 bg-white"> <?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->organizer->name;?>
</p>
									<p class="text-normal  no-margin padding-5 bg-white"><?php echo $_smarty_tpl->tpl_vars['events_eb_detail']->value->organizer->description;?>
</p>
								</div>
							</div>
						</div>
					</div>	
					<?php if ($_smarty_tpl->tpl_vars['events_eb_detail']->value->status=='Live') {?>
						<div class="col-xs-12 no-padding center margin-top-per-6">
							<a class="btn btn-box-orange registerEventButton" href="https://www.eventbrite.com/e/testing-tickets-<?php echo $_smarty_tpl->tpl_vars['event']->value->eb_event_id;?>
?ref=ecount" target="_new" role="button">Register Now</a>
						</div>
					<?php }?>
				</div>
			</div>
		 <?php } else { ?>
			 <br/>
			<h3 class="no-top-margin" style="text-align:center;">Event Not Yet Published!</h3>
		<?php }?>
	<?php }?>

        
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
 type="text/javascript">
		speakerCount = <?php echo $_smarty_tpl->tpl_vars['speakerCount']->value;?>
;
		if(speakerCount == 0){
			$('#speakers').hide();
		}
		sponsorCount = <?php echo $_smarty_tpl->tpl_vars['sponsorCount']->value;?>
;
		if(sponsorCount == 0){
			$('#sponsors').hide();
		}
	<?php echo '</script'; ?>
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
