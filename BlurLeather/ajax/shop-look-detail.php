<?php require_once("../class/class.functions.php"); $fn = new Functions();
$looks = $fn->SelectQuery("select * from looks where look_id='".$_POST['id']."'");
$look = $looks[0];
$prods = $fn->SelectQuery("select p.*,lp.product_size from products as p inner join look_products as lp on p.product_id=lp.product_id where look_id='".$look['look_id']."'");
?>script|g|<div class="content flexmainleft look">
    <div class="sidebar lookov">
      <h2 class="h0"><?php echo $look['look_title'];?></h2>
      <p> <span class="mymcqueen">Add to Blur</span> </p>
      <?php if($prods){?>
      <ul class="productinfo">
        <?php 
		 $p = array();$s = array(); foreach($prods as $prod){ $p[] = $prod['product_id'];?>
        <li class="js_product">
          <h3 class="h5"> <a href="javascript:;"><?php echo $prod['product_title'];?></a>
            <div class="price js_price"><span itemprop="price"><?php echo $fn->GetDisplayRate($prod['product_price']);?></span></div>
          </h3>
          <select class="size" id="size_<?php echo $prod['product_id']?>" onchange="getsizes('.size','#sizes')">
          	<?php if($prod['product_size']!=''){ $sizes = explode(",",$prod['product_size']); $s[] = $sizes[0]; foreach($sizes as $size){?>
            <option value="<?php echo $size?>"><?php echo $size?></option>
            <?php }}?>
          </select>
          <span class="button primary" onclick="senddata('cart','action=addcartproduct&product_id=<?php echo $prod['product_id']?>&color_id=0&size='+$('#size_<?php echo $prod['product_id']?>').val(),'');senddata('right-top-cart','type=cart','minibasket');">Add to Bag</span> </li>
        <?php } ?>
      </ul>
      <input type="hidden" id="prods" value="<?php echo implode(",",$p);?>" />
      <input type="hidden" id="sizes" value="<?php echo implode(",",$s);?>" />
      <?php } ?>
      <span class="button secondary" onclick="senddata('cart','action=addcartproducts&product_id='+$('#prods').val()+'&size='+$('#sizes').val(),''); senddata('right-top-cart','type=cart','minibasket');">Add Look To Bag</span>
    </div>
    <div class="main">
    	<?php if($fn->ImageExists("looks",$look['featured_image'])){ 
					$getwh = getimagesize(UPLOAD_PATH_ORG."looks/".$look['featured_image']); 
			  list($w,$h) = $fn->GetRatio($getwh[0],$getwh[1],714,600);
			}
	  	?>
		<input type="hidden" name="x1" value="<?php echo (714-$w)/2;?>" id="x1">
		<input type="hidden" name="x2" value="<?php echo $w + ((714-$w)/2)?>" id="x2">
		<input type="hidden" name="y1" value="0" id="y1">
		<input type="hidden" name="y2" value="<?php echo $h?>" id="y2">
      <div class="lookimage"> 
      	<div class="large_pan" id="pan" style="position: relative; ">
        	<img id="galimg" src="<?php echo WEBSITE_URL."looks/".$look['featured_image']?>" alt="<?php echo WEBSITE_URL."looks/".$look['featured_image']?>"  style="position: absolute; top: 0px; left: 121px; cursor: move; width: 342px; height: 410px; overflow: hidden; " class="ui-draggable">
        </div>
        <ul class="zoomtools">
          <li class="zoomin" id="zoomin">Zoom in</li> <!--+-->
          <li class="zoomout" id="zoomout">Zoom out</li> <!---->
          <li class="fit" id="fit" href="javascript:;" title="Reset"><img src="images/arrow_out.png"></li>
        </ul>
      </div>
    </div>
    <ul class="contentpager">
      <?php if($prev = $fn->SelectQuery("Select look_id from looks where pre_category_id='".$look['pre_category_id']."' and orderid<".$look['orderid']." order by orderid,look_id desc limit 1")){?><li onclick="senddata('shop-look-detail','id=<?php echo $prev[0]['look_id'];?>','shop-look-detail');" >Previous</li><?php }else{?><li></li><?php }?>
      <?php if($next = $fn->SelectQuery("Select look_id from looks where pre_category_id='".$look['pre_category_id']."' and orderid>".$look['orderid']." order by orderid,look_id asc limit 1")){?><li onclick="senddata('shop-look-detail','id=<?php echo $next[0]['look_id'];?>','shop-look-detail');" >Previous</li><?php }else{?><li></li><?php }?>
    </ul>
    <div class="logo">Blur Leather</div>
    <span class="close" onclick="boxclose('shop-look-detail','container');">Close</span> </div>|g|zoom_fun();
