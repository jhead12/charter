<?php require_once("../class/class.functions.php");
	$fn = new Functions();
	if(!isset($_SESSION['CART_PRODUCTS'])){
		$_SESSION['CART_PRODUCTS']=array();
	}
	if($_POST['action']=="deleteproduct"){
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
	}
	if($_POST['type']=="cart"){
	$i=0;
	$amt=0;
	if(count($_SESSION['CART_PRODUCTS'])>0){?>
    <h5 class="h3">Shopping Bag</h5>
        <ul id="miniproducts">
         <?php foreach($_SESSION['CART_PRODUCTS'] as $items){
			$items['price'] = $fn->GetRateAmt($items['price']);
			$amt += $items['qty'] * $items['price'];?>
          <li> <img src="<?php echo $items['img'];?>" alt="<?php echo $items['title'];?>" height="81" width="81">
            <h6> <a href="javascript:;"><?php echo $items['title'];?></a> </h6>
            <p class="price"><?php echo $fn->GetDisplayRate($items['price']);?></p>
            <span onclick="senddata('right-top-cart','action=deleteproduct&type=cart&cartid=<?php echo ($i);?>','minibasket');">Remove</span> 
          </li>
          <?php $i++;}?>
        </ul>
    <p class="total">Total: <?php echo $fn->GetDisplayRate($amt);?></p>
    <a class="button" href="cart.php">Checkout</a> 
    <?php } else{ ?>
	<center>YOUR SHOPPING BAG IS EMPTY.</center>
	<?php }
} ?>