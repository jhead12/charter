<?php /* Smarty version 2.6.13, created on 2008-04-23 20:57:33
         compiled from profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'profile.tpl', 2, false),)), $this); ?>
<div class="mlefttop">
	<div><a href="#" onclick="request('home1', 'main', event);" title="Home">Home</a> &raquo; <a href="#" onclick="request('friend_list', 'mleft', event);" title="Home">My Friends</a> &raquo; <?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</div>
	<h3><?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
's Profile</h3>
	<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td valign="top"><?php if ($this->_tpl_vars['member']['image_name']): ?><img src="<?php echo $this->_tpl_vars['imageUrl']; ?>
/get_thumbs.php?im=member/<?php echo $this->_tpl_vars['member']['image_name']; ?>
&width=140&height=140" pbsrc="<?php echo $this->_tpl_vars['memberUrl']; ?>
/<?php echo $this->_tpl_vars['member']['image_name']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
" onclick="PopEx(this,null,null,null,0,50,'PopBoxImageLarge');" /><?php endif; ?></td>
		<td valign="top">
			<table cellpadding="3" cellspacing="0" border="0">
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['member']['email'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>:</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['member']['phone'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
			</tr>
			<tr>
				<td>Website</td>
				<td>:</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['member']['website'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<br /><br /><br /><br /><br /><br />
</div>