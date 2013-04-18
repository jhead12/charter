<?php /* Smarty version 2.6.13, created on 2008-03-26 16:25:22
         compiled from current_openings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'current_openings.tpl', 4, false),array('modifier', 'stripslashes', 'current_openings.tpl', 10, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="clmid">
	<img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/UserFiles/page/<?php echo ((is_array($_tmp=@$this->_tpl_vars['page']['logo'])) ? $this->_run_mod_handler('default', true, $_tmp, "current_openings.gif") : smarty_modifier_default($_tmp, "current_openings.gif")); ?>
" alt="Current Openings" />
</div>
<div class="clbottom">
	<div class="sitetree">
     	<a href="<?php echo $this->_tpl_vars['baseUrl']; ?>
/index.php?page=career" title="Career">Career</a> &raquo; Current Openings
    </div>
    <?php echo ((is_array($_tmp=$this->_tpl_vars['content'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>

    <?php $_from = $this->_tpl_vars['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['job']):
?>
    	<p class="content"><a name="<?php echo $this->_tpl_vars['job']['jobid']; ?>
"></a><b><?php echo $this->_tpl_vars['job']['title']; ?>
 (Job Code: <?php echo $this->_tpl_vars['job']['job_code']; ?>
</b></p>
    	<?php echo ((is_array($_tmp=$this->_tpl_vars['job']['description'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>

    	<a href="<?php echo $this->_tpl_vars['baseUrl']; ?>
/index.php?page=apply_online&amp;id=<?php echo $this->_tpl_vars['job']['job_id']; ?>
" title="Apply">Apply for this position</a>
    <?php endforeach; endif; unset($_from); ?>
</div>