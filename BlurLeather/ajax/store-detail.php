<?php require_once("../class/class.functions.php"); $fn = new Functions();
if($_POST['country_id']!=''){ $where="and country_id='".$_POST['country_id']."'";}
$store = $fn->SelectQuery("select s.*,c.country_title from stores as s inner join country as c on s.country_id=c.country_id where s.store_id='".$_POST['store_id']."' order by store_id asc");
$store=$store[0]; echo"script|g|";
if($store['store_image']==""){?><div class="content store">
  <div class="col">
    <div class="main">
    	<div id="map" style="width:605px; height:250px"></div>
    </div>
  </div>
  <div class="col">
    <div class="extra">
      <h2 class="h1"><?php echo $store['store_name'];?></h2>
      <address>
     	<?php echo $fn->MakeHTML($store['store_address'])?><br />
        T.: <?php echo $store['phone_no']?><br />
      <a href="ajax_pages/contact_us.php" onclick="superopen('ajax_pages/contact_us.php',930,550); return false;">Contact Us</a>
      </address>
    </div>
  </div>
  <ul class="contentpager">
   <?php 
	if($prev = $fn->SelectQuery("Select store_id from stores where 1=1 {$where} and orderid<".$store['orderid']." order by orderid,store_id desc limit 1")){?><li onclick="senddata('store-detail','store_id=<?php echo $prev[0]['store_id'];?>','store-detail');">Previous</li><?php }else{?><li></li><?php }?>
    <?php if($next = $fn->SelectQuery("Select store_id from stores where 1=1 {$where} and orderid>".$store['orderid']." order by orderid,store_id asc limit 1")){?><li onclick="senddata('store-detail','store_id=<?php echo $next[0]['store_id'];?>','store-detail');">Next</li><?php }else{?><li></li><?php }?>
  </ul>
  <div class="logo">Blur Leather</div>
  <span class="close">Close</span> </div>
<?php } else{ ?>
<div data-stacktype="storedetail" class="content store">
  <div class="col">
    <div class="main">
      <div class="teaser"> <img width="768" height="432" alt="<?php echo $store['store_name'];?>" src="stores/<?php echo $store['store_image']?>"> </div>
      <h2 class="h1"><?php echo $store['store_name'];?></h2>
      <address>
      <?php echo $fn->MakeHTML($store['store_address'])?><br />
      T.: <?php echo $store['phone_no']?><br />
      <a href="ajax_pages/contact_us.php" onclick="superopen('ajax_pages/contact_us.php',930,550); return false;">Contact Us</a>
      </address>
    </div>
  </div>
  <div class="col">
    <div class="extra">
    <div id="map" style="width:400px; height:250px; margin-bottom:10px;"></div>
      <h4 class="h6">Opening Hours</h4>
      <p>
	  	<?php echo $fn->MakeHTML($store['store_timing'])?>
      </p>
    </div>
  </div>
  <ul class="contentpager">
  	<?php 
	if($prev = $fn->SelectQuery("Select store_id from stores where 1=1 {$where} and orderid<".$store['orderid']." order by orderid,store_id desc limit 1")){?><li onclick="senddata('store-detail','store_id=<?php echo $prev[0]['store_id'];?>','store-detail');">Previous</li><?php }else{?><li></li><?php }?>
    <?php if($next = $fn->SelectQuery("Select store_id from stores where 1=1 {$where} and orderid>".$store['orderid']." order by orderid,store_id asc limit 1")){?><li onclick="senddata('store-detail','store_id=<?php echo $next[0]['store_id'];?>','store-detail');">Next</li><?php }else{?><li></li><?php }?>
  </ul>
  <div class="logo">Blur Leather</div>
  <span class="close" onclick="boxclose('store-detail','container');">Close</span> </div><?php }?>|g|load('<?php echo $store['latitude'];?>','<?php echo $store['longitude'];?>','<?php echo $store['store_address'];?>');