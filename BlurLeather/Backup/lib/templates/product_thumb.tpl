<table cellpadding="0" cellspacing="0" border="0" width="770">
	<tr>
		<td valign="top" width="25" valign="middle">{if empty($prevLink) eq false}
		    <a href="#" onclick="request('{$prevLink.method}','pthumb', event);" title="Prev"><img src="{$baseUrl}/img/arrow-right.gif" border="0" /></a>
		{/if}&nbsp;</td>
		<td valign="top" width="740" align="center">
		<div style="overflow:hidden;margin:11px auto;width:680px;" id="holder">
{foreach item=product from=$products name=fra}
<div id="thumb{$product.product_id}" {if $smarty.foreach.fra.index eq 0}class="selthumb"{else}class="othumb"{/if} style="width:90px;height:83px;overflow:hidden;margin-left:3px;margin-right:3px;float:left;"><a href="#" onclick="request('{$baseUrl}/product.php?page=product_detail&id={$product.product_type_id}&product_id={$product.product_id}', 'content', event);"><img src="{$productUrl}/get_thumbs.php?im={$product.center_image}&width=90&height=76" width="90" height="76" title="{$product.product_name|stripslashes}" style="float:left" class="thumb" border="0" onclick=" changeSelect('thumb{$product.product_id}');" /></a></div>
{/foreach}
		</div>
		</td>
		<td valign="top" width="23" valign="middle">{if empty($nextLink) eq false}
		    <a href="#" onclick="request('{$nextLink.method}','pthumb', event);" title="Next"><img src="{$baseUrl}/img/arrow-left.gif" border="0" /></a>
		{/if}</td>
	</tr>
	</table>
<script language="javascript" type="text/javascript">
{literal}
function changeSelect(selid) {
	var holder = document.getElementById('holder');
	var thumbs = holder.childNodes;
	for(i= 0; i < thumbs.length; i++) {
		if(thumbs[i].id != selid) {
			thumbs[i].className = 'othumb';
		}
		else {
			thumbs[i].className = 'selthumb';
		}
	}
}
{/literal}
</script>