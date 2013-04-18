<?php /* Smarty version 2.6.13, created on 2008-04-20 15:59:43
         compiled from form_error.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'formadddatapart', 'form_error.tpl', 43, false),)), $this); ?>
<?php ob_start();  if ($this->_tpl_vars['error_message'] != ""): ?>
<center><table summary="Validation error table" border="1" bgcolor="#c0c0c0" cellpadding="2" cellspacing="1">
<tr>
<td bgcolor="#808080" style="border-style: none"><table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td><b><font color="#c0c0c0">Validation error</font></b></td>
</tr>
</table></td>
</tr>
<tr>
<td style="border-style: none"><table cellpadding="0" cellspacing="0">
<tr>
<td><table frame="box" bgcolor="#FF8000">
<tr>
<td><b>!</b></td>
</tr>
</table></td>
<td><table>
<tr>
<td><b><?php echo $this->_tpl_vars['error_message']; ?>
</b></td>
</tr>
</table></td>
</tr>
<?php if (count ( $this->_tpl_vars['verify'] ) > 1): ?>
<tr>
<td><table frame="box" bgcolor="#FF8000">
<tr>
<td><b>!</b></td>
</tr>
</table></td>
<td><table>
<tr>
<td><b>Please verify also the remaining fields marked with [Verify]</b></td>
</tr>
</table></td>
</tr>
<?php endif; ?>
</table></td>
</tr>
</table></center>
<br />
<?php endif; ?>
<?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this); ?>