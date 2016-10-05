<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-09-21 17:42:51
         compiled from "application/views/templates/popups/signup.popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121650356757e279437edd91-00976478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28498a714de06cee27e871d6bcf4932b9ceae479' => 
    array (
      0 => 'application/views/templates/popups/signup.popup.tpl',
      1 => 1440391901,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121650356757e279437edd91-00976478',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'APP_BASE_URL' => 0,
    'MEDIA_FILES_URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57e279437f5356_27556759',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57e279437f5356_27556759')) {function content_57e279437f5356_27556759($_smarty_tpl) {?><!-- Signup popup -->
<div class="signupPopupContainer">
    <div class="LinkedInContainer"></div>
    <div class="signupPopup" ng-model="loggedInUser">
        <!-- <a href="#" class="linkedInClosePopup linkedInClosePopupIcon linkBlack"><i class="fa fa-close"></i></a> -->
        <h3 class="no-margin">My Profile</h3>        
                <span class="text-red pull-right  margin-left-5">* Fields are mandatory</span>
        <form name="profileUpdate" id="profileUpdateSignup" action="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
user/updateprofile" method="post" enctype="multipart/form-data" onsubmit="return ValidateProfile();">
            <input type="hidden" name="curUrl" value="" />
        <div class="col-xs-12 col-sm-4 no-padding">
            <div class="profileupload  margin-top-20">
                <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/profile.png" class="img-responsive" alt="profile" id="profile_pic" style="height: 140px;" />
                <div class="uploadimg padding-5"><input type="file" id="profileUploadSignUp" name="profile_pic" data-file-type="png,jpg,jpeg" /><img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/upload.png" /><span> UPLOAD</span></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 no-padding">
            <span class="input-icon margin-top-20 pull-left">
                <span class="text-red pull-right">*</span>
                <input type="text" class="form-control pull-left" id="firstname" name="first_name" placeholder="First Name" maxlength="50" ng-model="loggedInUser.first_name" />
            </span>
            <span class="input-icon margin-top-20 pull-right">
                <input type="text" class="form-control pull-left" id="lastname" name="last_name" placeholder="Last Name" maxlength="50" ng-model="loggedInUser.last_name" />
            </span>	
            <div class="clearfix"></div>
            <span class="input-icon margin-top-20">
                <span class="text-red pull-right margin-right-4">*</span>
                <input type="text" class="form-control pull-left" id="jobtitle" name="linkedin_job_title" placeholder="Job Title" maxlength="256" ng-model="loggedInUser.linkedin_job_title" />
            </span>	
            <div class="clearfix"></div>
            <span class="input-icon margin-top-20">
                <span class="text-red pull-right margin-right-4">*</span>
                <textarea type="text" class="form-control pull-left" id="biodata" name="bio" placeholder="Biodata" rows="4" ng-model="loggedInUser.bio"></textarea>
            </span>		
        </div>	
        <div class="col-xs-12 padding-vertical-10">
            <button type="submit" class="btn btn-blue pull-rightdream" id="signUpSave"> Save </button>
        </div>
        </form>
    </div>
</div>
<!-- Signup popup --><?php }} ?>
