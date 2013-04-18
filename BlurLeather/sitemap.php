<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?> | Sitemap</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content sitemap">
    <h2 class="h1">Site Map</h2>
    <p class="text">Shop and Explore Blur Leather.</p>
    <ul class="smap">
      <li>
        <h3 class="h2"><a href="womenswear.php">Womenswear</a></h3>
        <ul>
            <li> <a href="womens-shop-look.php">Shop The Look</a></li>
            <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=2 order by orderid")){foreach($cats as $cat){?>
            <li> <a href="womenswears-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
            <?php }}?>
        </ul>
      </li>
      <li>
        <h3 class="h2"><a href="menswears.php">Menswear</a></h3>
        <ul>
        	 <li> <a href="mens-shop-look.php">Shop The Look</a></li>
            <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=3 order by orderid")){foreach($cats as $cat){?>
            <li> <a href="menswears-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
            <?php }}?>
        </ul>
      </li>
      <li>
        <h3 class="h2"><a href="scraf-boutiques.php">Scarf Boutique</a></h3>
        <ul>
            <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=4 order by orderid")){foreach($cats as $cat){?>
            <li> <a href="scraf-boutiques-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
            <?php }}?>
        </ul>
      </li>
      <li>
        <h3 class="h2"><a href="experience.php">Experience</a></h3>
        <ul>
	         <li><a href="biography.php">Biography</a></li>
        	<li><a href="philosophy.php">Our Philosphy</a></li>
            <li><a href="archives.php">Archives</a></li>
        </ul>
      </li>
      <li>
        <h3 class="h2"><a href="sales.php">SALE</a></h3>
        <ul>
            <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=5 order by orderid")){foreach($cats as $cat){?>
            <li> <a href="sales-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
            <?php }}?>
        </ul>
      </li>
    </ul>
    <div class="logo">Blur Leather</div>
  </div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>