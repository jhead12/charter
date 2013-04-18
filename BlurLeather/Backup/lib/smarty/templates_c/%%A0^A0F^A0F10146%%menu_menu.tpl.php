<?php /* Smarty version 2.6.13, created on 2008-04-23 09:52:29
         compiled from menu_menu.tpl */ ?>
<div class="menuheader"><span style="float:left;"><?php echo $this->_tpl_vars['category']['category_name']; ?>
</span>
	<ul id="lstmenu">
		<li>
			<ul>
				<li><a href="#" onclick="return false;">Click on module to ADD</a></li>
				<?php $_from = $this->_tpl_vars['category']['nonsubmenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['submenu']):
?>
					<li><a href="#" onclick="request('addfavorite-id-<?php echo $this->_tpl_vars['submenu']['module_id']; ?>
-cat-<?php echo $this->_tpl_vars['category']['category_id']; ?>
', 'mcat-<?php echo $this->_tpl_vars['category']['category_id']; ?>
', event);" title="Remove <?php echo $this->_tpl_vars['submenu']['module_name']; ?>
"><?php echo $this->_tpl_vars['submenu']['module_name']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			<a href="#" onclick="return false;" title="add module" style="font-size:1.2em;font-weight:bold;">+</a>
		</li>
		<li>
			<ul>
				<li><a href="#" onclick="return false;">Click on module to REMOVE</a></li>
				<?php $_from = $this->_tpl_vars['category']['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['submenu']):
?>
					<li><a href="#" onclick="request('removefavorite-id-<?php echo $this->_tpl_vars['submenu']['module_id']; ?>
-cat-<?php echo $this->_tpl_vars['category']['category_id']; ?>
', 'mcat-<?php echo $this->_tpl_vars['category']['category_id']; ?>
', event);" title="Remove <?php echo $this->_tpl_vars['submenu']['module_name']; ?>
"><?php echo $this->_tpl_vars['submenu']['module_name']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			<a href="#" onclick="return false;" title="remove" style="font-size:1.2em;font-weight:bold;">-</a>
		</li>
	</ul>
</div>
<div id="menu-<?php echo $this->_tpl_vars['category']['category_id']; ?>
" style="z-index:0;">
<?php $_from = $this->_tpl_vars['category']['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['submenu']):
?>
	<a href="#" onclick="return false;" id="a<?php echo $this->_tpl_vars['submenu']['module_id']; ?>
" class="submenu"><?php echo $this->_tpl_vars['submenu']['module_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>