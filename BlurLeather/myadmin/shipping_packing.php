<?php
require_once("../class/class.admin.php");
require_once("../class/class.pagination.php");
$obj = new Admin();
$obj->RequireLogin();
if(isset($_POST['btnupdate'])){	
	$shipping_id = $obj->ReplaceSql($_POST['shipping_id']);
	$query="update shippings set shipping_title='".$obj->ReplaceSql($_POST['shipping_title'])."', shipping_desc='".$obj->ReplaceSql($_POST['shipping_desc'])."', tax='".$obj->ReplaceSql($_POST['tax'])."' where shipping_id='".$shipping_id."'";
	$obj->UpdateQuery($query);
	if($_FILES['shipping_image']['name']!=''){
		$photo = array("name"=>$_FILES['shipping_image']['name'],"tmp_name"=>$_FILES['shipping_image']['tmp_name']);
		$obj->FixedUploadImage($photo,"shippings","shipping_image","shipping_id",$shipping_id,88,86);
	}	
	if($_POST['del_charge_ids']!=''){
		$query="delete from shipping_charge where charge_id in (".substr($_POST['del_charge_ids'], 0, -1).")";
		$obj->UpdateQuery($query);
	}
	for($i=0; $i<count($_POST['charge_title']);$i++){
		if($_POST['charge_id'][$i]!=""){
			$query="update shipping_charge set charge_title='" .$obj->ReplaceSql($_POST['charge_title'][$i])."', charge_desc='" .$obj->ReplaceSql($_POST['charge_desc'][$i])."',charge_price='" .$obj->ReplaceSql($_POST['charge_price'][$i])."' where charge_id='".$obj->ReplaceSql($_POST['charge_id'][$i])."' and shipping_id='".$obj->ReplaceSql($_POST['shipping_id'])."'";
			$obj->InsertQuery($query);
		}else{
			$query="insert into shipping_charge set charge_title='" .$obj->ReplaceSql($_POST['charge_title'][$i])."', shipping_id='".$obj->ReplaceSql($_POST['shipping_id'])."', charge_desc='" .$obj->ReplaceSql($_POST['charge_desc'][$i])."',charge_price='" .$obj->ReplaceSql($_POST['charge_price'][$i])."'";
			$obj->UpdateQuery($query);
		}
	}
	$_SESSION['ERRORTYPE'] = "success";
	$_SESSION['ERRORMSG'] = "shipping has been updated successfully!";
	$obj->ReturnReferer();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<?php include_once("inc.head.php"); ?>
</head>
<body>
<?php require_once("message.php");?>
<div class="full">
<h1>Manage Shipping and Packing <?php if($_REQUEST['action']=="edit"){ echo "[Edit]";}elseif($_REQUEST['action']=="add"){ echo "[Add]";} elseif($_REQUEST['action']=="view"){ echo "[View]";} ?></h1>
</div>
<?php if($_REQUEST['action']=="add" || $_REQUEST['action']=="edit"){
	if($_REQUEST['action']=="edit" && isset($_REQUEST['shipping_id'])){
		$query = "select * from shippings where shipping_id='".$_REQUEST['shipping_id']."'";
		$data = $obj->SelectQuery($query);
		$_POST['shipping_title'] = $_POST['shipping_title'] !="" ?  $_POST['shipping_title'] : $data[0]['shipping_title'];
		$_POST['shipping_desc'] = $_POST['shipping_desc'] !="" ?  $_POST['shipping_desc'] : $data[0]['shipping_desc'];
		$_POST['tax'] = $_POST['tax'] !="" ?  $_POST['tax'] : $data[0]['tax'];
		$charge = $obj->SelectQuery("Select * from shipping_charge where shipping_id='".$data[0]['shipping_id']."'");
	}?>
<script language="javascript">
	var introw = <?php echo ($charge) ? count($charge) : 0;?>;
	function addnewrowint(){
		var str = '<div class="rows">'+
	   '<div class="cols5"><input type="hidden" name="charge_id[]" /><a href="javascript:;" class="delete" onclick="if(confirm(\'Are you sure to delete Menu?\')){$(this).parent().parent().remove();}"></a></div>'+
	   '<div class="cols25"><input type="text" title="Charge Title" class="R" name="charge_title[]" /></div>'+
	   '<div class="cols40"><input type="text" title="Charge Description" class="R" name="charge_desc[]" /></div>'+			
	   '<div class="cols30"><input type="text" onkeypress="return numbersonly(this,event);" title="Shipping Charge" class="RisNo" name="charge_price[]" /></div>'+
	'</div>';	
		$('#shipgrid').append(str);
		introw++;
	}
</script>    
<form method="post" enctype="multipart/form-data" action="" name="brandform" id="brandform" onsubmit="return validate(document.forms['brandform']);">
	<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
        <tr>
            <th colspan="2"><?php echo (isset($data)) ? "Edit" : "Add" ;?> Shipping</th>
        </tr>
        <tr>
            <td width="25%"><label id="err_shipping_title">Shipping Title : </label><span class="error">*</span></td>
            <td><input type="text" size="40" title="shipping Title" class="R" name="shipping_title" id="shipping_title" value="<?php echo $_POST['shipping_title'];?>"/>
            </td>
        </tr>
        <tr>
    		<td><label for="shipping_image" id="err_shipping_image">Shipping Image : </label><?php if($data[0]['shipping_image']==''){?><span class="error">*</span><?php }?> (88 x 86)</td>
            <td><div class="full"><input type="file" name="shipping_image" id="shipping_image" class="<?php if($data[0]['shipping_image']==''){echo "R"; }?>isImg" title="Shipping Image"/></div>
                <?php if($data[0]['shipping_image']!=''){?><div class="full paddtop10"><img src="<?php echo WEBSITE_URL."shippings/".$data[0]['shipping_image'];?>" height="88" class="pic" /></div><?php }?>
            </td>
        </tr>
        <tr>
    		<td><label for="shipping_desc" id="err_shipping_desc">Shipping Description : </label></td>
            <td><textarea title="Shipping Description" class="R" name="shipping_desc" id="shipping_desc" cols="40" rows="2"><?php echo $_POST['shipping_desc'];?></textarea></td>
        </tr>
        <tr>
    	<td><label for="Products">Shipping Charges : </label></td>
    	<td colspan="3">                            
            <div class="full grid fullform" id="shipgrid">
                <input type="hidden" id="del_charge_ids" name="del_charge_ids" value="" />
                <div class="rowshdr">
                    <div class="cols5"><a title="Add Charge" class="add" href="javascript:;" onclick="addnewrowint();"></a></div>
                    <div class="cols25"><label>Charge Title</label></div>	
                    <div class="cols40"><label>Charge Description</label></div>
                    <div class="cols30"><label>Shipping Charge</label></div>	
                </div>
                <?php if($charge){ $i=0; foreach($charge as $rows){?>
                <div class="rows">
                	<div class="cols5"><input type="hidden" name="charge_id[]" value="<?php echo $rows['charge_id']?>" />
                    <a href="javascript:;" class="delete" onclick="if(confirm('Are you sure to delete Shipping?')){$(this).parent().parent().remove(); $('#del_charge_ids').val($('#del_charge_ids').val() + '<?php echo $rows['charge_id'];?>,');}"></a>
                    </div>
                    <div class="cols25">
                    	<input type="text" title="Charge Title" class="R" name="charge_title[]" id="charge_title_<?php echo $rows['charge_id'];?>" value="<?php echo $rows['charge_title'];?>"/>
                	</div>
                    <div class="cols40">
                    	<input type="text" title="Charge Description" class="R" name="charge_desc[]" id="charge_desc_<?php echo $rows['charge_id'];?>" value="<?php echo $rows['charge_desc'];?>"/>
                    </div>
                    <div class="cols30">
                    	<input type="text" onkeypress="return numbersonly(this,event);" title="Shipping Charges" class="RisNo" name="charge_price[]" value="<?php echo $rows['charge_price'];?>" id="charge_price_<?php echo $rows['charge_price'];?>"/> 
                	</div>
              	</div>
                <?php $i++; }}?>
            </div>  
        </td>
    </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <?php if($_REQUEST['action']=="edit"){?>
                <input type="hidden" name="shipping_id" value="<?php echo $_REQUEST['shipping_id']?>" />
                <input type="submit" name="btnupdate" value="Update" class="button" />
                <?php }else{?>
                <input type="submit" name="btnsave" value="Add" class="button" />
                <?php }?>
                <input type="button" value="Back" class="button" onclick="window.location='<?php echo $_SESSION['CURRENT_URL']?>';" />
            </td>
        </tr>
	</table>
</form>
<?php }else{ if($_REQUEST['action']==""){$obj->SetCurrentUrl();}?>
<table width="100%" cellspacing="1" cellpadding="3" class="tbl">
    <tr>
    	<th width="5%">Sr. No.</th>
        <th width="25%">shipping Title</th>
        <th width="25%">Shipping Images</th>
        <th width="10%">Action</th>
    </tr> 
<?php 
	$query="select * from shippings";
	$pager = new Pagination($query,$_REQUEST['page'],20,5);
	if($data = $pager->Paging()){
		$i = $pager->GetSNo();
		foreach ($data as $row){ ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row['shipping_title'];?></td>
           	<td><?php echo $obj->ImageExists("shippings",$row['shipping_image']);?></td>
			<td>
				<a class="edit" href="?action=edit&shipping_id=<?php echo $row['shipping_id'];?>"></a>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="4" class="paging"><?php echo $pager->DisplayAllPaging("keyword=".$_GET['keyword']."&alpha=".$_GET['alpha']);?></td>
		</tr>
	<?php } else { ?>
		<tr>
			<td colspan="4" class="error">No shipping Found!</td>
		</tr>
	<?php } ?>   
</table>
<?php } ?>
<?php include_once("footer.php");?>
</body>
</html>