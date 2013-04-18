<?php require_once("class/class.functions.php"); $fn = new Functions();?>
<!DOCTYPE html>
<html class="js flexbox no-touch boxshadow opacity cssanimations csstransforms csstransforms3d csstransitions positionfixed fullscreen pointerevents mediaqueries" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<?php include_once("inc.head.php");?>
<style type="text/css" id="js_sizer_styles"></style>
<style type="text/css" id="js_slideshow_styles"></style>
<style type="text/css" id="js_scarves_styles"></style>
<title>Blur Leather</title>
</head>
<body class="resized">
<div id="container">
  <?php include_once("inc.header.php");?>
  <div class="content flexmain" data-stacktype="category" data-redirect="category:AA$Womenswear;category:AAD$Trousers &amp; Skirts" data-title="Womens Trousers &amp; Skirts | Alexander McQueen">
  
  <div class="sidebar">
    <ul class="categorynav">
		<?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=2 order by orderid")){foreach($cats as $cat){?>
        
        <li<?php echo $_GET['cat']==$cat['category_id']? ' class="active"':''?>> <a href="womenswear.php?cat=<?php echo $cat['category_id'];?>"><?php echo $cat['category_title'];?></a>
      	<?php if($_GET['cat']==$cat['category_id']){
		  if($subs = $fn->SelectQuery("Select * from sub_category where category_id='".$cat['category_id']."' order by orderid")){?>
      	  <ul class="subnav">
      		<li class="active"><a href="womenswear.php?cat=<?php echo $cat['category_id'];?>">All</a></li>
      		<?php foreach($subs as $sub){?>
         	<li><a href="womenswear.php?cat=<?php echo $sub['category_id'];?>&sub=<?php echo $sub['category_id'];?>"><?php echo $sub['sub_category_title'];?></a></li>
			<?php }?>
          </ul>
		<?php }}?>
      </li>
      <?php }}?>
	</ul>
  <?php if($colors = $fn->SelectQuery("Select * from color_family order by orderid")){?>  
  <div class="filters">
    <span class="disabled">Clear all filters</span>  
    <div class="open">
      <h6 class="js_filter">Color</h6>
      <ol class="filter rgbColourCode">
        <li class="selected js_stack" data-href="">All</li>
        <?php foreach($colors as $color){?>
        <li class="js_stack" data-href=""><?php echo $color['family_title'];?></li>
        <?php }?>
      </ol>
    </div>
  </div>
  <?php }?>

  </div>
  <div class="main">
    <ul class="products">
        <?php if($prods = $fn->SelectQuery("select * from products")){foreach($prods as $prod){?>
        <li class="">
        <a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $prod['product_id'];?>','pro-detail');">
        	<img src="products/<?php echo $prod['featured_image'];?>" alt="<?php echo $prod['product_title'];?>" height="325" width="212" />
        </a>
        <div class="info">
          <h3 class="h4">
             <a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $prod['product_id'];?>','pro-detail');"><?php echo $prod['product_title'];?></a>
              <div class="price">
                  <span itemprop="price"><?php echo $fn->GetDisplayRate($prod['product_price']);?></span>
              </div>
          </h3>
          <span class="mymcqueen">Add to My Blur</span>
        </div>
        </li>
      	<?php }}?>
    </ul>
  </div>
  <div class="logo">Alexander McQueen</div>
</div>
  <div id="pro-detail"></div>
  <?php include_once("inc.footer.php");?>
</div>
</body>
</html>