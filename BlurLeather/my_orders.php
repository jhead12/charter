<?php require_once("class/class.functions.php"); 
	require_once("class/class.pagination.php");
	$fn = new Functions();
	$fn->ReqLogin();
	$fn->CurrentUrl();
?>
<!DOCTYPE html>
<html class="js flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_GB" lang="en_GB">
<head>
<title><?php echo COMPANY_NAME;?>| My Orders</title>
<?php include_once("inc.head.php");?>
<style>
.tbl{ width:100%; border-top:#c5c5c5 solid 1px; border-left:#c5c5c5 solid 1px; border-bottom:#fff solid 1px;margin-top:5px;background:#f2f2f2}
.tbl th{border-bottom:#c5c5c5 solid 1px; border-right:#c5c5c5 solid 1px; border-top:#fff solid 1px; border-left:#fff solid 1px; padding:5px; text-align:left;  line-height:18px; vertical-align:text-top; background:#bbbbbb; color:#000;}
.tbl td{border-bottom:#c5c5c5 solid 1px; border-right:#c5c5c5 solid 1px; padding:5px;  border-top:#fff solid 1px; border-left:#fff solid 1px; line-height:18px;vertical-align:top;}
.full{ clear:both; width:100%; float:left;}
</style>
</head>
<body>
<div class="resized">
 <?php include_once("inc.header.php");?>
  <div class="content" style="padding:20px">
    <div class="checkout">
      <div class="head">
        <h2 class="h1">My Orders</h2>
      </div>
	<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
    	<th width="10%">Sr. No.</th>
	    <th width="10%">Order No.</th>
        <th width="10%">Member Name</th>
        <th width="10%">Order Date</th>
        <th width="10%">Order Status</th>
        <th width="15%">Payment Status</th>
        <th width="20%">Payment + Shipping</th>
        <th width="10%">View</th>
    </tr> 
    <?php
    	$query="select o.*,mp.* from order_form as o inner join members as m on m.member_id=o.member_id left outer join members_payment as mp on o.orderid=mp.order_id where 1=1 {$where} and o.member_id='".$_SESSION['USERID']."' order by o.orderid desc";
		$pager = new Pagination($query,$_REQUEST['page'],10,5);
		if($data = $pager->Paging()){
			$i = $pager->GetSNo();
			foreach ($data as $row){ 
				$products = $fn->SelectQuery("select o.*, p.product_title,p.featured_image from order_product as o inner join products as p on o.productid = p.product_id where o.orderid='".$row['orderid']."'");
			?>
            <tr>
                <td><b><?php echo $i++;?></b></td>
                <td><b><?php echo $row['orderid'];?></b></td>
                <td><b><?php echo $row['first_name']." ".$row['last_name'];?></b></td>
                <td><b><?php echo date("M d,Y",strtotime($row['orderdate']));?></b></td>
                <td id="orderstatus<?php echo $row['orderid'];?>">
                    	 <?php
                    if($row['orderstatus']=="Y") {
                        echo "<strong>Completed</strong>";
                    }
                    if($row['orderstatus']=="P") {
                        echo "<strong>Pending</strong>";
                    }
                    if($row['orderstatus']=="C") {
                        echo "<strong>Canceled</strong>";				
                    }
                    if($row['orderstatus']=="S") {				
                        echo "<strong>Shipped</strong>";
                    }?>
                </td>
                <td id="paymentstatus<?php echo $row['orderid'];?>">
					<?php if($row['paymentstatus']=="Y") { 
					echo "<strong>Paid</strong>";
					}elseif($row['paymentstatus']=="N") {
					echo "<strong>Pending</strong>";
					}?>
                    </td>    
                <td><b><?php echo $row['paidamount']." + ".$row['shipamount']." = (".$row['currency'].") ".($row['paidamount']+$row['shipamount']);?></b></td>
                <td><a class="view" href="javascript:;" onclick="$('#order<?php echo $row['orderid']?>').slideToggle(1000)">View</a></td>
            </tr>
            <tr>
                <td colspan="10">
                	<div class="full none" id="order<?php echo $row['orderid']?>">
						<table width="100%" cellspacing="0" cellpadding="5">
                            <tr>
                                <th width="100%" colspan="6"><b>Authorized Payment Gateway Information</b></th>
                            </tr>
                            <tr>
                                <td><b>Success Message :</b> <?php echo $row['success_message']?></td>
                                <td><b>Response Text :</b> <?php echo $row['response_text']?></td>
                                <td><b>Authorization Code :</b> <?php echo $row['authorization_code']?></td>
                                <td ><b>Transaction Id :</b> <?php echo $row['transaction_id']?></td>
                                <td colspan="2"><b>Payment For :</b> <?php echo $row['payment_for']?></td>
                            </tr>
                            <tr>
                                <td><b>Transaction Amount :</b> <?php echo "USD ".$row['transaction_amount']?></td>
                                <td><b>The payment method :</b> <?php echo $row['payment_method']?></td>
                                <td><b>Transaction Type :</b> <?php echo $row['transaction_type']?></td>
                                <td><b>Card Code Response :</b> <?php echo $row['card_code_response']?></td>
                                <td><b>Account Number :</b> <?php echo $row['account_number']?></td>
                                <td><b>Card Type :</b> <?php echo $row['card_type']?></td>
                            </tr>
                         </table>	
                        <div class="full">
                            <div class="rowshdr"><div class="cols100">Billing Information</div></div>
                            <div class="full">
                                <div class="cols10 txtright">Full Name : </div>
                                <div class="cols10"><?php echo $row['billing_salutation']." ".$row['billing_first_name']." ".$row['billing_last_name']?></div>
                                <div class="cols10 txtright">Address 1: </div>
                                <div class="cols10"><?php echo $row['billing_address1']?></div>
                                <div class="cols10 txtright">Address 2: </div>
                                <div class="cols10"><?php echo $row['billing_address2']?></div>
                                <div class="cols10 txtright">Country: </div>
                                <div class="cols10"><?php echo $row['billing_country']?></div>
                                <div class="cols10 txtright">Province: </div>
                                <div class="cols10"><?php echo $row['billing_province']?></div>
                                <div class="cols10 txtright">City: </div>
                                <div class="cols10"><?php echo $row['billing_city']?></div>
                                <div class="cols10 txtright">Company: </div>
                                <div class="cols10"><?php echo $row['billing_company']?></div>
                                <div class="cols10 txtright">Post Code: </div>
                                <div class="cols10"><?php echo $row['billing_post_code']?></div>
                            </div>
                            
                        </div>
                        <div class="full">
                            <div class="rowshdr"><div class="cols100">Shipping Address</div></div>
                            	<div class="cols10 txtright">Full Name : </div>
                                <div class="cols10"><?php echo $row['salutation']." ".$row['first_name']." ".$row['last_name']?></div>
                                <div class="cols10 txtright">Address 1: </div>
                                <div class="cols10"><?php echo $row['address1']?></div>
                                <div class="cols10 txtright">Address 2: </div>
                                <div class="cols10"><?php echo $row['address2']?></div>
                                <div class="cols10 txtright">Country: </div>
                                <div class="cols10"><?php echo $row['country']?></div>
                                <div class="cols10 txtright">Province: </div>
                                <div class="cols10"><?php echo $row['province']?></div>
                                <div class="cols10 txtright">City: </div>
                                <div class="cols10"><?php echo $row['city']?></div>
                                <div class="cols10 txtright">Company: </div>
                                <div class="cols10"><?php echo $row['company']?></div>
                                <div class="cols10 txtright">Post Code: </div>
                                <div class="cols10"><?php echo $row['post_code']?></div>
                        </div>
                	<?php 
					if($products){$j=0;$amt=0;?>
                    <div class="full">
                        <div class="rowshdr">
                                <div class="cols10">S No.</div>
                                <div class="cols30">Product Name</div>
                                <div class="cols10">Image</div>
                                <div class="cols10">Size</div>
                                <div class="cols10">Colour</div>
                                <div class="cols10 txtright">Price</div>
                                <div class="cols10 txtright">Qty</div>
                                <div class="cols10 txtright">Amount</div>
                            </div>
                        <?php foreach($products as $pro){?>
                        <div class="full">
                            <div class="cols10"><?php echo ++$j; ?></div>
                            <div class="cols30"><?php echo $pro['product_title'];?></div>
                            <div class="cols10"><img src="<?php echo WEBSITE_URL."products/". $pro['featured_image'];?>" width="50" /></div>
                            <div class="cols10"><?php echo $pro['size'];?></div>
                            <div class="cols10"><?php echo $pro['colortitle'];?></div>
                            <div class="cols10 txtright"><?php echo $row['currency']." "; printf("%.2f",$pro['price']);?></div>
                            <div class="cols10 txtright"><?php echo $pro['quantity'];?></div>
                            <div class="cols10 txtright"><?php echo $row['currency']." "; printf("%.2f",($pro['quantity'] * $pro['price'])); $amt += ($pro['quantity'] * $pro['price']);?></div>
                        </div>
                        <?php }?>
                        <div class="full">
                            <div class="cols90 txtright"><strong>Sub Total : </strong>&nbsp;</div>
                            <div class="cols10 txtright"><strong><?php echo $row['currency']." "; printf("%.2f",$amt);?></strong></div>
                        </div>
                        <div class="full">
                            <div class="cols90 txtright"><strong>Shipment : </strong>&nbsp;</div>
                            <div class="cols10 txtright"><strong><?php echo $row['currency']." "; printf("%.2f",$row['shipamount']);?></strong></div>
                        </div>
                       	 <div class="full">
                            <div class="cols90 txtright"><strong>Total : </strong>&nbsp;</div>
                            <div class="cols10 txtright"><strong><?php echo $row['currency']." "; printf("%.2f",($amt+$row['shipamount']));?></strong></div>
                        </div>
                  	</div>
                    <?php } ?>
                </div>
                </td>
            </tr>
	    	<?php } ?>
        <tr>
            <td colspan="8" class="paging" align="center"><?php echo $pager->DisplayAllPaging();?></td>
        </tr>
    <?php } else { ?>
        <tr>
            <td colspan="8" class="error">No Order found</td>
        </tr>
    <?php } ?>
    </table>     
      
    </div>
  </div>
  <div id="footer" class="prehide">
    <ul id="footernav" class="topnav">
      <li><a href="company_info.php">Company Info</a></li>
      <li><a href="ajax_pages/contact_us.php" rel="superbox[iframe][930x550]">Contact us</a></li>
      <li><a href="privacy_policy.php">Future Product</a></li>
      <li><a href="privacy_policy.php">Privacy policy</a></li>
      <li><a href="sitemap.php">Sitemap</a></li>
    </ul>
    <p class="copy">© 2012 Blur Leather</p>
  </div>
</div>
<script type="text/javascript" src="js/jquery.ajax_page.js"></script> 
<script type="text/javascript" src="js/validation.js"></script> 
<script type="text/javascript" src="lightbox/js/jquery.superbox.js"></script> 
<script type="text/javascript">
	$("document").ready(function() {								
	$("#signup_pbtn").click(function() {
      	$('html, body').animate({
			scrollTop: $("#addresses").offset().top-36
		}, 1000);				   					 
      });  
	});

	$(function(){
		$.superbox.settings = {
			closeTxt: "Close",
			loadTxt: "",
			nextTxt: "Next",
			prevTxt: "Previous"
		};
		$.superbox();
	});
	function superopen(url,w,h){
		var iframe = '<iframe src="'+ url +'" name="" frameborder="0" scrolling="auto" width="'+ w +'" height="'+ h +'"></iframe>';
		$.superbox.open(iframe,{boxWidth:w,boxHeight:h});
	}
</script>
<?php include("includes/inc.footer_unset.php");?>
<?php include_once("message.php");
unset($_SESSION['response_array']);
?>
</body>
</html>