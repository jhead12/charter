<?php require_once("../class/class.functions.php");
	$fn = new Functions();
	if(!isset($_SESSION['WISHLIST_PRODUCTS'])){
		$_SESSION['WISHLIST_PRODUCTS']=array();
	}
	if($_POST['action']=="addproduct"){ 
		$query="select * from products where product_id='".$fn->ReplaceSql($_POST['product_id'])."'";
		$dbwishlist=$fn->SelectQuery($query);
		$dbwishlist=$dbwishlist[0];
		$wishlist=array(
			"productid"=>$dbwishlist['product_id'],
			"title"=>$dbwishlist['product_title'],
			"img"=>WEBSITE_URL."products/".$dbwishlist['featured_image'],
			"colorid"=>$_POST['color_id'],
			"size"=>$_POST['size'],
		);
		$flg=false;
		foreach($_SESSION['WISHLIST_PRODUCTS'] as $row){
			if($row['productid']==$_POST['product_id']){
				$flg=true;
				break;
			}
		}
		if($flg==false){
			array_push($_SESSION['WISHLIST_PRODUCTS'],$wishlist);	
			echo "script|g||g|$('#blurcounter').find('span').html('".count($_SESSION['WISHLIST_PRODUCTS'])."');";
		}
	}elseif($_POST['action']=="deleteproduct"){
		$i=0;
		$temparray=array();
		foreach($_SESSION['WISHLIST_PRODUCTS'] as $items){
			if($i!=$_POST['wishlistid']){
				array_push($temparray,$_SESSION['WISHLIST_PRODUCTS'][$i]);
			}
			$i++;
		}
		$_SESSION['WISHLIST_PRODUCTS']=$temparray;
	}
	if($_POST['type']=="wishlist"){
	$i=0;
	if(count($_SESSION['WISHLIST_PRODUCTS'])>0){foreach($_SESSION['WISHLIST_PRODUCTS'] as $items){?>
    <li><a href="javascript:;"  onClick="senddata('pro-detail','id=<?php echo $items['productid'];?>','pro-detail');"><img src="<?php echo $items['img'];?>" alt="<?php echo $items['title'];?>" height="212" width="212"></a> 
          <h6 class="h5" onClick="senddata('pro-detail','id=<?php echo $items['productid'];?>','pro-detail');"><?php echo $items['title'];?></h6>
          <ul class="tools">
            <li><a href="javascript:;" onClick="senddata('pro-detail','id=<?php echo $items['productid'];?>','pro-detail');">View</a></li>
            <li><a href="javascript:;" onclick="senddata('wishlist','action=deleteproduct&type=wishlist&wishlistid=<?php echo ($i);?>','wishlist');">Remove</a></li>
            <li><a href="javascript:;" onclick="senddata('cart','action=addcartproduct&product_id=<?php echo $items['productid']?>&color_id=<?php echo $items['colorid']?>&size=<?php echo $items['size']?>','');senddata('right-top-cart','type=cart','miniwishlist');">Add to Bag</a></li>
          </ul>
        </li>
    <?php }} 
	 if(count($_SESSION['WISHLIST_PRODUCTS'])==0){?>
        <div id="empty">
          <h2 class="h2" style="color:#fff">SAVE & SHARE YOUR FAVOURITE CONTENT AND PRODUCTS</h2>
          <p>YOU HAVE NOT ADDED ANY ITEMS</p>
          <p>TO ADD ITEMS, CLICK ON THE "MYMCQUEEN" OR "MYMCQ" BUTTON FOUND THROUGHOUT THE SITE. YOU CAN ADD SHOWS, PRODUCTS, LOOKS OR ANY OTHER CONTENT FROM THE SITE.</p>
        </div>
<?php }}?>