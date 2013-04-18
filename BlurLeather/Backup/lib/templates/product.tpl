	  <table cellpadding="0" cellspacing="0">
	     <tr>
		   <td width="378" height="279" align="center" style="background-color:White;">
			<div style="background-image:url({$productUrl}/get_thumbs.php?im={$product.center_image}&width=378&height=800);background-repeat:no-repeat;padding:0px;margin:0px;background-position:center;background-position:top;width:378px;height:279px;overflow:hidden;">
			   	<div id="dvsecond" style="position:absolute;display:none;width:378px;height:279px;background-image:url({$productUrl}/get_thumbs.php?im={$product.large_image}&width=378&height=800);background-repeat:no-repeat:background-position:center;padding:0px;margin:0px;width:378px;height:279px;overflow:hidden;">
			   	<img pbsrc="{$productUrl}/{$product.large_image}" src="{$baseUrl}/img/img.gif" style="cursor:pointer;" width="378" height="279" onclick="PopEx(this,null,null,478,380,50,'PopBoxImageLarge');" />
			   	</div>
			   	<img pbsrc="{$productUrl}/{$product.center_image}" src="{$baseUrl}/img/img.gif" style="cursor:pointer;" width="378" height="279" onclick="PopEx(this,null,null,478,380,50,'PopBoxImageLarge');" />
		   	</div>
		   </td>
		   <td class="bg-white" width="10" valign="middle" align="center"><img src="{$baseUrl}/img/arrow.gif" title="Show/Hide" onclick="if(document.getElementById('dvsecond').style.display=='') {ldelim} new Fx.Style('dvsecond', 'opacity',{ldelim}duration: 400, transition: Fx.Transitions.sineInOut, onComplete:function() {ldelim} document.getElementById('dvsecond').style.display='none'; {rdelim} {rdelim}).start(1, 0); {rdelim} else {ldelim} document.getElementById('dvsecond').style.opacity=0;document.getElementById('dvsecond').style.display=''; new Fx.Style('dvsecond', 'opacity',{ldelim}duration: 400, transition: Fx.Transitions.sineInOut{rdelim}).start(0.2,1); {rdelim} " /></td>
		   <td width="352" class="bg-white" align="left" valign="top" style="padding-left:10px;">
		     <table cellpadding="0" cellspacing="0" >
			   <tr>
			     <td width="342" height="10" colspan="2"></td>
			   </tr>

			   <tr>
			     <td  height="20" class="n-12black" colspan="2"><strong>{$product.product_name|stripslashes}</strong></td>
			   </tr>



			    <tr>
			     <td  height="5" colspan="2"></td>
			   </tr>

			   <tr>
			     <td  height="80" valign="top" colspan="2" class="n-11black"><div style="height:83px;overflow:hidden;">{$product.description|stripslashes|nl2br}</div></td>
			   </tr>

			    <tr>
			     <td  height="10" colspan="2"></td>
			   </tr>

			    <tr>
			     <td  height="20" colspan="2" valign="top" class="n-11black"><strong>Sizes : {$product.size|stripslashes}{*if $product.small_size}Small{/if}{if $product.small_size and $product.medium_size}, Medium{elseif $product.medium_size}Medium{/if}{if $product.medium_size or $product.small_size and $product.large_size}, Large{elseif $product.large_size}Large{/if*}</strong></td>
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
			     {if $product.color1}<img src="{$productUrl}/{$product.color1}" width="50" height="55" />&nbsp;&nbsp;{/if}
			     {if $product.color2}<img src="{$productUrl}/{$product.color2}" width="50" height="55" />&nbsp;&nbsp;{/if}
			     {if $product.color3}<img src="{$productUrl}/{$product.color3}" width="50" height="55" />&nbsp;&nbsp;{/if}
			     {if $product.color4}<img src="{$productUrl}/{$product.color4}" width="50" height="55" />&nbsp;&nbsp;{/if}
			     {if $product.color5}<img src="{$productUrl}/{$product.color5}" width="50" height="55" />&nbsp;&nbsp;{/if}
			     </td>
			   </tr>

			    <tr>
			     <td width="171"  height="29" valign="top">{if $prevProduct.product_id}<a href="#"onclick="request('{$baseUrl}/product.php?page=product_detail&id={$prevProduct.product_type_id}&product_id={$prevProduct.product_id}', 'content', event);"><img src="img/b-Prev.gif" width="116" height="29" border="0" /></a>{/if}</td>
				 <td width="171" align="right">{if $nextProduct.product_id}<a href="#"onclick="request('{$baseUrl}/product.php?page=product_detail&id={$nextProduct.product_type_id}&product_id={$nextProduct.product_id}', 'content', event);"><img src="img/b-Next.gif" border="0" /></a>{/if}</td>
			   </tr>

			 </table>
		   </td>

		   <td class="bg-white" width="10"></td>

		 </tr>
	  </table>
	  