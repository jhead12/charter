<?php /* Smarty version 2.6.13, created on 2008-06-09 08:26:28
         compiled from form_product.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'formadddatapart', 'form_product.tpl', 1, false),array('insert', 'formaddlabelpart', 'form_product.tpl', 31, false),array('insert', 'formaddinputpart', 'form_product.tpl', 35, false),array('modifier', 'stripslashes', 'form_product.tpl', 7, false),)), $this); ?>
<?php ob_start();  $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form_error.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  ob_start(); ?>
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
    <?php if ($this->_tpl_vars['result']): ?><font color="Red"><?php echo $this->_tpl_vars['result']; ?>
</font><br /><?php endif; ?>
	  <table  cellpadding="0" cellspacing="0">
	     <tr>
		   <td height="20" colspan="5" ></td>

                </tr>

                <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'product_name', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left"><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'product_name', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>

                </tr>

                <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

                <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" valign="top" >&nbsp;</td>

                  <td width="150" align="left" valign="top" class="n-11putih" ><a class="n-bold-12"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'description', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11" valign="top"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left"><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'description', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>

                </tr>

                <tr>

                  <td height="10" colspan="5" ></td>

                </tr>
                
                <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'size', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left"><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'size', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>

                </tr>

                 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'color1', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  <?php if ($this->_tpl_vars['product']['color1']): ?><img align="absmiddle" src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['color1']; ?>
&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=deleteimage&im=<?php echo $this->_tpl_vars['product']['color1']; ?>
">Remove</a><br /><?php endif; ?>
                  <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'color1', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start();  $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'MAX_FILE_SIZE', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>
 </tr>
 
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'color2', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  <?php if ($this->_tpl_vars['product']['color2']): ?><img align="absmiddle" src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['color2']; ?>
&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=deleteimage&im=<?php echo $this->_tpl_vars['product']['color2']; ?>
">Remove</a><br /><?php endif; ?>
                  <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'color2', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>
 </tr>
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'color3', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  <?php if ($this->_tpl_vars['product']['color3']): ?><img align="absmiddle" src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['color3']; ?>
&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=deleteimage&im=<?php echo $this->_tpl_vars['product']['color3']; ?>
">Remove</a><br /><?php endif; ?>
                  <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'color3', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>
 </tr>
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'color4', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  <?php if ($this->_tpl_vars['product']['color4']): ?><img align="absmiddle" src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['color4']; ?>
&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=deleteimage&im=<?php echo $this->_tpl_vars['product']['color4']; ?>
">Remove</a><br /><?php endif; ?>
                  <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'color4', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></td>
 </tr>
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'color5', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?></strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  <?php if ($this->_tpl_vars['product']['color5']): ?><img align="absmiddle" src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['color5']; ?>
&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=deleteimage&im=<?php echo $this->_tpl_vars['product']['color5']; ?>
">Remove</a><br /><?php endif; ?>
                  <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'color5', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>
                  </td>
 </tr>
 

  <tr>

                  <td height="10" colspan="5" ></td>

                </tr>
<tr>

                  <td  height="25" ></td>

                  <td  align="left" valign="top" >&nbsp;</td>

                  <td  align="left" valign="top" class="n-11putih" ><a class="normal-11"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'center_image', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?> Pixel</strong></strong></a></td>

                  <td align="center" valign="top" width="20"><a class="normal-11"><strong>:</strong></a></td>

                  <td  align="left">

                    <?php if ($this->_tpl_vars['product']['center_image']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['center_image']; ?>
&width=150&height=150" alt="Generating thumb" /><br /><?php endif; ?>

                   <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'center_image', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>

                    <br /></td>

                </tr>
  <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

                <tr>

                  <td  height="25" ></td>

                  <td  align="left" valign="top" >&nbsp;</td>

                  <td  align="left" valign="top" class="n-11putih" ><a class="normal-11"><strong><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddlabelpart', 'for' => 'large_image', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?> Pixel</strong></strong></a></td>

                  <td align="center" valign="top" width="20"><a class="normal-11"><strong>:</strong></a></td>

                  <td  align="left">
                  <?php if ($this->_tpl_vars['product']['large_image']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['large_image']; ?>
&width=150&height=150" alt="Generating thumb" /><br /><?php endif; ?>

                    <?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'large_image', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>

                    <br /></td>
                </tr>

                <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

                <tr>

                  <td  height="25" ></td>

                  <td  align="left" valign="top" ></td>

                  <td  align="left" valign="top" class="n-11white" ></td>

                  <td align="center" valign="top" width="20"></td>

                  <td  align="left"><?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'doEntry', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>
                    &nbsp;&nbsp;
                    <input type="reset" name="Submit2" value="Reset" class="tombol" ></td>
		 </tr>
	  </table>
	</td>
  </tr>
<?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'mode', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>     
<?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'start_rec', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>
<?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'page_size', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>
<?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'product_type_id', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start(); ?>
<?php $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formaddinputpart', 'input' => 'product_id', 'data' => $this->_smarty_vars['capture']['formdata'])), $this);  ob_start();  $this->_smarty_vars['capture']['formdata'] = ob_get_contents(); ob_end_clean();  require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'formadddatapart', 'data' => $this->_smarty_vars['capture']['formdata'])), $this); ?>