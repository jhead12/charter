<div class="prog"><img src="images/loader.gif" alt="loading..." /></div>
<div id="header">
	<?php if($header_data=$fn->SelectQuery("select * from social_links")){
			$header=$header_data[0];
		}
		if($nav_data=$fn->SelectQuery("select * from pre_category where pre_category_id!='1'")){
			$nav=array();
			foreach($nav_data as $val){
				$nav[$val['pre_category_id']]=$val['status'];
			}
		}
	?>
  <h1> <a href="index.php" id="logo" title="Blur Leather"><img src="social_links/<?php echo $header['site_logo'];?>" alt="" width="72" height="29" /></a></h1>
  <ul id="mainnav">
    <li<?php echo strpos($_SERVER['SCRIPT_FILENAME'],"index.php")!==FALSE ? ' class="active"':'';?>> <a href="index.php">Home</a> </li>
    <?php 
	if($nav[2]=='1'){?>
    <li<?php echo strpos($_SERVER['REQUEST_URI'],"/womens")!==FALSE ? ' class="active"':'';?>> <a href="womenswears.php">Womenswear</a>
      <ul>
        <li> <a href="womens-shop-look.php">Shop The Look</a></li>
        <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=2 order by orderid")){foreach($cats as $cat){if($cat['category_image_approved']=='1'){?>
        <li class="special"> <a href="womenswears-<?php echo $cat['category_id'];?>.php" style="background-image:url(category/<?php echo $cat['category_image'];?>)"><?php echo $cat['category_title'];?></a> </li>
        <?php }else{?>
        <li> <a href="womenswears-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
        <?php }}}?>
      </ul>
    </li>
    <?php } ?>
    <?php if($nav[3]=='1'){?>
    <li<?php echo strpos($_SERVER['REQUEST_URI'],"/menswears")!==FALSE ? ' class="active"':'';?>> <a href="menswears.php">Menswear</a>
      <ul>
        <li> <a href="mens-shop-look.php">Shop The Look</a></li>
        <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=3 order by orderid")){foreach($cats as $cat){if($cat['category_image_approved']=='1'){?>
        <li class="special"> <a href="menswears-<?php echo $cat['category_id'];?>.php" style="background-image:url(category/<?php echo $cat['category_image'];?>)"><?php echo $cat['category_title'];?></a> </li>
        <?php }else{?>
        <li> <a href="menswears-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
        <?php }}}?>
      </ul>
    </li>
    <?php } ?>
    <?php if($nav[4]=='1'){?>
    <li<?php echo strpos($_SERVER['REQUEST_URI'],"/scraf-boutique")!==FALSE ? ' class="active"':'';?>> <a href="scraf-boutiques.php">Scarf Boutique</a>
      <ul>
        <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=4 order by orderid")){foreach($cats as $cat){if($cat['category_image_approved']=='1'){?>
        <li class="special"> <a href="scraf-boutiques-<?php echo $cat['category_id'];?>.php" style="background-image:url(category/<?php echo $cat['category_image'];?>)"><?php echo $cat['category_title'];?></a> </li>
        <?php }else{?>
        <li> <a href="scraf-boutiques-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
        <?php }}}?>
      </ul>
    </li>
    <?php } ?>
    <li<?php echo strpos($_SERVER['SCRIPT_FILENAME'],"/experience.php")!==FALSE ? ' class="active"':'';?>> <a href="experience.php">Experience</a>
      <ul>
        <li><a href="biography.php">Biography</a></li>
        <li><a href="philosophy.php">Our Philosophy</a></li>
        <li><a href="archives.php">Archives</a></li>
      </ul>
    </li>
    <?php if($nav[5]=='1'){?>
    <li<?php echo strpos($_SERVER['REQUEST_URI'],"sales")!==FALSE ? ' class="active"':'';?>> <a href="sales.php">Sale</a>
      <ul>
        <?php if($cats = $fn->SelectQuery("Select * from category where pre_category_id=5 order by orderid")){
		foreach($cats as $cat){if($cat['category_image_approved']=='1'){?>
        <li class="special"> <a href="sales-<?php echo $cat['category_id'];?>.php" style="background-image:url(category/<?php echo $cat['category_image'];?>)"><?php echo $cat['category_title'];?></a> </li>
        <?php }else{?>
        <li> <a href="sales-<?php echo $cat['category_id'];?>.php"><?php echo $cat['category_title'];?></a></li>
        <?php }}}?>
      </ul>
    </li>
    <?php } ?>
    <li class="search">
      <form action="search.php">
        <fieldset>
          <input name="q" id="search" placeholder="Search" type="text">
        </fieldset>
      </form>
    </li>
  </ul>
  <ul id="metanav" class="servicenav">
    <li><a href="ajax_pages/country_select.php" rel="superbox[iframe][930x550]">Country(<?php echo $_SESSION['CURRENCY'];?>)</a></li>
    <li><a href="store_locator.php">Store Locator</a></li>
    <li><a href="ajax_pages/subscribe.php" rel="superbox[iframe][930x550]">Subscribe</a></li>
  </ul>
  <ul id="accountnav" class="servicenav">
   	 <li id="blurcounter"><a href="myblur.php"> BLUR LEATHER (<span><?php echo count($_SESSION['WISHLIST_PRODUCTS']);?></span>)</a> </li>
    <?php if(!$_SESSION['USERLOGIN']){?>
	    <li><a href="ajax_pages/login.php" rel="superbox[iframe][930x550]">Login / Register</a></li>
    <?php } else{ ?>
    	<li><a>Hi! <?php echo $_SESSION['USERNAME'];?></a></li>
        <li><a href="change_password.php">Change Password</a></li>
        <li><a href="index.php?signout">Signout</a></li>
        <li><a href="my_orders.php">My Orders</a></li>
    <?php } ?>
    <li id="basketcounter"> <a href="cart.php">Shopping Bag <span>(<?php echo count($_SESSION['CART_PRODUCTS']);?>)</span></a>
    <div id="minibasket"><?php if(count($_SESSION['CART_PRODUCTS'])>0){?>
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
	<center>Yout Shopping Bag is empty.</center>
    <?php }?>
    </div>
    </li>
  </ul>
</div>