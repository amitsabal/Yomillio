<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-09-23 15:25:21
         compiled from "application/views/templates/articles/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:115885286257e4fc099206d2-48783850%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28a33f71c38e989a1f34ce17b925d109cf434afd' => 
    array (
      0 => 'application/views/templates/articles/list.tpl',
      1 => 1440060751,
      2 => 'file',
    ),
    '069bd8554e1abb237af788c4cd60bf31b39aba31' => 
    array (
      0 => 'application/views/templates/layouts/layout.tpl',
      1 => 1441879242,
      2 => 'file',
    ),
    'c0065c94df512e37a30fc3725b4cfaee91c7fd78' => 
    array (
      0 => 'application/views/templates/popups/newarticle.popup.tpl',
      1 => 1438333456,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115885286257e4fc099206d2-48783850',
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
  'unifunc' => 'content_57e4fc09dbc316_22107726',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57e4fc09dbc316_22107726')) {function content_57e4fc09dbc316_22107726($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/YomillioApp/app/system/libraries/smarty/libs/plugins/modifier.date_format.php';
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
css/viewAll.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
css/jquery.tagit.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
css/tagit.ui-zendesk.css">

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
        

<?php $_smarty_tpl->tpl_vars['pag_url'] = new Smarty_variable(strstr(uri_string(),'page/',true), null, 0);?>
<?php if (strlen(trim($_smarty_tpl->tpl_vars['pag_url']->value))<=0) {
$_smarty_tpl->tpl_vars['pag_url'] = new Smarty_variable((uri_string()).("/"), null, 0);
}?>

<!-- Search Result Headding -->
<?php /*  Call merged included template "popups/newarticle.popup.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('popups/newarticle.popup.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '115885286257e4fc099206d2-48783850');
content_57e4fc09bbced4_02419294($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "popups/newarticle.popup.tpl" */?>    

<input type="hidden" id="currentShowType"  name="currentShowType" value="<?php if (isset($_smarty_tpl->tpl_vars['response']->value['currentShowType'])) {
echo $_smarty_tpl->tpl_vars['response']->value['currentShowType'];
}?>" />
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
              <li class="active">Articles</li>
            </ol>
        </div>
    </div>
</div>

<!-- Filter of search result -->

<div class="container bg-white">
    <div class="selectCategory">
        <div class="col-xs-12 padding-vertical-50">
            <div class="col-xs-12 col-sm-7 no-padding pull-right">
                <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/create"><button class="btn btn-box-orange newArticle pull-right">NEW ARTICLE</button></a>
                <div class="filterArticles col-xs-4 col-sm-8  col-md-9 no-padding">
                    <button type="button" class="btn btn-box-blue dropdown-toggle filterArticlesbutton pull-right" data-toggle="dropdown">
                    <span data-bind="label" class="selectedCategory"><?php if (!isset($_smarty_tpl->tpl_vars['response']->value['selectedCategory'])||$_smarty_tpl->tpl_vars['response']->value['selectedCategory']=='') {?>ALL<?php } else {
echo mb_strtoupper($_smarty_tpl->tpl_vars['response']->value['selectedCategory'], 'UTF-8');
}?></span>&nbsp;<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <!-- <li><span class="text-white text-bold">FILTER</span></li> -->
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
search/" class="<?php if (!isset($_smarty_tpl->tpl_vars['response']->value['selectedCategory'])||$_smarty_tpl->tpl_vars['response']->value['selectedCategory']=='') {?>active<?php } else {
}?>">ALL</a>
                        </li>
                        
                        <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['response']->value['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                            <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
search/category/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['category']->value->title, 'UTF-8');?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['response']->value['selectedCategory'])&&mb_strtolower($_smarty_tpl->tpl_vars['response']->value['selectedCategory'], 'UTF-8')==mb_strtolower($_smarty_tpl->tpl_vars['category']->value->title, 'UTF-8')) {?>active<?php }?>"><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['category']->value->title, 'UTF-8');?>
</a>
                            </li>
                        <?php } ?>
                        
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-5 no-padding">
                
                <button class="btn btn-box-grey col-xs-4 latestButton" ng-class="{'active':showLatest}" ng-click="showLatestArticles();">LATEST</button>
                <button class="btn btn-box-grey col-xs-4 margin-left-10 popularButton" ng-class="{'active':showPopular}"  ng-click="showPopularArticles();">POPULAR</button>
                
            </div>
        </div>       
    </div>
    <div class="col-xs-12 article no-padding" ng-show="showLatest">
        <div id="loadingLatest" class="text-center loading"></div>
        
        <?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['response']->value['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['article']->key;
?>
            <div class="clearfix"></div>
            <div ng-cloak>
                <div class="col-xs-12 singleArticle no-padding margin-bottom-10">
                    <div class="col-xs-12 col-sm-6 articleImg no-padding margin-bottom-5">
                        <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
">
                        <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" video-play-hover>
                        <?php }?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/article?file_name=<?php echo $_smarty_tpl->tpl_vars['article']->value->id;?>
/<?php echo $_smarty_tpl->tpl_vars['article']->value->thumbnail_big_image;?>
&w=570&h=270" class="img-responsive width_90 radius-3 border-bottom-light-grey">
                            <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                                <div class="videoImgContent">
                                    <div class="videoImgPlayButton">
                                        <span class="videoPlayImg">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/play.png" class="play width_30" alt="">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/play1.png" class="playHover width_30" alt="">
                                        </span>
                                    </div>
                                </div>
                            <?php }?>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 articleContent no-padding">
                        <h3 class="text-bold text-gray no-top-margin">
                        <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="linkBlack">
                        <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="linkBlack">
                        <?php }?>
                            <?php echo $_smarty_tpl->tpl_vars['article']->value->title;?>
</a></h3>
                        <p class="text-blue">By
                        <span class="authorName">
                            <?php if (isset($_smarty_tpl->tpl_vars['article']->value->author)&&$_smarty_tpl->tpl_vars['article']->value->author!=''&&$_smarty_tpl->tpl_vars['article']->value->author!=null) {?>
                                <?php echo $_smarty_tpl->tpl_vars['article']->value->author->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['article']->value->author->last_name;?>

                            <?php } elseif (isset($_smarty_tpl->tpl_vars['article']->value->admin_author)&&$_smarty_tpl->tpl_vars['article']->value->admin_author!=''&&$_smarty_tpl->tpl_vars['article']->value->admin_author!=null) {?>
                                <?php echo $_smarty_tpl->tpl_vars['article']->value->admin_author->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['article']->value->admin_author->last_name;?>

                            <?php }?>
                        </span>
                        on <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['article']->value->published_at);?>
</span></p>
                        <div class="text-gray articleContentDesc">
                                    <?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['article']->value->content),450);?>
</div>
                            <div class="socialLinks">
                                <div class="btn btn-box-blue inline-block">
                                    <i class="fa fa-link inline-block"></i>
                                </div>                    
                                <div class="articleComments text-gray inline-block"><span><?php echo count($_smarty_tpl->tpl_vars['article']->value->comments);?>
</span> COMMENTS</div>
                                <div class="articleFooter no-padding">
                                    <div class="socicalIcon articleShareIcon">
                                        <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/linkedin.jpg"></a>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/linkedin.jpg"></a>
                                        <?php }?>
                                    </div>
                                </div> 
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="btn btn-box-blue articlereadmore">
                            <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="btn btn-box-blue articlereadmore">
                            <?php }?>
                        VIEW DETAILS</a>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['key']->value%3==0) {?>
                    <div class="clearfix visible-xs"></div>
                <?php } elseif ($_smarty_tpl->tpl_vars['key']->value%3==1) {?>
                    <div class="clearfix visible-sm"></div>
                <?php } elseif ($_smarty_tpl->tpl_vars['key']->value%3==2) {?>
                    <div class="clearfix visible-md visible-lg"></div>
                <?php }?>
            </div>
        <?php } ?>
        
        
        <?php if ($_smarty_tpl->tpl_vars['response']->value['count']>9) {?>
        <div class="articlePagination col-xs-12">
            <ul class="pagination">
                <!-- displayHide -->
                <?php if ($_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['curPage']>1) {?>
                <li class="previous">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['pag_url']->value;?>
page/<?php echo $_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['prev'];?>
"  ><i class="fa fa-angle-left"></i></a></li>
                <?php }?>
                <?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
                <li <?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['curPage']) {?>class="active"<?php }?>>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['pag_url']->value;?>
page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="text-white"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</a>
                </li>
                <?php } ?>
                <?php if ($_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['curPage']<$_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['lastPage']) {?>
                <li class="next">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['pag_url']->value;?>
page/<?php echo $_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['next'];?>
" class="text-white"> <i class="fa fa-angle-right"></i></a></li>
                <?php }?>
            </ul>
        </div>
        <?php }?>
    </div>
    <div class="col-xs-12 article no-padding" ng-show="showPopular">
        
        <?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['response']->value['populararticles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['article']->key;
?>
            <div class="clearfix"></div>
            <div ng-cloak>
                <div class="col-xs-12 singleArticle no-padding margin-bottom-10">
                    <div class="col-xs-12 col-sm-6 articleImg no-padding margin-bottom-5">
                        <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
">
                        <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" video-play-hover>
                        <?php }?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
image/article?file_name=<?php echo $_smarty_tpl->tpl_vars['article']->value->id;?>
/<?php echo $_smarty_tpl->tpl_vars['article']->value->thumbnail_big_image;?>
&w=570&h=270" class="img-responsive width_90 radius-3 border-bottom-light-grey">
                            <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                                <div class="videoImgContent">
                                    <div class="videoImgPlayButton">
                                        <span class="videoPlayImg">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/play.png" class="play width_30" alt="">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/play1.png" class="playHover width_30" alt="">
                                        </span>
                                    </div>
                                </div>
                            <?php }?>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 articleContent no-padding">
                        <h3 class="text-bold text-gray no-top-margin">
                            <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="linkBlack">
                            <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="linkBlack">
                            <?php }?>
                            <?php echo $_smarty_tpl->tpl_vars['article']->value->title;?>
</a></h3>
                        <p class="text-blue">By
                        <span class="authorName">
                            <?php if (isset($_smarty_tpl->tpl_vars['article']->value->author)&&$_smarty_tpl->tpl_vars['article']->value->author!=''&&$_smarty_tpl->tpl_vars['article']->value->author!=null) {?>
                                <?php echo $_smarty_tpl->tpl_vars['article']->value->author->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['article']->value->author->last_name;?>

                            <?php } elseif (isset($_smarty_tpl->tpl_vars['article']->value->admin_author)&&$_smarty_tpl->tpl_vars['article']->value->admin_author!=''&&$_smarty_tpl->tpl_vars['article']->value->admin_author!=null) {?>
                                <?php echo $_smarty_tpl->tpl_vars['article']->value->admin_author->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['article']->value->admin_author->last_name;?>

                            <?php }?>
                        </span>
                        on <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['article']->value->published_at);?>
</span></p>
                        <div class="text-gray articleContentDesc">
                            <?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['article']->value->content),450);?>
</div>
                            <div class="socialLinks">
                                <div class="btn btn-box-blue inline-block">
                                    <i class="fa fa-link inline-block"></i>
                                </div>                    
                                <div class="articleComments text-gray inline-block"><span><?php echo count($_smarty_tpl->tpl_vars['article']->value->comments);?>
</span> COMMENTS</div>
                                <div class="col-md-12 articleFooter no-padding">
                                    <div class="socicalIcon articleShareIcon">
                                        <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/linkedin.jpg"></a>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" target="_blank">
                                            <img class="margin-3" src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/linkedin.jpg"></a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['article']->value->type_id==1) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="btn btn-box-blue articlereadmore">
                            <?php } elseif ($_smarty_tpl->tpl_vars['article']->value->type_id==3) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
insight/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['article']->value->perma_link, 'UTF-8');?>
" class="btn btn-box-blue articlereadmore">
                            <?php }?>VIEW DETAILS</a>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['key']->value%3==0) {?>
                    <div class="clearfix visible-xs"></div>
                <?php } elseif ($_smarty_tpl->tpl_vars['key']->value%3==1) {?>
                    <div class="clearfix visible-sm"></div>
                <?php } elseif ($_smarty_tpl->tpl_vars['key']->value%3==2) {?>
                    <div class="clearfix visible-md visible-lg"></div>
                <?php }?>
            </div>
        <?php } ?>
        
        <?php if ($_smarty_tpl->tpl_vars['response']->value['count']>9) {?>
        <div class="articlePagination col-xs-12">
            <ul class="pagination">
                <!-- displayHide -->
                <?php if ($_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['curPage']>1) {?>
                <li class="previous">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['pag_url']->value;?>
page/<?php echo $_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['prev'];?>
" class="text-white"><i class="fa fa-angle-left"></i></a></li>
                <?php }?>
                <?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
                <li <?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['curPage']) {?>class="active"<?php }?>>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['pag_url']->value;?>
page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" class="text-white"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</a>
                </li>
                <?php } ?>
                <?php if ($_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['curPage']<$_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['lastPage']) {?>
                <li class="next">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;
echo $_smarty_tpl->tpl_vars['pag_url']->value;?>
page/<?php echo $_smarty_tpl->tpl_vars['response']->value['allArticlesCountPagination']['next'];?>
" class="text-white"><i class="fa fa-angle-right"></i></a></li>
                <?php }?>
            </ul>
        </div>
        <?php }?>
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
js/bower_components/jquery-ui/jquery-ui.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/tag-it.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/bower_components/adapters/jquery.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
js/ckEditorCode.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        pageName = "<?php echo mb_strtoupper($_smarty_tpl->tpl_vars['response']->value['pageTitle'], 'UTF-8');?>
";
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
<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-09-23 15:25:21
         compiled from "application/views/templates/popups/newarticle.popup.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e4fc09bbced4_02419294')) {function content_57e4fc09bbced4_02419294($_smarty_tpl) {?><div class="addNewArticle inactive">
    <div class="newArticleContainer closePopup"></div>
    <div class="newArticleContent">
        <a href="#" class="closeNewArticlePopup closePopupIcon linkBlack"><i class="fa fa-close"></i></a>
        <h4>Add Article</h4>
        <form id="addArticleForm" action="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
article/create" method="post" enctype="multipart/form-data" onsubmit="return ValidateArticle();">
            <input type="hidden" name="content" id="article_content" value="" />
            <div class="col-xs-12 no-padding">
                <input type="text" placeholder="Title" class="width_100 space10" name="title" id="article_title" maxlength="500"></input>
            </div>
            <div class="clearfix"></div>
            <div id="editor" class="margin-top-20"></div>
            <div class="col-xs-12 no-padding margin-top-20">
                <select class="width_100" name="category"  id="article_category">
                    <option value="" selected>Select Category</option>
                    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['response']->value['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value->title;?>
</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-xs-12 no-padding">
                <ul id="myTags" class="margin-top-20" placeholder="tags">
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 no-padding">
                <div class="profileupload ">
                    <div class="uploadimg padding-5"><input type="file" name="article_image"  id="article_image" /><i class="fa fa-paperclip"></i><span> Attach Images</span></div>
                    <img src="" class="img-responsive space10 articleImg inactive" alt="profile" style="height: 50px;" />
                </div>
            </div>
            <div class="col-xs-12 no-padding margin-top-10 articleSubmitButton">
                <button type="submit" class="btn btn-blue pull-right" id="articleSubmitButton"> SUBMIT </button>
            </div>
        </form>
    </div>
</div><?php }} ?>
