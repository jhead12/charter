<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Blur Leather : {$title} :.</title>
<style type="text/css">
<!--  
    body, a, td, textarea {ldelim}
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        font-family:Verdana;font-size:0.9em;
    {rdelim}
-->
</style>
<link href="{$baseUrl}/style.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-black">
<table cellpadding="0" cellspacing="0" width="100%">
<!--top-->
 <tr>
   <td width="100%" height="19" class="bg-topline"></td>
 </tr>

  <tr>
    <td align="center"><img src="{$baseUrl}/img/logoblurleather.png" vspace="10" /><br />
      <span class="n-11putih"><strong>Administrator</strong></span></td>
  </tr>

   <tr>
    <td align="center" height="25"><a href="{$adminUrl}/index.php?action=manageproduct&amp;catId=1"><img src="{$baseUrl}/img/{if $curProductType.category_id eq 1}b-admincurrent2.gif{else}b-admincurrent.png{/if}" alt="Current Collection" width="112" height="25" border="0" /></a><a href="{$adminUrl}/index.php?action=manageproduct&amp;catId=2"><img src="{$baseUrl}/img/{if $curProductType.category_id eq 2}b-adminpastcollection1.gif{else}b-adminpastcollection.png{/if}" width="112" height="25" border="0" /></a><a href="{$adminUrl}/index.php?action=logout"><img src="{$baseUrl}/img/b-adminlogout.png" width="112" height="25" border="0" /></a></td>
  </tr>

   <!--submenu-->
  <tr>
    <td align="center" valign="top">
      <table  cellpadding="0" cellspacing="0">
      {if $curProductType.category_id eq 1}
         <tr>
           <td width="750" height="25" class="bg-white" align="center"><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=1"><img src="{$baseUrl}/img/b-adminfallwinter08.png"  border="0" /></a><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=2"><img src="{$baseUrl}/img/b-adminmens.png" width="125" height="25" border="0" /></a><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=3"><img src="{$baseUrl}/img/b-adminwomens.png" width="125" height="25" border="0" /></a><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=4"><img src="{$baseUrl}/img/b-adminbags.png" width="125" height="25" border="0" /></a></td>
         </tr>
      {else}
         <tr>
           <td width="750" height="25" class="bg-white" align="center"><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=5"><img src="{$baseUrl}/img/b-adminmens.png" width="125" height="25" border="0" /></a><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=6"><img src="{$baseUrl}/img/b-adminwomens.png" width="125" height="25" border="0" /></a><a href="{$adminUrl}/index.php?action=manageproduct&amp;id=7"><img src="{$baseUrl}/img/b-adminbags.png" width="125" height="25" border="0" /></a></td>
         </tr>
      {/if}
      </table>
    </td>
  </tr>
  
  