<?php require_once("../class/class.functions.php"); $fn = new Functions();
$pro = $fn->SelectQuery("select * from products where product_id='".$_POST['id']."'");
$pro = $pro[0];
$colors = $fn->SelectQuery("select * from product_color where product_id='".$pro['product_id']."'");
$gallery = $fn->selectQuery("select * from product_gallery where product_id='".$pro['product_id']."' and color_id='".$colors[0]['color_id']."'");
?>
script|g|
<div class="content flex2col">
  <div class="col" id="galleryid">
    <?php 
	if($fn->ImageExists("product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id'],$gallery[0]['img'])){
		$getwh = getimagesize(UPLOAD_PATH_ORG."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']); 
  		list($w,$h) = $fn->GetRatio($getwh[0],$getwh[1],514,410);
	}
  ?>
    <input type="hidden" name="x1" value="<?php echo (514-$w)/2;?>" id="x1">
    <input type="hidden" name="x2" value="<?php echo $w + ((514-$w)/2)?>" id="x2">
    <input type="hidden" name="y1" value="0" id="y1">
    <input type="hidden" name="y2" value="<?php echo $h?>" id="y2">
    <div class="pdimage">
      <div class="pan" id="pan"> <img id="galimg" src="<?php echo WEBSITE_URL."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']?>" alt="<?php echo WEBSITE_URL."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']?>" /> </div>
      <ul class="zoomtools">
        <li class="zoomin" id="zoomin">Zoom in</li>
        <li class="zoomout" id="zoomout">Zoom out</li>
        <li class="full" onclick="superopen('<?php echo WEBSITE_URL."ajax_pages/pro_gallery_images.php?product_id=".$gallery[0]['product_id']."&color_id=".$gallery[0]['color_id'];?>&image='+$('#galimg').attr('src')+'&width='+($(window).width()-70)+'&height='+($(window).height()-100),$(window).width()-70,$(window).height()-100);">Fullscreen</li>
      </ul>
      <div class="carousel">
        <div class="frame">
          <ul id="gallery_images">
            <?php if($gallery){ foreach($gallery as $img){?>
            <li onclick="$('#galimg').attr('src','<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/".$img['img']?>');"><img src="<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/th_".$img['img']?>" alt="<?php echo WEBSITE_URL."product_gallery/".$img['product_id']."/".$img['color_id']."/th_".$img['img']?>" height="81" width="81"></li>
            <?php }}?>
          </ul>
        </div>
        <span id="prev1" class="prev">Previous</span> <span id="next1" class="next">Next</span> </div>
    </div>
  </div>
  <div class="col">
    <div class="pdinfo">
      <h2 class="h1" itemprop="name"><?php echo $pro['product_title'] ?></h2>
      <h3 class="h2">New Season</h3>
      <div class="price"><span itemprop="price"><?php echo $fn->GetDisplayRate($pro['product_price']) ?></span></div>
      <ul class="tabbox js_tab">
        <li class="active">
          <h6 class="h">Description</h6>
          <div class="c"><?php echo $fn->MakeHTML($pro['product_description'])?></div>
        </li>
        <li>
          <h6 class="h">Delivery</h6>
          <div class="c"><?php echo $fn->MakeHTML($pro['delivery'])?></div>
        </li>
        <li>
          <h6 class="h">Return Policy</h6>
          <div class="c"><?php echo $fn->MakeHTML($pro['return_policy'])?></div>
        </li>
      </ul>
      <p>Need more help? <a href="ajax_pages/contact_us.php" onclick="superopen('ajax_pages/contact_us.php',930,550); return false;">Contact us</a></p>
      <p>- "Please note that every skin has its own characteristics that may include stains, bruises, and scratches, as its a natural product. Every product has its own look and character that differs from the other. This ensures the owner of having a truly unique one of a kind piece"</p>
      <div class="formrow"> <span class="label">Colour</span>
        <ul class="select color">
          <?php if($colors){$i=0;foreach($colors as $color){?>
          <li<?php echo $i==0 ? ' class="selected"':''; ?> onclick="$('.color li').removeClass('selected');$(this).addClass('selected');$('#color_id').val('<?php echo $color['color_id'] ?>'); $('.size li').fadeOut(0).removeClass('selected');$('[data-rel=color-<?php echo $color['color_id']?>]').fadeIn(100); $('[data-rel=color-<?php echo $color['color_id']?>]:first').attr('class','selected');"> <a data-rel="<?php echo $color['color_id']?>" href="javascript:;" onclick="senddata('pro-gallery','product_id=<?php echo $color['product_id'];?>&color_id=<?php echo $color['color_id'] ?>','galleryid')" class="swatch" style="background:<?php echo $color['color_code'];?>;"><?php echo $color['color_title'];?></a>
            <div class="pdtooltip"><?php echo $color['color_title'];?></div>
          </li>
          <?php $i++;}}?>
          <input type="hidden" name="color_id" id="color_id" value="<?php echo $colors[0]['color_id']?>" />
        </ul>
      </div>
      <div class="formrow"> <span class="label">Size</span>
        <ul class="select size">
          <?php if($colors){$i=0; $j=0; foreach($colors as $color){ $sizes = explode(",",$color['size']); foreach($sizes as $s){?>
          <li<?php echo $j==0 ? ' class="selected"':''; echo $i!=0 ? ' style="display:none"':''; ?> onclick="$('.size li').removeClass('selected');$(this).addClass('selected');" title="<?php echo $s?>" data-rel="color-<?php echo $color['color_id']?>"><?php echo $s;?></li>
          <?php $j++;} $i++;} } ?>
        </ul>
      </div>
      <div class="buttonbar"> <span class="button primary" onclick="senddata('cart','action=addcartproduct&product_id=<?php echo $pro['product_id']?>&color_id='+$('#color_id').val()+'&size='+$('.size .selected').attr('title'),'');senddata('right-top-cart','type=cart','minibasket');">Add to Bag</span> <span class="button secondary" onclick="senddata('wishlist','action=addproduct&product_id=<?php echo $pro['product_id']?>&color_id='+$('#color_id').val()+'&size='+$('.size .selected').attr('title'),'');">Add to Blur</span> </div>
      <?php if($wears = $fn->SelectQuery("select * from products where product_id in (select distinct lp2.product_id from look_products lp1 inner join look_products lp2 on lp1.look_id=lp2.look_id where lp1.product_id='".$pro['product_id']."') and product_id!='".$pro['product_id']."'")){?>
      <h4 class="h3">Wear with</h4>
      <div class="carousel js_carousel">
        <div class="frame">
          <ul class="js_list" id="wear_it_with">
            <?php foreach($wears as $wear){?>
            <li onclick=""><a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $wear['product_id'];?>&pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>','pro-detail');"> <img src="products/<?php echo $wear['featured_image'];?>" alt="<?php echo $wear['product_title'];?>" height="81" width="81" /> </a></li>
            <?php }?>
          </ul>
        </div>
        <span class="prev" id="prev2">Previous</span> <span id="next2" class="next">Next</span> </div>
      <?php }?>
    </div>
  </div>
  <ul class="contentpager">
    <?php 
	if($prev = $fn->SelectQuery("Select product_id from products where category_id='".$pro['category_id']."' and orderid<".$pro['orderid']." order by orderid,product_id desc limit 1")){?>
    <li onclick="senddata('pro-detail','id=<?php echo $prev[0]['product_id'];?>&pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>','pro-detail');">Previous</li>
    <?php }else{?>
    <li></li>
    <?php }?>
    <?php if($next = $fn->SelectQuery("Select product_id from products where category_id='".$pro['category_id']."' and orderid>".$pro['orderid']." order by orderid,product_id asc limit 1")){?>
    <li onclick="senddata('pro-detail','id=<?php echo $next[0]['product_id'];?>&pre_category_id=<?php echo $_REQUEST['pre_category_id'];?>','pro-detail');">Next</li>
    <?php }else{?>
    <li></li>
    <?php }
	?>
  </ul>
  <div class="logo">Blur Leather</div>
  <span class="close" onclick="boxclose('pro-detail','products-list');">Close</span> </div>
<div class="promodrawer js_promodrawer">
  <h6><span class="js_scroll">More about this product</span></h6>
 	<?php if($sliders = $fn->SelectQuery("select * from product_banners where pre_category_id='".$_REQUEST['pre_category_id']."' order by orderid limit 0,2")){?>
  <ul class="promos promo2">
		<?php foreach($sliders as $slider){?>
            <li style="background-image:url(product_banners/<?php echo $slider['banner_image']?>);"> 
                <a <?php echo $slider['banner_video_url']!=''?'href="'.$slider['banner_video_url'].'"':''?>>
                <div>
                <h6 class="h1"><?php echo $slider['banner_title']?></h6>
                <span>View Collection</span> </div>
              </a> 
            </li>
      <?php } ?>
  </ul>
      <?php } ?>
</div>
|g|zoom_fun(); 