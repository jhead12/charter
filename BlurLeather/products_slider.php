<?php require_once("class/class.functions.php"); $fn = new Functions();$fn->CurrentUrl();?>
<!DOCTYPE html>
<html class="js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB"><head>
<?php include_once("inc.head.php");?>
<title><?php echo COMPANY_NAME;?> | Products Slider</title>
</head>
<body class="resized">
<div id="container">
<?php include_once("inc.header.php");
	$sliders = $fn->SelectQuery("select * from banners where pre_category_id='".$_GET['pre_category_id']."' order by orderid");
?>
<div class="content visual landing">
  <div class="promoslideshow js_slideshow" data-timer="3500">
    <?php if($sliders){ $i=1;?> 
    		<?php foreach($sliders as $slider){?>
	      		<div class="item <?php echo $i==1?'active':'';?>"> 
                <a href="javascript:;" onClick="senddata('products','pre_category_id=<?php echo $_GET['pre_category_id'];?>&cat=<?php echo $slider['category_id']?>&sub=<?php echo $slider['sub_category_id']?>','products-list');"> <img class="scale" src="banners/<?php echo $slider['banner_image']?>" alt="<?php echo $slider['banner_title']?>" height="1080" width="1920"/> </a>
                <a href="javascript:;" onClick="senddata('products','pre_category_id=<?php echo $_GET['pre_category_id'];?>&cat=<?php echo $slider['category_id']?>&sub=<?php echo $slider['sub_category_id']?>','products-list');" class="entry">
                <h2 class="h3"><?php echo $slider['banner_title']?></h2>
                <h3 class="h0"><?php echo $slider['banner_sub_title']?></h3>
              </a>
                </div>
    	  <?php $i++; } ?>
      <?php } ?>
      <ul class="categorynav">
      	<?php if($_GET['pre_category_id']=='3' || $_GET['pre_category_id']=='2'){?>
        <li> <a href="<?php echo $_GET['pre_category_id']=='2'?'wo':'';?>mens-shop-look.php">Shop The Look</a></li>
        <?php }?>
		<?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id='".$_GET['pre_category_id']."' order by orderid")){foreach($cats as $cat){?>    
        <li<?php echo $_GET['cat']==$cat['category_id']? ' class="active"':''?>> <a href="javascript:;" onClick="senddata('products','pre_category_id=<?php echo $_GET['pre_category_id'];?>&cat=<?php echo $cat['category_id']?>','products-list');"><?php echo $cat['category_title'];?></a></li>
      <?php }}?>
	</ul>
      <ul class="contentpager">
        <li>Previous</li>
        <li>Next</li>
      </ul>
    </div>
  <div class="logo">Blur Leather</div>
</div>
  <div class="promodrawer js_promodrawer">
    <h6><span class="js_scroll">Show All</span></h6>
    <ul class="promos promo<?php echo count($sliders);?>">
      	<?php if($sliders){?> 
    		<?php foreach($sliders as $slider){?>
            
        <li style="background-image:url(banners/th_<?php echo $slider['banner_image']?>);">
          <a href="javascript:;" onClick="senddata('products','pre_category_id=<?php echo $_GET['pre_category_id'];?>&cat=<?php echo $slider['category_id']?>&sub=<?php echo $slider['sub_category_id']?>','products-list');">
            <div class="bar"><?php echo $slider['banner_title']?></div>
          </a>
        </li>
        <?php }}?>
    </ul>
  </div>
<div id="products-list"></div>
<div id="pro-detail"></div>
 <?php include_once("inc.footer.php");?>
</div>
</body></html>