<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-09-21 17:42:51
         compiled from "application/views/templates/popups/newthread.popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:204350611257e279437fd0c3-27298027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a0135af6fdb9880869d3063f581ebf57d4dcbea' => 
    array (
      0 => 'application/views/templates/popups/newthread.popup.tpl',
      1 => 1442226241,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '204350611257e279437fd0c3-27298027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'response' => 0,
    'category' => 0,
    'APP_BASE_URL' => 0,
    'MEDIA_FILES_URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57e27943815013_06661146',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57e27943815013_06661146')) {function content_57e27943815013_06661146($_smarty_tpl) {?><!-- New thread popup -->
<div class="newThreadsFull" ng-controller="forumController">
    <div class="newThreadsContainer"></div>
    <div class="newThreadsPopup">
        <a href="#" class="newThreadsClosePopup newThreadsClosePopupIcon"><i class="fa fa-close"></i></a>
        <div class="center-margin">
            <p class="font-family-medium text-extra-extra-large">Add New Thread</p>
        </div>
        <hr>
        <form class="newThreadsForm" id="newThreadsForm" name="newThreadsForm" method="post" >
            <div class="col-xs-12 no-padding">
                <select class="width_100 padding-10" id="thread_category" ng-model="forum.category_id" placeholder="Select Category">
                    <option value="" disabled selected>Select Category</option>
                    <?php if (isset($_smarty_tpl->tpl_vars['response']->value['forumcategories'])) {?>
                    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['response']->value['forumcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?> 
                        <option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value->title;?>
</option>
                    <?php } ?>
                    <?php }?>
                </select>
            </div>
            <div class="col-xs-12 no-padding padding-top-20">
                <div class="threadHeading col-xs-12 no-padding">
                    <input type="text" class="threadHeadingInput form-control" name="threadHeading" id="thread_heading" placeholder="Thread Heading" maxlength="1024" ng-model="forum.title" required />
                </div>
                <div class="threadContent col-xs-12 no-padding padding-top-20">
                    <textarea rows="5" cols="50" class="width_100 padding-10 threadContentInput" placeholder="Thread Description" maxlength="5000" ng-model="forum.summary"></textarea>
                </div>
                
                <div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-12 col-md-12 no-padding">
                        <div class="col-xs-3 col-xs-offset-2">
                        <label for="forum_tags">Enter Secure Code <span class="text-red">*</span> : </label>
                        <img id="captcha" src="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
captcha" alt="CAPTCHA Image" style="border: 1px solid #000; margin-right: 15px" />
                        </div>
                        <div class="col-xs-4">                        
                        <input type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6" ng-model="forum.captcha_code" />
                        <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['MEDIA_FILES_URL']->value;?>
images/refresh.png" height="32" width="32" alt="Reload Image" onclick="this.blur()" align="bottom" border="0">
                        </a>
                        </div>
                        <span class="col-xs-12 label label-danger"><?php if (isset($_smarty_tpl->tpl_vars['response']->value['error'])&&isset($_smarty_tpl->tpl_vars['response']->value['error']['captcha_code'])) {
echo $_smarty_tpl->tpl_vars['response']->value['error']['captcha_code'];
}?></span>
                    </div>
                </div>
                
                <div class="col-xs-12 no-padding margin-top-10 threadSubmitBtn">
                    <button type="button" class="btn btn-blue pull-right" id="thread_submit_btn" ng-click="searchForum(forum);" ng-disabled="disableSubmitButton"> SUBMIT </button>
                </div>
                
            </div>
        </form>
    </div>
    <!-- Similar Threads -->
    <div class="similarThreadsPopup">
        <a href="#" class="similarThreadsClosePopup similarThreadsClosePopupIcon"><i class="fa fa-close"></i></a>
        <div class="center-margin">
            <p class="font-family-medium text-extra-extra-large">Check for similar threads</p>
            <p class="text-gray" ng-bind="forum.title"></p>
        </div>
        <hr>
        <div class="col-xs-12 no-padding padding-top-20">
            <div class="similarThread col-xs-12 no-padding">
                <p ng-repeat="thread in similarThreads"><a href="<?php echo $_smarty_tpl->tpl_vars['APP_BASE_URL']->value;?>
forum/{{thread.perma_link}}" target="_blank" ng-bind="thread.title"></a></p>
            </div>
            <div class="col-xs-12 no-padding margin-top-10 threadSubmitBtn">
                <button type="submit" class="btn btn-blue pull-right" id="thread_submit_btn2" ng-click="addForum(forum);"  ng-disabled="disableSubmitButton"> My Thread is New </button>
                <button type="submit" class="btn btn-logIn pull-right margin-horizontal-10" id="back_add_thread">Edit My Thread</button>
            </div>
        </div>
    </div>
</div>
<!-- New thread popup --><?php }} ?>
