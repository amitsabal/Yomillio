<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-16 12:35:07
         compiled from "application/views/templates/popups/forgotpassword.popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18730205620a1a3ef6268-53445907%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1c0ad49df22d37c2274313272252c72fd3675ab' => 
    array (
      0 => 'application/views/templates/popups/forgotpassword.popup.tpl',
      1 => 1437646126,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18730205620a1a3ef6268-53445907',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MEDIA_FILES_URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5620a1a3f3caf7_71316680',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5620a1a3f3caf7_71316680')) {function content_5620a1a3f3caf7_71316680($_smarty_tpl) {?><!-- Forgot password popup -->
<div class="forgotPasswordFull" ng-controller="AccountCtrl">
    <div class="ForgotPasswordContainer"></div>
    <div class="ForgotPasswordPopup">
        <a href="#" class="forgotPasswordClosePopup forgotPasswordClosePopupIcon"><i class="fa fa-close"></i></a>
        <div class="center-margin padding-bottom-15">
            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/logo.png" class="img-responsive center-margin">
        </div>
        <hr>
        <form class="forgotPasswordForm" id="forgotPasswordForm" name="forgotPasswordForm" method="post" ng-submit="forgotpassword();" novalidate>
            <div class="col-xs-12">
                <div class="emailfield">
                    <input type="email" class="email form-control" name="registeredEmail" id="registeredEmail" placeholder="Email" maxlength="50" ng-model="user.email" required />
                    
                </div>
                <div class="col-xs-12 no-padding margin-top-10 forgotPasswordBtn">
                    <button type="submit" class="btn btn-blue center-button" id="forgotPasswordBtn"> SUBMIT </button>
                </div>
                <div id="loadingPassword" class="text-center loading"></div>
                <div class="col-xs-12 no-padding margin-top-10 forgotPasswordText" style="display:none;font-size: 13px;color: black;">
                    <p>Check your email</p>
                    <p>You should receive an email containing instructions on how to create a new password</p>
                    <br/>
                    <p style="font-weight: bold">Didn't receive the email?</p>
                    <p>Check spam or bulk folders for a message coming from <span style="font-weight: bold;">r2i@zinnov.com</span></p>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Forgot password popup --><?php }} ?>
