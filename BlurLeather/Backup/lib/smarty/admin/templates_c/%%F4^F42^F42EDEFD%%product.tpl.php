<?php /* Smarty version 2.6.13, created on 2008-05-07 23:12:59
         compiled from product.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'product.tpl', 6, false),array('modifier', 'date_format', 'product.tpl', 31, false),)), $this); ?>
<!--submenu-->
<tr>
<td align="center" valign="top">
  <table  cellpadding="0" cellspacing="0">
     <tr>
	   <td width="750" height="25" align="left" class="N-14White"><?php echo ((is_array($_tmp=$this->_tpl_vars['curProductType']['category_name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
 : <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['curProductType']['product_type'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</strong></td>
	 </tr>
  </table>
</td>
</tr>
<!--center-->
<tr>
    <td align="center" valign="top">
	  <table  cellpadding="0" cellspacing="0">
	     <tr>
	     <?php if ($this->_tpl_vars['result']): ?><font color="Red"><?php echo $this->_tpl_vars['result']; ?>
</font><br /><?php endif; ?>
		   <td width="750"  valign="top" align="center">
		   <a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=addproduct&amp;id=<?php echo $this->_tpl_vars['curProductType']['product_type_id']; ?>
" title="Add Product" style="float:right;color:White;">Add Product</a><br />
		   <table  cellpadding="0" cellspacing="1"  class="bg-lightyellow" style="background-color:White;font-family:Verdana;">
              <tr class="bg-admintbltop" >
                <td width="30" height="25"  align="center" valign="middle" class="n-11putih" ><span class="normal-11"><strong><a >No.</a></strong></span></td>
                <td width="100" align="center" class="n-11putih"><a class="normal-11" ><strong>Posted</strong></a></td>
                <td  width="500" align="center" valign="middle" class="n-11putih" ><a class="normal-11" ><strong>Product Name</strong></a></td>
                <td  width="120" align="center" valign="middle" class="n-11putih" ><a class="normal-11" ><strong>Actions</strong></a></td>
              </tr>
              <?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fra'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fra']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['fra']['iteration']++;
?>
              <tr class="bg-white" <?php if (($this->_foreach['fra']['iteration']-1)%2 == 1): ?> style="background-color:#cacaca;"<?php endif; ?>>
                <td align="center"  height="30" valign="middle" class="n-11black"><a class="n-11coklat362f2d"><strong>
                <?php echo ($this->_foreach['fra']['iteration']-1)+1; ?>
</strong></a></td>
                <td align="center" class="n-11black"><a class="n-11coklat362f2d"><span class="n-11coklat362f2d">
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['product']['crdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%b %d, %Y") : smarty_modifier_date_format($_tmp, "%b %d, %Y")); ?>

                </span></a></td>
                <td align="left" valign="middle" class="n-11black"><a class="n-11coklat362f2d" style="padding-left:20px;">
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['product']['product_name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>

                  </a></td>
                <td align="center" valign="middle" class="n-11black"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/img-edit.gif" alt="Edit" align="absmiddle" border="0" /><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=editproduct&amp;id=<?php echo $this->_tpl_vars['product']['product_type_id']; ?>
&amp;product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
" class="linkblue11">Edit</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/img-delete.gif" alt="Delete" align="absmiddle" border="0" /><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=deleteproduct&amp;id=<?php echo $this->_tpl_vars['product']['product_type_id']; ?>
&amp;product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
" class="linkblue11">Delete</a></td>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="4" align="center">No Products for this category.</td>
              </tr>
              <?php endif; unset($_from); ?>
              <tr>
                <td colspan="4" height="3"></td>
              </tr>
              <tr>
              	<td colspan="4" align="center"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "paging.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
              </tr>
            </table>
		   </td>
		 </tr>
	  </table>
	  
	</td>
  </tr>