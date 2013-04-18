<?php 
require_once("../../class/class.admin.php");
$fn = new Admin();
$fn->RequireLogin();
if($_POST['type']=='order'){
	$fn->UpdateQuery("update order_form set orderstatus='".$_POST['val']."' where orderid='".$_POST['orderid']."'");
	if($_POST['val']=="Y") {
		echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=P&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Pending</a>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=C&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Canceled</a>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=S&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Shipped</a>";
		echo " | <strong>Completed</strong>";
	}
	if($_POST['val']=="P") {
		echo "<strong>Pending</strong>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=C&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Canceled</a>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=S&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Shipped</a>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=Y&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Completed</a>";
	}
	if($_POST['val']=="C") {
		echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=P&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Pending</a>";
		echo " | <strong>Canceled</strong>";				
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=S&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Shipped</a>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=Y&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Completed</a>";
	}
	if($_POST['val']=="S") {				
		echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=P&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Pending</a>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=C&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Canceled</a>";
		echo " | <strong>Shipped</strong>";
		echo " | <a href=\"javascript:;\" onclick=\"senddata('orders','type=order&val=Y&orderid=".$_POST['orderid']."','orderstatus".$_POST['orderid']."');\">Completed</a>";
	}
}else if($_POST['type']=='payment'){
	$fn->UpdateQuery("update order_form set paymentstatus='".$_POST['val']."' where orderid='".$_POST['orderid']."'");
	if($_POST['val']=="Y") { 
        echo "<a href=\"javascript:;\" onclick=\"senddata('orders','type=payment&val=N&orderid=".$_POST['orderid']."','paymentstatus".$_POST['orderid']."');\">Pending</a> | <strong>Paid</strong>";
	}elseif($_POST['val']=="N") {
		echo "<strong>Pending</strong> | <a href=\"javascript:;\" onclick=\"senddata('orders','type=payment&val=Y&orderid=".$_POST['orderid']."','paymentstatus".$_POST['orderid']."');\">Paid</a>";
    }
}
?>