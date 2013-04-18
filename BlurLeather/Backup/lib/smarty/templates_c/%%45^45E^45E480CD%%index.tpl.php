<?php /* Smarty version 2.6.13, created on 2008-04-23 20:52:59
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'index.tpl', 2, false),)), $this); ?>
	<div class="tmenu">
		<b>Hi <?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</b><br />
		<a href="#" onclick="request('home1', 'main', event);" title="Home">Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onclick="request('friend_list', 'mleft', event);" title="My Friends">My Friends</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onclick="request('logout', 'main', event);" title="Log Out">Log Out</a>
	</div>
	<div class="mright">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<div id="mleft">
		<div class="mlefttop">
			<div id="mltop">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "latest_comments.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<div id="mlbottom">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top_picks.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
		<div id="mleftbottom">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	</div>
	