<?php include_once("../class/class.admin.php"); 
	$obj = new Admin(); 
	$obj->RequireLogin(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<style>
@import url("css/fonts.css");
* {	outline:none;	font-family:"Droid Sans";}
body {	margin:0px;	padding:0px 5px 0px 0px;	font-family:"Droid Sans";	font-size:10pt;	background:#fff;	color:#1C1C1E;}
ul {	width:200px;	margin:0px;	padding:0px;	border:1px dashed #1C1C1E;	list-style:none;	float:left;}
ul ul {	border:none;	border-top:1px dashed #1C1C1E;display:none}
ul li {	width:100%;	margin:0px;	padding:0px;	list-style:none;	float:left;	border-bottom:1px dashed #1C1C1E;}
ul li a {	color:#1C1C1E;	width:90%;	margin:0px;	float:left;	padding:10px 5%;	text-decoration:none;	text-transform:uppercase; font-size:12px; font-weight:bold}
ul li ul li a {	color:#1C1C1E;	width:90%;	margin:0px;	float:left;	padding:10px 5%;	text-decoration:none;	text-transform:capitalize;font-size:13px; font-weight:normal}
ul li a:hover, ul li a.active, ul li a:active {	color:#fff;	background:#1C1C1E;}
ul li ul li a:hover, ul li ul li a.active, ul li ul li a:active {	color:#fff;	background:#1C1C1E;}
ul li:last-child {	border-bottom:none;}
</style>
<base target="des" />
<script src="js/jquery.ajax.js" type="text/javascript"></script>
</head>
<body>
<ul>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Home</a>
    <ul>
      <li><a href="home_banners.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Home Banners</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Women Section</a>
    <ul>
      <li><a href="category.php?pre_category_id=2" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Category</a></li>
      <li><a href="sub_category.php?pre_category_id=2" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Subcategory</a></li>
      <li><a href="banners.php?pre_category_id=2" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Womenswear Banners</a></li>
      <li><a href="products.php?pre_category_id=2" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Womenswear Products</a></li>
      <li><a href="looks.php?pre_category_id=2" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Womenswear Shop Look</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Men Section</a>
    <ul>
      <li><a href="category.php?pre_category_id=3" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Category</a></li>
      <li><a href="sub_category.php?pre_category_id=3" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Subcategory</a></li>
      <li><a href="banners.php?pre_category_id=3" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Menswear Banners</a></li>
      <li><a href="products.php?pre_category_id=3" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Menswear Products</a></li>
      <li><a href="looks.php?pre_category_id=3" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Menswear Shop Look</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Scarf Boutique</a>
    <ul>
      <li><a href="category.php?pre_category_id=4" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Category</a></li>
      <li><a href="sub_category.php?pre_category_id=4" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Subcategory</a></li>
      <li><a href="banners.php?pre_category_id=4" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Scarf Banners</a></li>
      <li><a href="products.php?pre_category_id=4" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo;Scarf Products</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Experience</a>
    <ul>
      <li><a href="biography.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Biography</a></li>
      <li><a href="philosophy.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Philosophy</a></li>
      <li><a href="archives.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Archives</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Sale Section</a>
    <ul>
      <li><a href="category.php?pre_category_id=5" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Category</a></li>
      <li><a href="sub_category.php?pre_category_id=5" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Subcategory</a></li>
      <li><a href="banners.php?pre_category_id=5" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Sale Banners</a></li>
      <li><a href="products.php?pre_category_id=5" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Sale Products</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Member & Orders</a>
    <ul>
      <li><a href="members.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Members</a></li>
      <li><a href="orders.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Orders</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Content</a>
    <ul>
      <li><a href="privacy_policy.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Privacy Policy</a></li>
      <li><a href="company_info.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Company Info</a></li>
      <li><a href="country.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Countries</a></li>
      <li><a href="store_locator.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Store Locator</a></li>
      <li><a href="shipping_packing.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Shipping & Packing</a></li>
      <li><a href="content.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Content</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Manage Contacts</a>
    <ul>
      <li><a href="contacts.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Contact List</a></li>
    </ul>
  </li>
  <li><a href="javascript:;" onclick="$(this).next('ul').slideToggle(500); $(this).toggleClass('active');" class="arrow">Website Settings</a>
    <ul>
   	<li><a href="color_family.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Color Family</a></li>
      <li><a href="website-logo.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Top Logo</a></li>
      <li><a href="mail_settings.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Mail Settings</a></li>
      <li><a href="social_links.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Social Links</a></li>
      <li><a href="change_password.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Change Your Password</a></li>
      <li><a href="subscribes.php" onclick="$('[rel=sublink]').removeClass('active');$(this).addClass('active');" rel="sublink">&raquo; Manage Subscriptions</a></li>
    </ul>
  </li>
</ul>
</body>
</html>