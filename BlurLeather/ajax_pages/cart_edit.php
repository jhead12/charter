<?php require_once("../class/class.functions.php");
	$fn = new Functions();
	$pro = $fn->SelectQuery("select * from products where product_id='".$_GET['id']."'");
$pro = $pro[0];
$colors = $fn->SelectQuery("select * from product_color where product_id='".$pro['product_id']."'");
$gallery = $fn->selectQuery("select * from product_gallery where product_id='".$pro['product_id']."' and color_id='".$colors[0]['color_id']."'");

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("../includes/inc.header-scripts-ajax.php");?>
</head>
<body>
<?php include_once("../message.php");?>
<div class="full cart_section">
  <div class="full">
      <h2 class="text_capital"><?php echo $pro['product_title'] ?></h2>
    </div>
  <div class="left_section"> 
    <div class="full paddtop10"> 
    	<img id="galimg" src="<?php echo WEBSITE_URL."product_gallery/".$gallery[0]['product_id']."/".$gallery[0]['color_id']."/".$gallery[0]['img']?>" alt="" width="250" />
    </div>
    <div class="full">
    	<input value="Cancel" type="button" name="btn_submit" id="btn_submit">
    </div>
</div>
  <div class="right_section">
  		<div class="full">
        	<?php echo $fn->MakeHTML($pro['product_description'])?>
        </div>
    	<div class="rows"> 
        <span class="label">Colour</span>
        <ul class="select color">
          <?php if($colors){$i=0;foreach($colors as $color){?>
          <li<?php echo $i==0 ? ' class="selected"':''; ?> onclick="$('.color li').removeClass('selected');$(this).addClass('selected');$('#color_id').val('<?php echo $color['color_id'] ?>'); $('.size li').fadeOut(0).removeClass('selected');$('[data-rel=color-<?php echo $color['color_id']?>]').fadeIn(100); $('[data-rel=color-<?php echo $color['color_id']?>]:first').attr('class','selected');"> <a data-rel="<?php echo $color['color_id']?>" href="javascript:;" onclick="senddata('pro-gallery','product_id=<?php echo $color['product_id'];?>&color_id=<?php echo $color['color_id'] ?>','galleryid')" class="swatch" style="background:<?php echo $color['color_code'];?>;"><?php echo $color['color_title'];?></a>
            <div class="pdtooltip"><?php echo $color['color_title'];?></div>
          </li>
          <?php $i++;}}?>
          <input type="hidden" name="color_id" id="color_id" value="<?php echo $colors[0]['color_id']?>" />
        </ul>
      </div>
      <div class="rows"> 
      <span class="label">Size</span>
        <ul class="select size">
          <?php if($colors){$i=0; $j=0; foreach($colors as $color){ $sizes = explode(",",$color['size']); foreach($sizes as $s){?>
          <li<?php echo $j==0 ? ' class="selected"':''; echo $i!=0 ? ' style="display:none"':''; ?> onclick="$('.size li').removeClass('selected');$(this).addClass('selected');" title="<?php echo $s?>" data-rel="color-<?php echo $color['color_id']?>"><?php echo $s;?></li>
          <?php $j++;} $i++;} } ?>
        </ul>
      </div>
      <div class="rows">
      	<input value="Add Another One" type="button">
        <input value="Update Order" type="button">
      </div>
  </div>
</div>
</body>
</html>