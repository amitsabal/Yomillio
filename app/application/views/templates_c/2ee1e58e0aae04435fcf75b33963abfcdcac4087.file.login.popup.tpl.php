<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-16 12:35:07
         compiled from "application/views/templates/popups/login.popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1524869975620a1a3e78d21-45633486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ee1e58e0aae04435fcf75b33963abfcdcac4087' => 
    array (
      0 => 'application/views/templates/popups/login.popup.tpl',
      1 => 1440060751,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1524869975620a1a3e78d21-45633486',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MEDIA_FILES_URL' => 0,
    'APP_BASE_URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5620a1a3ec73a7_96203467',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5620a1a3ec73a7_96203467')) {function content_5620a1a3ec73a7_96203467($_smarty_tpl) {?><!--Login popup -->
<div class="loginContainerFull" ng-controller="AccountCtrl">
    <div class="loginContainer closePopup"></div>
    <div class="loginPopup">
        <!-- <a href="#" class="closePopup closePopupIcon linkBlack"><i class="fa fa-close"></i></a>
        <div class="center-margin padding-bottom-15">
            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/logo.png" class="img-responsive center-margin">
        </div> -->

        <div role="tabpanel">
            <!-- Nav tabs -->
            <!-- <ul class="nav nav-tabs text-extra-large" role="tablist" id="loginTab">
                <li role="presentation" class="active padding-left-20"><a class="linkBlue" href="#signInTab" aria-controls="home" role="tab" data-toggle="tab">LOG IN</a></li>
                <li role="presentation"><a class="linkBlue" href="#signUpTab" aria-controls="profile" role="tab" data-toggle="tab">SIGN UP</a></li>
            </ul> -->

            <!-- Tab panes -->
            <a href="#" class="closePopup closePopupIcon linkBlack"><i class="fa fa-close"></i></a>
            <div class="tab-content margin-top-25">
                <div role="tabpanel" class="tab-pane active" id="signInTab">
                    <div class="panel-group no-margin" id="accordion1" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                        <div class="panel-heading background-brickblue no-padding" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseLogin" aria-expanded="true" aria-controls="collapseOne" class="text-white">
                                <i class="fa fa-chevron-right padding-horizontal-5"></i>
                                <i class="fa fa-chevron-down padding-horizontal-5 no-display"></i>
                              <div class="width_90 padding-vertical-10 inline-block">Log In</div>
                            </a>
                          </h4>
                        </div>
                        <div id="collapseLogin" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <form class="signInForm" id="signInForm" method="post">
                                <span class="input-icon">
                                <input type="text" class="email form-control" id="signInEmail" placeholder="User Name" maxlength="50">
                                </span>
                                <div class="clearfix"></div>
                                <span class="input-icon margin-top-10">
                                    <input type="password" class="password form-control" id="signInPassword" placeholder="Password" maxlength="25">
                                </span>
                                <div class="clearfix"></div>
                                <div class="col-xs-8 padding-vertical-5">
                                    <a class="forgot linkBlue pull-right" id="forgot_password" href="#">
                                        Forgot Password?
                                    </a> 
                                </div>  
                                <div class="clearfix"></div>
                                <div class="col-xs-12 no-padding margin-top-10">
                                    <button type="submit" class="btn btn-blue pull-right" onClick="login();"> Log in </button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading background-brickblue no-padding" role="tab" id="headingTwo">
                          <h4 class="panel-title">
                            <a class="collapsed text-white" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseSignup" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="fa fa-chevron-right padding-horizontal-5"></i>
                            <i class="fa fa-chevron-down padding-horizontal-5 no-display"></i>
                            <div class="width_90 padding-vertical-10 inline-block">Sign Up</div>
                            </a>
                          </h4>
                        </div>
                        <div id="collapseSignup" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            <form class="signInForm" id="signUpForm" name="signUpForm" method="post"  novalidate>
                                <div class="col-xs-12">
                                    <div class="margin-top-20">
                                        <input type="email" class="email form-control" id="signUpEmail" placeholder="Email" maxlength="50" required />
                                        
                                    </div>
                                    <div class="margin-top-10">
                                        <input type="password" class="password form-control" name="signUpPassword" id="signUpPassword" placeholder="Password" maxlength="25" required>
                                        
                                    </div>
                                    <div class="margin-top-10">
                                        <input type="password" class="rePassword form-control" id="signUpRePassword" placeholder="Confirm Password" required maxlength="25">
                                    </div>
                                    <div class="col-xs-12 no-padding margin-top-10 signUpBtn">
                                        <button type="submit" class="btn btn-blue pull-right" onClick="signup();"> SIGN UP </button>
                                    </div>
                                    <div id="loadingSignUp" class="text-center loading"></div>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>		
            </div>

            <div class="col-xs-12 linkedin-alternative-padding"><p class="linkedin-alternative text-white"><span>OR</span></p></div>
            <div class="col-xs-12 linkedInWrap">
                <a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
linkedin/linkedin.php"><img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/signinlinkedin.png" alt="Sign Up With LinkedIn" class="img-responsive center-margin"></a>	
            </div>			
        </div>
    </div>
</div>
<!-- Login popup--><?php }} ?>
