<?php require_once("../class/class.functions.php"); $fn = new Functions();?>
<div class="content flexmain">
  <div class="sidebar">
    <ul class="categorynav">
    	<?php if($_POST['pre_category_id']=='3' || $_POST['pre_category_id']=='2'){?>
        <li> <a href="<?php echo $_POST['pre_category_id']=='2'?'wo':'';?>mens-shop-look.php">Shop The Look</a></li>
        <?php }?>
		<?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id='".$_POST['pre_category_id']."' order by orderid")){foreach($cats as $cat){?>
        <li<?php echo $_POST['cat']==$cat['category_id']? ' class="active"':''?>> <a href="<?php echo $fn->MakeLink($_POST['pre_category_id'],$cat['category_id'])?>"><?php echo $cat['category_title'];?></a>
      	<?php if($_POST['cat']==$cat['category_id']){
		  if($subs = $fn->SelectQuery("Select * from sub_category where category_id='".$cat['category_id']."' order by orderid")){?>
      	  <ul class="subnav">
      		<li <?php echo $_POST['sub']=='' ? ' class="active"':'';?>><a href="<?php echo $fn->MakeLink($_POST['pre_category_id'],$cat['category_id'])?>">All</a></li>
      		<?php foreach($subs as $sub){?>
         	<li <?php echo $_POST['sub']==$sub['sub_category_id'] ? ' class="active"':'';?>><a href="<?php echo $fn->MakeLink($_POST['pre_category_id'],$cat['category_id'],$sub['sub_category_id'])?>"><?php echo $sub['sub_category_title'];?></a></li>
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
        <li<?php echo $_POST['color']=='' ? ' class="selected"':'';?> onClick="senddata('products','pre_category_id=<?php echo $_POST['pre_category_id'];?>&cat=<?php echo $_POST['cat']?>&sub=<?php echo $_POST['sub']?>','products-list');">All</li>
        <?php foreach($colors as $color){?>
        <li<?php echo $_POST['color']==$color['family_id'] ? ' class="selected"':'';?> onClick="senddata('products','pre_category_id=<?php echo $_POST['pre_category_id'];?>&cat=<?php echo $_POST['cat']?>&sub=<?php echo $_POST['sub']?>&color=<?php echo $color['family_id']?>','products-list');"><?php echo $color['family_title'];?></li>
        <?php }?>
      </ol>
    </div>
  </div>
  <?php }?>

  </div>
  <div class="main">
    <ul class="products">
        <?php 
		$where ='';
		$where .= $fn->ReplaceSql($_POST['cat'])!='' ? " and category_id='".$fn->ReplaceSql($_POST['cat'])."'":'';
		$where .= $fn->ReplaceSql($_POST['color'])!='' ? " and product_id in (select product_id from product_color where family_id='".$fn->ReplaceSql($_POST['color'])."')":'';
		$where .= $fn->ReplaceSql($_POST['sub'])!='' ? " and sub_category_id='".$fn->ReplaceSql($_POST['sub'])."'":'';
		if($prods = $fn->SelectQuery("select * from products where pre_category_id='".$_POST['pre_category_id']."' {$where} order by orderid asc")){foreach($prods as $prod){?>
        <li class="">
        <a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $prod['product_id'];?>&pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>','pro-detail');">
        	<img src="products/<?php echo $prod['featured_image'];?>" alt="<?php echo $prod['product_title'];?>" height="325" width="212" />
        </a>
        <div class="info">
          <h3 class="h4">
             <a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $prod['product_id'];?>&pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>','pro-detail');"><?php echo $prod['product_title'];?></a>
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
  <div class="logo">Blur Leather</div>
  <?php if($prods){?>
  <span class="close" onclick="boxclose('products-list','container');">Close</span> 
  <?php } ?>
</div>