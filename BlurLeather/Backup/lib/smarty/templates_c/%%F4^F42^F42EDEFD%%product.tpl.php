<?php /* Smarty version 2.6.13, created on 2008-06-16 09:11:48
         compiled from product.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'product.tpl', 19, false),array('modifier', 'nl2br', 'product.tpl', 29, false),)), $this); ?>
	  <table cellpadding="0" cellspacing="0">
	     <tr>
		   <td width="378" height="279" align="center" style="background-color:White;">
			<div style="background-image:url(<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['center_image']; ?>
&width=378&height=800);background-repeat:no-repeat;padding:0px;margin:0px;background-position:center;background-position:top;width:378px;height:279px;overflow:hidden;">
			   	<div id="dvsecond" style="position:absolute;display:none;width:378px;height:279px;background-image:url(<?php echo $this->_tpl_vars['productUrl']; ?>
/get_thumbs.php?im=<?php echo $this->_tpl_vars['product']['large_image']; ?>
&width=378&height=800);background-repeat:no-repeat:background-position:center;padding:0px;margin:0px;width:378px;height:279px;overflow:hidden;">
			   	<img pbsrc="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['large_image']; ?>
" src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/img.gif" style="cursor:pointer;" width="378" height="279" onclick="PopEx(this,null,null,478,380,50,'PopBoxImageLarge');" />
			   	</div>
			   	<img pbsrc="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['center_image']; ?>
" src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/img.gif" style="cursor:pointer;" width="378" height="279" onclick="PopEx(this,null,null,478,380,50,'PopBoxImageLarge');" />
		   	</div>
		   </td>
		   <td class="bg-white" width="10" valign="middle" align="center"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/arrow.gif" title="Show/Hide" onclick="if(document.getElementById('dvsecond').style.display=='') { new Fx.Style('dvsecond', 'opacity',{duration: 400, transition: Fx.Transitions.sineInOut, onComplete:function() { document.getElementById('dvsecond').style.display='none'; } }).start(1, 0); } else { document.getElementById('dvsecond').style.opacity=0;document.getElementById('dvsecond').style.display=''; new Fx.Style('dvsecond', 'opacity',{duration: 400, transition: Fx.Transitions.sineInOut}).start(0.2,1); } " /></td>
		   <td width="352" class="bg-white" align="left" valign="top" style="padding-left:10px;">
		     <table cellpadding="0" cellspacing="0" >
			   <tr>
			     <td width="342" height="10" colspan="2"></td>
			   </tr>

			   <tr>
			     <td  height="20" class="n-12black" colspan="2"><strong><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['product_name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</strong></td>
			   </tr>



			    <tr>
			     <td  height="5" colspan="2"></td>
			   </tr>

			   <tr>
			     <td  height="80" valign="top" colspan="2" class="n-11black"><div style="height:83px;overflow:hidden;"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['product']['description'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div></td>
			   </tr>

			    <tr>
			     <td  height="10" colspan="2"></td>
			   </tr>

			    <tr>
			     <td  height="20" colspan="2" valign="top" class="n-11black"><strong>Sizes : <?php echo ((is_array($_tmp=$this->_tpl_vars['product']['size'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</strong></td>
			   </tr>

			    <tr>
			     <td  height="5" colspan="2"></td>
			   </tr>

			    <tr>
			     <td   colspan="2" valign="top" class="n-11black"><strong>Available colors</strong></td>
			   </tr>

			    <tr>
			     <td   colspan="2" valign="middle"><span class="style1"><a class="link1" href="colorsize.html">See Colors / Sizes</a></span></td>
			   </tr>
 <tr>
			     <td  height="5" colspan="2"></td>
			   </tr>
			    <tr>
			     <td  height="60" colspan="2" valign="top">
			     <?php if ($this->_tpl_vars['product']['color1']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['color1']; ?>
" width="50" height="55" />&nbsp;&nbsp;<?php endif; ?>
			     <?php if ($this->_tpl_vars['product']['color2']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['color2']; ?>
" width="50" height="55" />&nbsp;&nbsp;<?php endif; ?>
			     <?php if ($this->_tpl_vars['product']['color3']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['color3']; ?>
" width="50" height="55" />&nbsp;&nbsp;<?php endif; ?>
			     <?php if ($this->_tpl_vars['product']['color4']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['color4']; ?>
" width="50" height="55" />&nbsp;&nbsp;<?php endif; ?>
			     <?php if ($this->_tpl_vars['product']['color5']): ?><img src="<?php echo $this->_tpl_vars['productUrl']; ?>
/<?php echo $this->_tpl_vars['product']['color5']; ?>
" width="50" height="55" />&nbsp;&nbsp;<?php endif; ?>
			     </td>
			   </tr>

			    <tr>
			     <td width="171"  height="29" valign="top"><?php if ($this->_tpl_vars['prevProduct']['product_id']): ?><a href="#"onclick="request('<?php echo $this->_tpl_vars['baseUrl']; ?>
/product.php?page=product_detail&id=<?php echo $this->_tpl_vars['prevProduct']['product_type_id']; ?>
&product_id=<?php echo $this->_tpl_vars['prevProduct']['product_id']; ?>
', 'content', event);"><img src="img/b-Prev.gif" width="116" height="29" border="0" /></a><?php endif; ?></td>
				 <td width="171" align="right"><?php if ($this->_tpl_vars['nextProduct']['product_id']): ?><a href="#"onclick="request('<?php echo $this->_tpl_vars['baseUrl']; ?>
/product.php?page=product_detail&id=<?php echo $this->_tpl_vars['nextProduct']['product_type_id']; ?>
&product_id=<?php echo $this->_tpl_vars['nextProduct']['product_id']; ?>
', 'content', event);"><img src="img/b-Next.gif" border="0" /></a><?php endif; ?></td>
			   </tr>

			 </table>
		   </td>

		   <td class="bg-white" width="10"></td>

		 </tr>
	  </table>
	  