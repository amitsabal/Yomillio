<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-16 12:35:07
         compiled from "application/views/templates/account/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14945222225620a1a3dc11d1-06550891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2996f22ecf51ee14e040fa1a01e92e7075e74f9' => 
    array (
      0 => 'application/views/templates/account/login.tpl',
      1 => 1437646126,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14945222225620a1a3dc11d1-06550891',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5620a1a3e75d85_44144843',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5620a1a3e75d85_44144843')) {function content_5620a1a3e75d85_44144843($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("popups/login.popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ("popups/signup.popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ("popups/forgotpassword.popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ("popups/newthread.popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
