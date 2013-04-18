<?php require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if($_REQUEST['action']=='delete'){
	$query="delete from shows_order where show_order_id='".$obj->ReplaceSql($_REQUEST['show_order_id'])."'";
	$obj->UpdateQuery($query);
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "Shows Booking Order has been deleted successfully!";
	$obj->ReturnReferer();
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php"); ?>
<title>Admin Panel</title>
</head>
<body>
<?php include_once("message.php"); ?>
<h1>Manage Shows Booking Orders <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";} ?> <?php if($_REQUEST['action']=="add"){ echo "[Add]";} ?> <?php if($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
<ul class="tabs">
    <li><a href="show_orders.php" class="current">Show Booking Orders</a></li>
    <li><a href="class_orders.php">Class Booking Orders</a></li>
    <li><a href="private_orders.php">Private Booking Orders</a></li>
</ul>
    <?php $obj->SetCurrentUrl();?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <?php 
           $query = "select * from shows_order as s left outer join payments as mp on s.show_order_id=mp.paypal_order_id order by s.show_order_id desc";
            $pager = new Pagination($query,$_REQUEST['page'],20,5);
            if($orders = $pager->Paging()){$sno = $pager->GetSNo();?>
                <tr>
                    <th width="10%">Order No</th>
                    <th width="10%">Order Date</th>
                    <th width="10%">Show Title</th>
                    <th width="10%">Full Name</th>
                    <th width="10%">Email</th>
                    <th width="10%">Total Price</th>
                    <th width="20%">Location</th>
                    <th width="10%">Payment Status</th>
                    <th width="10%">View / Delete</th>
                </tr>
                <?php foreach($orders as $order){?>
                 <tr>
                    <td><?php echo $order['show_order_id'];?></td>
                    <td><?php echo date("M d, Y",strtotime($order['order_date'])); ?></td>
                    <td><?php echo $order['show_title'];?></td>
                    <td><?php echo $order['full_name'];?></td>
                    <td><?php echo $order['email'];?></td>
                    <td><?php echo $order['show_price'];?> * <?php echo $order['total_ticket'];?> = <?php echo $order['total_price'];?></td>
                    <td><?php echo $order['city'];?>, <?php echo $order['state'];?>, <br /><?php echo $order['country'];?>, <br /><?php echo $order['mobile_no'];?></td>
                    <td id="payment_status<?php echo $order['show_order_id'];?>">
                    	<?php if($order['payment_status']=="Y") { 
							echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=shows&val=N&show_order_id=". $order['show_order_id']."','payment_status".$order['show_order_id']."');\">Pending</a> | <strong>Paid</strong>";
						}elseif($order['payment_status']=="N") {
							echo "<strong>Pending</strong> | <a href=\"javascript:;\" onclick=\"senddata('orders','type=shows&val=Y&show_order_id=".$order['show_order_id']."','payment_status".$order['show_order_id']."');\">Paid</a>";
						}?>
                    </td>
                    <td>
                    	<a class="view" href="javascript:;" onclick="$('#order_details<?php echo $order['show_order_id'];?>').slideToggle(500);"></a>
                        <a class="delete" onclick="return confirm('Are you sure to delete?');" href="?action=delete&show_order_id=<?php echo $order['show_order_id'];?>"></a>
                    </td>
                </tr>
                <tr>
                	<td colspan="9">
                    	<div class="full none" id="order_details<?php echo $order['show_order_id'];?>">
	                		<table width="100%" cellspacing="0" cellpadding="5">
                            <tr>
                                <th width="100%" colspan="5" style="font-size:14px"><b>Paypal Information</b></th>
                            </tr>
                            <tr>
                                <td width="17%"><b>Payer Id :</b> <?php echo $order['payer_id']?></td>
                                <td width="15%"><b>Tax :</b> <?php echo $order['tax']?></td>
                                <td width="28%"><b>Street Address :</b> <?php echo $order['address_street']?></td>
                                 <td width="25%"><b>Paypal Payment Status :</b> <?php echo $order['paypal_payment_status']?></td>
                                <td width="15%"><b>Country :</b> <?php echo $order['address_country']?></td>
                            </tr>
                            <tr>
                                <td width="17%"><b>City :</b> <?php echo $order['address_city']?></td>
                                <td width="15%"><b>Zip Code :</b> <?php echo $order['address_zip']?></td>
                                <td width="28%"><b>Payer Email :</b> <?php echo $order['payer_email']?></td>
                                <td width="25%"><b>Transaction Id :</b> <?php echo $order['txn_id']?></td>
                                <td width="15%"><b>Gross Payment :</b> <?php echo $order['payment_gross']?></td>
                            </tr>
                         </table>
                    	</div>
                    </td>
                </tr>
                <?php }?>
                <tr>
                	<td class="paging" colspan="9">
                    	<?php echo $pager->DisplayAllPaging();?>
                    </td>
                </tr>
                <?php } else {?>
               <tr>
                	<td colspan="9">
                    	No Shows Order found	
                    </td>
                </tr>
                <?php } ?>
    </table>
<?php include_once("footer.php");?>
</body>
</html>