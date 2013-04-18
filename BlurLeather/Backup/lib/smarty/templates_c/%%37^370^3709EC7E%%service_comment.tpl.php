<?php /* Smarty version 2.6.13, created on 2008-04-23 21:44:12
         compiled from service_comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'service_comment.tpl', 2, false),)), $this); ?>
<div class="mlefttop">
	<div><a href="#" onclick="request('home1', 'main', event);" title="Home">Home</a> &raquo; <a href="#" onclick="request('service_detail-id-<?php echo $this->_tpl_vars['service']['service_id']; ?>
', 'mleft', event);" title="Home"><?php echo ((is_array($_tmp=$this->_tpl_vars['service']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</a> &raquo; Add Comment</div>
	<h3><?php echo ((is_array($_tmp=$this->_tpl_vars['service']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
 <span style="font-size:0.8em;font-weight:normal;"><?php echo $this->_tpl_vars['service']['module_name']; ?>
</span></h3>
	<form action="<?php echo $this->_tpl_vars['baseUrl']; ?>
/index.php?page=addcomment&id=<?php echo $this->_tpl_vars['service']['service_id']; ?>
" method="post" name="frmPostComment" id="frmPostComment" onsubmit="frmAddComment(event);">
	<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<th colspan="3">Add Comment</th>
	</tr>
	<tr>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['service']['module_name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
		<td>:</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['service']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
	</tr>
	<tr>
		<td>Rating</td>
		<td>:</td>
		<td><select name="cboRating" id="cboRating">
			<option value="1">Thumb up</option>
			<option value="0">Thumb down</option>
		</select></td>
	</tr>
	<tr>
		<td valign="top">Comment</td>
		<td valign="top">:</td>
		<td><textarea name="txtComment" id="txtComment" cols="40" rows="5"></textarea></td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td><input type="submit" id="addc" name="addc" value="Add Comment" /> <input type="button" value="Cancel" onclick="request('service_detail-id-<?php echo $this->_tpl_vars['service']['service_id']; ?>
', 'mleft', event);" /></td>
	</tr>
	</table>
	</form>
</div>