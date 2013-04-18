<?php /* Smarty version 2.6.13, created on 2008-04-20 17:05:32
         compiled from form_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'formadddatapart', 'form_login.tpl', 2, false),array('insert', 'formaddlabelpart', 'form_login.tpl', 3, false),array('insert', 'formaddinputpart', 'form_login.tpl', 3, false),)), $this); ?>
<?php ob_start(); ?><div style="text-align:center;padding-top:100px">
    <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form_error.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  ob_start(); ?>
    <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'username', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start();  if (isset ( $this->_tpl_vars['verify']['username'] )): ?><font color="Black" size="1"><?php echo $this->_tpl_vars['mark']; ?>
</font><?php endif; ?><br /><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'username', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?><br />
    <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'passwd', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start();  if (isset ( $this->_tpl_vars['verify']['passwd'] )): ?><font color="Black" size="1"><?php echo $this->_tpl_vars['mark']; ?>
</font><?php endif; ?><br /><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'passwd', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?><br />	
    <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'doEntry', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>
</div><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this); ?>