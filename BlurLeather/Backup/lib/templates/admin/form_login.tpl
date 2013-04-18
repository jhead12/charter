{include file="form_error.tpl"}
<table cellpadding="0" cellspacing="0" >
  <tr align="left">
    <td width="10" height="20"></td>
    <td width="30" align="center">&nbsp;</td>
    <td width="10"></td>
    <td width="100" class="n-11white"  ><a class="n-11putih" ><strong>{label for="username"}</strong></a></td>
    <td width="230" >{input name="username"}{if isset($verify.username)}{$mark}{/if}</td>
  </tr>
  <tr>
    <td width="360" height="10" colspan="5"></td>
  </tr>
  <tr align="left">
    <td height="20"></td>
    <td align="center"  >&nbsp;</td>
    <td ></td>
    <td class="n-11white"><a class="n-11putih" ><b>{label for="passwd"}</b></a></td>
    <td>{input name="passwd"}{if isset($verify.passwd)}{$mark}{/if}</td>
  </tr>
  <tr>
    <td width="360" height="10" colspan="5"></td>
  </tr>
  <tr align="left">
    <td  height="20"></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td >{input name="doEntry"}</td>
  </tr>
  <tr>
    <td width="360" height="5" colspan="5"></td>
  </tr>
</table>