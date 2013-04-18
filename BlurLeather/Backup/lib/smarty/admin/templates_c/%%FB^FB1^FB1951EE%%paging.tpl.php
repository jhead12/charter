<?php /* Smarty version 2.6.13, created on 2008-05-07 23:12:59
         compiled from paging.tpl */ ?>
<?php if ($this->_tpl_vars['prevLink'] || $this->_tpl_vars['nextLink'] || $this->_tpl_vars['pagination']): ?>
<p class="text">
Page :
<?php if (empty ( $this->_tpl_vars['prevLink'] ) == false): ?>
    <a href="<?php echo $this->_tpl_vars['prevLink']['method']; ?>
" title="Prev">&lt;&lt;</a>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['pagination']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
    <?php if (intval ( $this->_tpl_vars['startRec'] ) == intval ( $this->_tpl_vars['page']['startRec'] )): ?>
    	&nbsp;<span style="font-size:11px;font-weight:bold;"><?php echo $this->_tpl_vars['page']['number']; ?>
</span>&nbsp;
    <?php else: ?>
    	&nbsp;<a href="<?php echo $this->_tpl_vars['page']['method']; ?>
" title="<?php echo $this->_tpl_vars['page']['number']; ?>
"><?php echo $this->_tpl_vars['page']['number']; ?>
</a> &nbsp;
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if (empty ( $this->_tpl_vars['nextLink'] ) == false): ?>
    <a href="<?php echo $this->_tpl_vars['nextLink']['method']; ?>
" title="Next">&gt;&gt;</a>
<?php endif; ?>
</p>
<?php endif; ?>