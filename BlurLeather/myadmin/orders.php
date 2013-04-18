<?php require_once("../class/class.admin.php");
	require_once("../class/class.pagination.php");
	$fn = new Admin();
	$fn->RequireLogin();
if($_REQUEST['action']=="delete"){
	$fn->UpdateQuery("delete from order_form where orderid='".$_REQUEST['orderid']."'");
	$fn->UpdateQuery("delete from order_product where orderid='".$_REQUEST['orderid']."'");
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Order has been deleted successfully";
	$fn->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php");?>
</head>
<body>
<?php include_once("message.php"); 	$fn->SetCurrentUrl(); ?>
<div class="full">
<h1>Manage Orders <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
</div>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
	<tr>
    	<th colspan="9">
        	<form>
            	Search by keywords: 
                <input type="text" name="keyword" id="keyword" value="Search Title" onfocus="if(this.value==this.defaultValue){this.value='';}" size="40"/>
                <select id="orderstatus" name="orderstatus" class="R" title="Order Status">
                    <option value="">------Select Order Type------</option>
                    <option value="Y" <?php echo $_REQUEST['orderstatus']=='Y'?'selected="selected"':'';?>>Order Completed</option>
                    <option value="P" <?php echo $_REQUEST['orderstatus']=='P'?'selected="selected"':'';?>>Order Pending</option>
                    <option value="C" <?php echo $_REQUEST['orderstatus']=='C'?'selected="selected"':'';?>>Order Canceled</option>
                    <option value="S" <?php echo $_REQUEST['orderstatus']=='S'?'selected="selected"':'';?>>Order Shipped</option>
                </select>
                <select id="paymentstatus" name="paymentstatus" class="R" title="Payment Status">
                    <option value="">------Select Payment Type------</option>
                    <option value="Y" <?php echo $_REQUEST['paymentstatus']=='Y'?'selected="selected"':'';?>>Paid</option>
                    <option value="N" <?php echo $_REQUEST['paymentstatus']=='N'?'selected="selected"':'';?>>Pending</option>
                </select>
                <input type="submit" value="Go" class="button" onclick="if($('#keyword').val()=='Search Title'){$('#keyword').val('');}" />
                <input type="button" value="View All" class="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>';" />
            </form>
        </th>
    </tr>
    <tr>
    	<th width="5%">Sr. No.</th>
	    <th width="5%">Order No.</th>
        <th width="10%">Member Name</th>
        <th width="8%">Order Date</th>
        <th width="20%">Order Status</th>
        <th width="10%">Payment Status</th>
        <th width="7%">Payment + Shipping</th>
        <th width="5%">View</th>
        <th width="5%">Delete</th>
    </tr> 
    <?php
		$orderstatus = trim($_REQUEST['orderstatus']);
		$paymentstatus = trim($_REQUEST['paymentstatus']);
		$keyword = trim($_REQUEST['keyword']);
		$member_id = trim($_REQUEST['member_id']);
		$where = '';
		if($keyword!=''){
			$where .= " and (o.first_name like '%".$keyword."%' or o.last_name like '%".$keyword."%' or o.orderid like '%".$keyword."%' or o.orderid='".$keyword."')";
		}
		if($orderstatus!=''){
			$where .= " and (o.orderstatus='".$orderstatus."')";
		}
		if($paymentstatus!=''){
			$where .= " and (o.paymentstatus='".$paymentstatus."')";
		}
		if($member_id!=''){
			$where .= " and (o.member_id='".$member_id."')";
		} 
    	$query="select o.*,mp.* from order_form as o inner join members as m on m.member_id=o.member_id left outer join members_payment as mp on o.orderid=mp.order_id where 1=1 {$where} order by o.orderid desc";
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
                        echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=P&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Pending</a>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=C&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Canceled</a>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=S&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Shipped</a>";
                        echo " | <strong>Completed</strong>";
                    }
                    if($row['orderstatus']=="P") {
                        echo "<strong>Pending</strong>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=C&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Canceled</a>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=S&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Shipped</a>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=Y&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Completed</a>";
                    }
                    if($row['orderstatus']=="C") {
                        echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=P&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Pending</a>";
                        echo " | <strong>Canceled</strong>";				
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=S&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Shipped</a>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=Y&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Completed</a>";
                    }
                    if($row['orderstatus']=="S") {				
                        echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=P&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Pending</a>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=C&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Canceled</a>";
                        echo " | <strong>Shipped</strong>";
                        echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=Y&orderid=".$row['orderid']."','orderstatus".$row['orderid']."');\">Completed</a>";
                    }?>
                </td>
                <td id="paymentstatus<?php echo $row['orderid'];?>">
					<?php if($row['paymentstatus']=="Y") { 
echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=payment&val=N&orderid=".$row['orderid']."','paymentstatus".$row['orderid']."');\">Pending</a> | <strong>Paid</strong>";
}elseif($row['paymentstatus']=="N") {
echo "<strong>Pending</strong> | <a href=\"javascript:;\" onclick=\"senddata('orders','type=payment&val=Y&orderid=".$row['orderid']."','paymentstatus".$row['orderid']."');\">Paid</a>";
}?>
                    </td>    
                <td><b><?php echo $row['paidamount']." + ".$row['shipamount']." = (".$row['currency'].") ".($row['paidamount']+$row['shipamount']);?></b></td>
                <td><a class="view" href="javascript:;" onclick="$('#order<?php echo $row['orderid']?>').slideToggle(1000)"></a></td>
                <td><a class="delete" href="?action=delete&orderid=<?php echo $row['orderid'];?>"></a></td>
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
                                <div class="cols10 txtright">Email: </div>
                                <div class="cols20"><?php echo $row['email']?></div>
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
                                <div class="cols10 txtright">Email: </div>
                                <div class="cols20"><?php echo $row['email']?></div>
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
                        <div class="rows">
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
                         <div class="rows">
                            <div class="cols90 txtright"><strong>Sub Total : </strong>&nbsp;</div>
                            <div class="cols10 txtright"><strong><?php echo $row['currency']." "; printf("%.2f",$amt);?></strong></div>
                        </div>
                        <div class="rows">
                            <div class="cols90 txtright"><strong>Shipment : </strong>&nbsp;</div>
                            <div class="cols10 txtright"><strong><?php echo $row['currency']." "; printf("%.2f",$row['shipamount']);?></strong></div>
                        </div>
                       	 <div class="rows">
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
            <td colspan="9" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$_GET['keyword']."&orderstatus=".$_GET['orderstatus']."&paymentstatus=".$_GET['paymentstatus']);?></td>
        </tr>
    <?php } else { ?>
        <tr>
            <td colspan="9" class="error">No Order found</td>
        </tr>
    <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>