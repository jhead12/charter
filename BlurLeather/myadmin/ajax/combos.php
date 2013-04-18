<?php	
	require_once("../../class/class.admin.php");
	$obj = new Admin();
	$obj->RequireLogin();
	header('Content-Type: text/html; charset=utf-8');
	if($_POST['type']=="category"){
		echo '<option value="">-Select Category-</option>';
		if($cmb = $obj->SelectQuery("select * from category where pre_category_id='".$_POST['pre_category_id']."' order by category_title")){
			foreach($cmb as $val){
				echo '<option value="'.$val['category_id'].'"'.(($val['category_id']==$_POST['sel']) ? ' selected="selected"':'').'>'.$val['category_title'].'</option>';
			}
		}
	}
	if($_POST['type']=="sub_category"){
		echo '<option value="">-Select Sub Category-</option>';
		if($cmb = $obj->SelectQuery("select * from sub_category where category_id='".$_POST['category_id']."' and pre_category_id='".$_POST['pre_category_id']."' order by sub_category_title")){
			foreach($cmb as $val){
				echo '<option value="'.$val['sub_category_id'].'"'.(($val['sub_category_id']==$_POST['sel']) ? ' selected="selected"':'').'>'.$val['sub_category_title'].'</option>';
			}
		}
	}
	if($_POST['type']=="products"){
		echo '<option value="">-Select Product-</option>';
		if($cmb = $obj->SelectQuery("select * from products where sub_category_id='".$_POST['sub_category_id']."' and pre_category_id='".$_POST['pre_category_id']."' order by product_title")){
			foreach($cmb as $val){
				echo '<option value="'.$val['product_id'].'"'.(($val['product_id']==$_POST['sel']) ? ' selected="selected"':'').'>'.$val['product_title'].'</option>';
			}
		}
	}
?>