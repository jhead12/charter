<!--submenu-->
<tr>
<td align="center" valign="top">
  <table  cellpadding="0" cellspacing="0">
     <tr>
	   <td width="750" height="25" align="left" class="N-14White">{$curProductType.category_name|stripslashes} : <strong>{$curProductType.product_type|stripslashes}</strong></td>
	 </tr>
  </table>
</td>
</tr>
<!--center-->
<tr>
    <td align="center" valign="top">
	  <table  cellpadding="0" cellspacing="0">
	     <tr>
	     {if $result}<font color="Red">{$result}</font><br />{/if}
		   <td width="750"  valign="top" align="center">
		   <a href="{$adminUrl}/index.php?action=addproduct&amp;id={$curProductType.product_type_id}" title="Add Product" style="float:right;color:White;">Add Product</a><br />
		   <table  cellpadding="0" cellspacing="1"  class="bg-lightyellow" style="background-color:White;font-family:Verdana;">
              <tr class="bg-admintbltop" >
                <td width="30" height="25"  align="center" valign="middle" class="n-11putih" ><span class="normal-11"><strong><a >No.</a></strong></span></td>
                <td width="100" align="center" class="n-11putih"><a class="normal-11" ><strong>Posted</strong></a></td>
                <td  width="500" align="center" valign="middle" class="n-11putih" ><a class="normal-11" ><strong>Product Name</strong></a></td>
                <td  width="120" align="center" valign="middle" class="n-11putih" ><a class="normal-11" ><strong>Actions</strong></a></td>
              </tr>
              {foreach item=product from=$products name=fra}
              <tr class="bg-white" {if $smarty.foreach.fra.index%2 eq 1} style="background-color:#cacaca;"{/if}>
                <td align="center"  height="30" valign="middle" class="n-11black"><a class="n-11coklat362f2d"><strong>
                {$smarty.foreach.fra.index+1}</strong></a></td>
                <td align="center" class="n-11black"><a class="n-11coklat362f2d"><span class="n-11coklat362f2d">
                  {$product.crdate|date_format:"%b %d, %Y"}
                </span></a></td>
                <td align="left" valign="middle" class="n-11black"><a class="n-11coklat362f2d" style="padding-left:20px;">
                  {$product.product_name|stripslashes}
                  </a></td>
                <td align="center" valign="middle" class="n-11black"><img src="{$baseUrl}/img/img-edit.gif" alt="Edit" align="absmiddle" border="0" /><a href="{$adminUrl}/index.php?action=editproduct&amp;id={$product.product_type_id}&amp;product_id={$product.product_id}" class="linkblue11">Edit</a>&nbsp;&nbsp;&nbsp;<img src="{$baseUrl}/img/img-delete.gif" alt="Delete" align="absmiddle" border="0" /><a href="{$adminUrl}/index.php?action=deleteproduct&amp;id={$product.product_type_id}&amp;product_id={$product.product_id}" class="linkblue11">Delete</a></td>
              </tr>
              {foreachelse}
              <tr>
                <td colspan="4" align="center">No Products for this category.</td>
              </tr>
              {/foreach}
              <tr>
                <td colspan="4" height="3"></td>
              </tr>
              <tr>
              	<td colspan="4" align="center">{include file="paging.tpl"}</td>
              </tr>
            </table>
		   </td>
		 </tr>
	  </table>
	  
	</td>
  </tr>