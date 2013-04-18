<?php /* Smarty version 2.6.13, created on 2008-06-10 10:21:19
         compiled from product_thumb.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'product_thumb.tpl', 9, false),)), $this); ?>
<table cellpadding="0" cellspacing="0" border="0" width="770">
	<tr>
		<td valign="top" width="25" valign="middle"><?php if (empty ( $this->_tpl_vars['prevLink'] ) == false): ?>
		    <a href="#" onclick="request('<?php echo $this->_tpl_vars['prevLink']['method']; ?>
','pthumb', event);" title="Prev"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/arrow-right.gif" border="0" /></a>
		<?php endif; ?>&nbsp;</td>
		<td valign="top" width="740" align="center">
		<div style="overflow:hidden;margin:11px auto;width:680px;" id="holder">
<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fra'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fra']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['fra']['iteration']++;
?>
<div id="thumb<?php echo $this->_tpl_vars['product']['product_id']; ?>
" <?php if (($this->_foreach['fra']['iteration']-1) == 0): ?>class="selthumb"<?php else: ?>class="othumb"<?php endif; ?> style="width:90px;height:83px;overflow:hidden;margin-left:3px;margin-right:3px;float:left;"><a href="#" onclick="request('<?php echo $this->_tpl_vars['baseUrl']; ?>
/product.php?page=product_detail&id=<?php echo $this->_tpl_vars['product']['product_type_id']; ?>
&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
', 'content', event);"><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['center_image']; ?>
&width=90&height=76" width="90" height="76" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['product']['product_name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
" style="float:left" class="thumb" border="0" onclick=" changeSelect('thumb<?php echo $this->_tpl_vars['product']['product_id']; ?>
');" /></a></div>
<?php endforeach; endif; unset($_from); ?>
		</div>
		</td>
		<td valign="top" width="23" valign="middle"><?php if (empty ( $this->_tpl_vars['nextLink'] ) == false): ?>
		    <a href="#" onclick="request('<?php echo $this->_tpl_vars['nextLink']['method']; ?>
','pthumb', event);" title="Next"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/arrow-left.gif" border="0" /></a>
		<?php endif; ?></td>
	</tr>
	</table>
<script language="javascript" type="text/javascript">
<?php echo '
function changeSelect(selid) {
	var holder = document.getElementById(\'holder\');
	var thumbs = holder.childNodes;
	for(i= 0; i < thumbs.length; i++) {
		if(thumbs[i].id != selid) {
			thumbs[i].className = \'othumb\';
		}
		else {
			thumbs[i].className = \'selthumb\';
		}
	}
}
'; ?>

</script>