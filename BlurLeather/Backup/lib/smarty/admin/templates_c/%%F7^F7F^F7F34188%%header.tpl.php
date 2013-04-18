<?php /* Smarty version 2.6.13, created on 2008-06-19 12:15:17
         compiled from header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Blur Leather : <?php echo $this->_tpl_vars['title']; ?>
 :.</title>
<style type="text/css">
<!--  
    body, a, td, textarea {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        font-family:Verdana;font-size:0.9em;
    }
-->
</style>
<link href="<?php echo $this->_tpl_vars['baseUrl']; ?>
/style.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-black">
<table cellpadding="0" cellspacing="0" width="100%">
<!--top-->
 <tr>
   <td width="100%" height="19" class="bg-topline"></td>
 </tr>

  <tr>
    <td align="center"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/logoblurleather.png" vspace="10" /><br />
      <span class="n-11putih"><strong>Administrator</strong></span></td>
  </tr>

   <tr>
    <td align="center" height="25"><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;catId=1"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/<?php if ($this->_tpl_vars['curProductType']['category_id'] == 1): ?>b-admincurrent2.gif<?php else: ?>b-admincurrent.png<?php endif; ?>" alt="Current Collection" width="112" height="25" border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;catId=2"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/<?php if ($this->_tpl_vars['curProductType']['category_id'] == 2): ?>b-adminpastcollection1.gif<?php else: ?>b-adminpastcollection.png<?php endif; ?>" width="112" height="25" border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=logout"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminlogout.png" width="112" height="25" border="0" /></a></td>
  </tr>

   <!--submenu-->
  <tr>
    <td align="center" valign="top">
      <table  cellpadding="0" cellspacing="0">
      <?php if ($this->_tpl_vars['curProductType']['category_id'] == 1): ?>
         <tr>
           <td width="750" height="25" class="bg-white" align="center"><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=1"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminfallwinter08.png"  border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=2"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminmens.png" width="125" height="25" border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=3"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminwomens.png" width="125" height="25" border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=4"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminbags.png" width="125" height="25" border="0" /></a></td>
         </tr>
      <?php else: ?>
         <tr>
           <td width="750" height="25" class="bg-white" align="center"><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=5"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminmens.png" width="125" height="25" border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=6"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminwomens.png" width="125" height="25" border="0" /></a><a href="<?php echo $this->_tpl_vars['adminUrl']; ?>
/index.php?action=manageproduct&amp;id=7"><img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/img/b-adminbags.png" width="125" height="25" border="0" /></a></td>
         </tr>
      <?php endif; ?>
      </table>
    </td>
  </tr>
  
  