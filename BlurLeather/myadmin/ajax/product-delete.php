<?php set_time_limit(0);
	require_once("../../class/class.functions.php");
	$fn=new Functions();
	if($_POST['from']=='db'){
		if($dt = $fn->SelectQuery("select * from product_gallery where gallery_id='".$_POST['id']."'")){
			$path = UPLOAD_PATH_ORG."product_gallery/".$dt[0]['product_id']."/".$dt[0]['color_id']."/";
			if(file_exists($path.$dt[0]['img'])){
				unlink($path.$dt[0]['img']);
			}
			if(file_exists($path."th_".$dt[0]['img'])){
				unlink($path."th_".$dt[0]['img']);
			}
			$fn->UpdateQuery("delete from product_gallery where gallery_id='".$_POST['id']."'");
			echo "File deleted";
		}
	}else{
		unset($_SESSION[$_POST["page"]][$_POST['index']][$_POST["file"]]);
		if(file_exists(UPLOAD_PATH_ORG.$_POST["page"]."/".$_POST["file"])){
			@unlink(UPLOAD_PATH_ORG.$_POST["page"]."/".$_POST["file"]);
		}
		if(file_exists(UPLOAD_PATH_ORG.$_POST["page"]."/th_".$_POST["file"])){
			@unlink(UPLOAD_PATH_ORG.$_POST["page"]."/th_".$_POST["file"]);
		}
		echo "File deleted";
	}
?>