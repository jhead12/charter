<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class=" js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title><?php echo COMPANY_NAME;?> | Shop Look</title>
<?php include_once("inc.head.php");?>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content flexmain">
    <div class="sidebar">
      <ul class="categorynav">
      	<li class="active"> <a href="<?php echo $_GET['pre_category_id']=='2'?'wo':'';?>mens-shop-look.php">Shop The Look</a></li>
         <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id='".$_GET['pre_category_id']."' order by orderid")){foreach($cats as $cat){?>
           		<li> <a href="<?php echo $_GET['pre_category_id']=='2'?'wo':'';?>menswears-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
            <?php }}?>
      </ul>
    </div>
    <div class="main">
      <ul class="products">
      	 <?php 
		if($looks = $fn->SelectQuery("select * from looks where pre_category_id='".$_GET['pre_category_id']."' order by orderid")){foreach($looks as $look){?>
        <li> <a href="javascript:;" onClick="senddata('shop-look-detail','id=<?php echo $look['look_id'];?>','shop-look-detail');"> 
        <img src="looks/th_<?php echo $look['featured_image'];?>" alt="<?php echo $look['look_title'];?>" height="479" width="212"> </a>
          <div class="info">
            <h3 class="h4"> <a href="javascript:;" onClick="senddata('shop-look-detail','id=<?php echo $look['look_id'];?>','shop-look-detail');" class="js_stack js_pageitem_link"><?php echo $look['look_title'];?></a> </h3>
            <span class="mymcqueen">Add to Blur</span> </div>
        </li>
        <?php }} ?>
      </ul>
    </div>
    <div class="logo">Blur Leather</div>
  </div>
  <div id="shop-look-detail"></div>
	<?php include_once("inc.footer.php");?>  
</div>
</body>
</html>