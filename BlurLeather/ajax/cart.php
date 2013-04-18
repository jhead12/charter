<?php require_once("../class/class.functions.php");
	$fn = new Functions();
	if(!isset($_SESSION['CART_PRODUCTS'])){
		$_SESSION['CART_PRODUCTS']=array();
	}
	if(!isset($_SESSION['CART_CHARGES'])){
		$_SESSION['CART_CHARGES']=array();
	}
	if($_POST['action']=="addcartproduct"){
		$query="select p.*,c.color_title,c.color_id from products p left outer join product_color c on p.product_id = c.product_id and c.color_id = ".$_POST['color_id']." where p.product_id='".$fn->ReplaceSql($_POST['product_id'])."'";
		$dbcart=$fn->SelectQuery($query);
		$dbcart=$dbcart[0];
		$custids = array();
		$camt=0;
		
		$cart=array(
			"productid"=>$dbcart['product_id'],
			"title"=>$dbcart['product_title'],
			"img"=>WEBSITE_URL."products/".$dbcart['featured_image'],
			"price"=>$dbcart['product_price'],
			"colorid"=>$dbcart['color_id'],
			"colortitle"=>$dbcart['color_title'],
			"size"=>$_POST['size'],
			"qty"=>1
		);		
		array_push($_SESSION['CART_PRODUCTS'],$cart);
		echo "script|g||g|$('#basketcounter').find('span').html('(".count($_SESSION['CART_PRODUCTS']).")');";
	}elseif($_POST['action']=="addcartproducts"){
		$prods = explode(",",$_POST['product_id']);
		$sizes = explode(",",$_POST['size']);
		for($i=0;$i<count($prods);$i++){
			$dbcart=$fn->SelectQuery($query="select * from products where product_id='".$fn->ReplaceSql($prods[$i])."'");
			$dbcart=$dbcart[0];
			$custids = array();
			$camt=0;
			$cart=array(
				"productid"=>$dbcart['product_id'],
				"title"=>$dbcart['product_title'],
				"img"=>WEBSITE_URL."products/".$dbcart['featured_image'],
				"price"=>$dbcart['product_price'],
				"colorid"=>$dbcart['color_id'],
				"colortitle"=>$dbcart['color_title'],
				"size"=>$fn->ReplaceSql($sizes[$i]),
				"qty"=>1
			);		
			array_push($_SESSION['CART_PRODUCTS'],$cart);
		}
	}elseif($_POST['action']=="deleteproduct"){
		$i=0;
		$amt=0;
		$temparray=array();
		foreach($_SESSION['CART_PRODUCTS'] as $items){
			if($i!=$_POST['cartid']){
				array_push($temparray,$_SESSION['CART_PRODUCTS'][$i]);
			}
			$i++;
		}
		$_SESSION['CART_PRODUCTS']=$temparray;
	}elseif($_POST['action']=="update"){
		foreach($_SESSION['CART_PRODUCTS'] as $items){
			$_SESSION['CART_PRODUCTS'][$_POST['cartid']]['size']=$_POST['size'];
			$_SESSION['CART_PRODUCTS'][$_POST['cartid']]['colorid']=$_POST['colorid'];
			$_SESSION['CART_PRODUCTS'][$_POST['cartid']]['colortitle']=$_POST['colortitle'];
		}
	}elseif($_POST['action']=="updatecharges"){
		if($chr = $fn->SelectQuery("select * from shipping_charge where charge_id='".$_POST['id']."'")){
			$_SESSION['CART_CHARGES']['chargeid']=$chr[0]['charge_id'];
			$_SESSION['CART_CHARGES']['title']=$chr[0]['charge_title'];
			$_SESSION['CART_CHARGES']['amount']=$chr[0]['charge_price'];
			$_SESSION['CART_CHARGES']['text']=$chr[0]['charge_desc'];
			$_SESSION['CART_CHARGES']['tax']=$chr[0]['tax'];	 
		}
	}
	if($_POST['type']=="cart"){
	$i=0;
	$amt=0;
	if(count($_SESSION['CART_PRODUCTS'])>0){?>
    <div class="buttonbar"> <a href="index.php"><span class="button secondary">Continue Shopping</span></a>
      <a class="button primary" href="checkout.php"><span>Checkout Securely</span></a> </div>
    <table id="basket">
    <colgroup>
        <col style="width:85px">
        <col style="width:300px">
        <col style="width:200px">
        <col style="width:165px">
        <col style="width:150px">
    </colgroup>
    <thead>
      <tr>
        <th colspan="2">Product</th>
        <th>Colour &amp; Size </th>
        <th>Quantity</th>
        <th class="price">Subtotal</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($_SESSION['CART_PRODUCTS'] as $items){
	$items['price'] = $fn->GetRateAmt($items['price']);
	$amt += $items['qty'] * $items['price'];
	?>
    <tr>
    <td><a href="javascript:;"  onClick="senddata('pro-detail','id=<?php echo $items['productid'];?>','pro-detail');"><img src="<?php echo $items['img'];?>" alt="<?php echo $items['title'];?>" height="81" width="81"></a></td>
    <td class="prdct"><h6> <a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $items['productid'];?>','pro-detail');"><span>Blur Leather</span><?php echo $items['title'];?></a> </h6>
      <?php /*?><span class="js_mymq_add"><a href="ajax_pages/cart_edit.php?cartid=<?php echo ($i);?>" rel="superbox[iframe][622x410]">Edit item</a></span><?php */?> <span onclick="senddata('wishlist','action=addproduct&product_id=<?php echo $items['productid']?>&color_id=<?php echo $items['colorid']?>&size=<?php echo $items['size']?>','');">Add to My Blur</span></td>
    <td><a href="javascript:;" rel="superbox[iframe][622x410]"><?php echo $items['colortitle']." ".$items['size']?></a></td>
    <td class="qty">1<br>
      <span onclick="senddata('cart','action=deleteproduct&type=cart&cartid=<?php echo ($i);?>','basket'); senddata('right-top-cart','type=cart','minibasket');">Remove</span></td>
    <td class="price"><?php echo $fn->GetDisplayRate($items['price']);?></td>
  </tr>
	<?php $i++;}?>
    </tbody>
    <tfoot>
    	<tr class="total">
			<td colspan="5" />
           </tr> 
          <?php if($shippings = $fn->SelectQuery("select * from shippings")){ foreach($shippings as $ship){?>
          <tr class="summary marketing">
            <td colspan="3" rowspan="3"><div class="promo"> <img src="shippings/<?php echo $ship['shipping_image']?>" height="86" width="88">
                <h6 class="h2"><?php echo $ship['shipping_title'];?></h6>
                <p><?php echo $ship['shipping_desc'];?></p>
              </div></td>
            <td>Item Totals</td>
            <td class="price"><?php echo $fn->GetDisplayRate($amt);?></td>
          </tr>
          <tr class="summary taxcalc">
            <td> tax (VAT) </td>
            <td class="price"><?php echo $fn->GetDisplayRate($ship['tax']);?></td>
          </tr>
          <tr class="summary shipping">
            <td>
                <select id="charge_<?php echo $ship['shipping_id'];?>" onchange="senddata('cart','type=cart&action=updatecharges&id='+this.value,'basket');">
                  <?php if($shipping_charge = $fn->SelectQuery("select * from shipping_charge where shipping_id='".$ship['shipping_id']."'")){ foreach($shipping_charge as $chr){
					  if(!isset($_SESSION['CART_CHARGES']['chargeid'])){
						$_SESSION['CART_CHARGES']['chargeid']=$chr['charge_id'];
						$_SESSION['CART_CHARGES']['title']=$chr['charge_title'];
						$_SESSION['CART_CHARGES']['amount']=$chr['charge_price'];
						$_SESSION['CART_CHARGES']['text']=$chr['charge_desc'];
						$_SESSION['CART_CHARGES']['tax']=$chr['tax'];	 
					  }
					   ?>
                  <option value="<?php echo $chr['charge_id']?>" <?php echo $_SESSION['CART_CHARGES']['chargeid']==$chr['charge_id'] ? 'selected="selected"':''?> data-rel="<?php echo $chr['charge_desc']?>"><?php echo $chr['charge_title']?></option>
                  <?php }}?>
                </select>
                <div><?php echo $_SESSION['CART_CHARGES']['text'];?></div>
               </td>
            <td class="price"><?php echo $fn->GetDisplayRate($_SESSION['CART_CHARGES']['amount']);?></td>
          </tr>
          <?php }}?>
          <tr class="grand">
            <td colspan="3">&nbsp;</td>
            <td>grand total</td>
           	<td class="price"><?php echo $fn->GetDisplayRate($amt+$_SESSION['CART_CHARGES']['amount']+$_SESSION['CART_CHARGES']['tax']);?></td>
          </tr>
        </tfoot>
       </table>
      <div class="buttonbar"> <a href="index.php"><span class="button secondary">Continue Shopping</span></a> <a class="button primary" href="checkout.php"><span>Checkout Securely</span></a> </div>  
	<?php  
	 $_SESSION['PRODUCT_AMOUNT'] = $amt;
	 } 
	} if(count($_SESSION['CART_PRODUCTS'])==0){?>
		<div class="buttonbar"> <a href="index.php"><span class="button secondary">Continue Shopping</span></a></div>
        <div id="empty">
          <h3 class="h2">Your Shopping Bag is empty.</h3>
          <p>You have currently no items in your basket.</p>
        </div>
<?php }?>