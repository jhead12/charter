<?php /* Smarty version 2.6.13, created on 2008-05-07 23:12:47
         compiled from form_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'formadddatapart', 'form_login.tpl', 1, false),array('insert', 'formaddlabelpart', 'form_login.tpl', 7, false),array('insert', 'formaddinputpart', 'form_login.tpl', 8, false),)), $this); ?>
<?php ob_start();  $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form_error.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  ob_start(); ?>
<table cellpadding="0" cellspacing="0" >
  <tr align="left">
    <td width="10" height="20"></td>
    <td width="30" align="center">&nbsp;</td>
    <td width="10"></td>
    <td width="100" class="n-11white"  ><a class="n-11putih" ><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'username', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>
    <td width="230" ><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'username', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start();  if (isset ( $this->_tpl_vars['verify']['username'] )):  echo $this->_tpl_vars['mark'];  endif; ?></td>
  </tr>
  <tr>
    <td width="360" height="10" colspan="5"></td>
  </tr>
  <tr align="left">
    <td height="20"></td>
    <td align="center"  >&nbsp;</td>
    <td ></td>
    <td class="n-11white"><a class="n-11putih" ><b><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'passwd', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></b></a></td>
    <td><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'passwd', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start();  if (isset ( $this->_tpl_vars['verify']['passwd'] )):  echo $this->_tpl_vars['mark'];  endif; ?></td>
  </tr>
  <tr>
    <td width="360" height="10" colspan="5"></td>
  </tr>
  <tr align="left">
    <td  height="20"></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td ><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'doEntry', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>
  </tr>
  <tr>
    <td width="360" height="5" colspan="5"></td>
  </tr>
</table><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this); ?>