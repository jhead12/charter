<?php /* Smarty version 2.6.13, created on 2008-04-22 23:03:33
         compiled from paging.tpl */ ?>
<?php if ($this->_tpl_vars['module']['prevLink'] || $this->_tpl_vars['module']['nextLink'] || $this->_tpl_vars['module']['pagination']): ?>
<p class="text" align="center">
Page :
<?php if (empty ( $this->_tpl_vars['module']['prevLink'] ) == false): ?>
    <a href="#" onclick="request('<?php echo $this->_tpl_vars['module']['prevLink']['method']; ?>
',this.parentNode.parentNode.id, event);" title="Prev">&lt;&lt;</a>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['module']['pagination']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
    <?php if (intval ( $this->_tpl_vars['module']['startRec'] ) == intval ( $this->_tpl_vars['page']['startRec'] )): ?>
    	&nbsp;<span style="font-size:1.1em;font-weight:bold;"><?php echo $this->_tpl_vars['page']['number']; ?>
</span>&nbsp;
    <?php else: ?>
    	&nbsp;<a href="#" onclick="request('<?php echo $this->_tpl_vars['page']['method']; ?>
',this.parentNode.parentNode.id, event);" title="<?php echo $this->_tpl_vars['page']['number']; ?>
"><?php echo $this->_tpl_vars['page']['number']; ?>
</a> &nbsp;
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if (empty ( $this->_tpl_vars['module']['nextLink'] ) == false): ?>
    <a href="#" onclick="request('<?php echo $this->_tpl_vars['module']['nextLink']['method']; ?>
',this.parentNode.parentNode.id, event);" title="Next">&gt;&gt;</a>
<?php endif; ?>
</p>
<?php endif; ?>