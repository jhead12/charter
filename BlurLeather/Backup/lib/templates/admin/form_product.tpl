{include file="form_error.tpl"}
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
    {if $result}<font color="Red">{$result}</font><br />{/if}
	  <table  cellpadding="0" cellspacing="0">
	     <tr>
		   <td height="20" colspan="5" ></td>

                </tr>

                <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="product_name"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">{input name="product_name"}</td>

                </tr>

                <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

                <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" valign="top" >&nbsp;</td>

                  <td width="150" align="left" valign="top" class="n-11putih" ><a class="n-bold-12"><strong>{label for="description"}</strong></a></td>

                  <td width="20" align="center" class="normal-11" valign="top"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">{input name="description"}</td>

                </tr>

                <tr>

                  <td height="10" colspan="5" ></td>

                </tr>
                
                <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="size"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">{input name="size"}</td>

                </tr>

                {*
 <tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>Size</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left" class="n-11putih">{input name="small_size"} {label for="small_size"} {input name="medium_size"} {label for="medium_size"} {input name="large_size"} {label for="large_size"}</td>
 </tr>
*}
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="color1"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  {if $product.color1}<img align="absmiddle" src="{$productUrl}/get_thumbs.php?im={$product.color1}&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="{$adminUrl}/index.php?action=deleteimage&im={$product.color1}">Remove</a><br />{/if}
                  {input name="color1"}{input name="MAX_FILE_SIZE"}</td>
 </tr>
 
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="color2"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  {if $product.color2}<img align="absmiddle" src="{$productUrl}/get_thumbs.php?im={$product.color2}&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="{$adminUrl}/index.php?action=deleteimage&im={$product.color2}">Remove</a><br />{/if}
                  {input name="color2"}</td>
 </tr>
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="color3"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  {if $product.color3}<img align="absmiddle" src="{$productUrl}/get_thumbs.php?im={$product.color3}&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="{$adminUrl}/index.php?action=deleteimage&im={$product.color3}">Remove</a><br />{/if}
                  {input name="color3"}</td>
 </tr>
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="color4"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  {if $product.color4}<img align="absmiddle" src="{$productUrl}/get_thumbs.php?im={$product.color4}&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="{$adminUrl}/index.php?action=deleteimage&im={$product.color4}">Remove</a><br />{/if}
                  {input name="color4"}</td>
 </tr>
 
 <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

<tr>

                  <td  width="20" height="25" ></td>

                  <td width="20"  align="left" >&nbsp;</td>

                  <td width="150" align="left" class="n-11white" ><a class="n-11putih"><strong>{label for="color5"}</strong></a></td>

                  <td width="20" align="center" class="normal-11"><a class="n-black-12"><strong>:</strong></a></td>

                  <td width="540" align="left">
                  {if $product.color5}<img align="absmiddle" src="{$productUrl}/get_thumbs.php?im={$product.color5}&width=50&height=60" alt="Generating thumb" /><a style="color:white" href="{$adminUrl}/index.php?action=deleteimage&im={$product.color5}">Remove</a><br />{/if}
                  {input name="color5"}
                  </td>
 </tr>
 

  <tr>

                  <td height="10" colspan="5" ></td>

                </tr>
<tr>

                  <td  height="25" ></td>

                  <td  align="left" valign="top" >&nbsp;</td>

                  <td  align="left" valign="top" class="n-11putih" ><a class="normal-11"><strong>{label for="center_image"} </strong></strong></a></td>

                  <td align="center" valign="top" width="20"><a class="normal-11"><strong>:</strong></a></td>

                  <td  align="left">

                    {if $product.center_image}<img src="{$productUrl}/get_thumbs.php?im={$product.center_image}&width=150&height=150" alt="Generating thumb" /><br />{/if}

                   {input name="center_image"}

                    <br /></td>

                </tr>
  <tr>

                  <td height="10" colspan="5" ></td>

                </tr>

                <tr>

                  <td  height="25" ></td>

                  <td  align="left" valign="top" >&nbsp;</td>

                  <td  align="left" valign="top" class="n-11putih" ><a class="normal-11"><strong>{label for="large_image"}</strong></strong></a></td>

                  <td align="center" valign="top" width="20"><a class="normal-11"><strong>:</strong></a></td>

                  <td  align="left">
                  {if $product.large_image}<img src="{$productUrl}/get_thumbs.php?im={$product.large_image}&width=150&height=150" alt="Generating thumb" /><br />{/if}

                    {input name="large_image"}

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

                  <td  align="left">{input name="doEntry"}
                    &nbsp;&nbsp;
                    <input type="reset" name="Submit2" value="Reset" class="tombol" ></td>
		 </tr>
	  </table>
	</td>
  </tr>
{input name="mode"}     
{input name="start_rec"}
{input name="page_size"}
{input name="product_type_id"}
{input name="product_id"}