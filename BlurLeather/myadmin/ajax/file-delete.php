<?php set_time_limit(0);
	require_once("../../class/class.functions.php");
	$fn=new Functions();
	if($_POST['from']=='db'){
		if($dt = $fn->SelectQuery("select * from ".$_POST["page"]." where imgid='".$_POST['id']."'")){
			$path = UPLOAD_PATH_ORG.$_POST["page"]."/".$_POST['folder'];
			if(file_exists($path.$dt[0]['img'])){
				unlink($path.$dt[0]['img']);
			}
			if(file_exists($path."th_".$dt[0]['img'])){
				unlink($path."th_".$dt[0]['img']);
			}
			$fn->UpdateQuery("delete from ".$_POST["page"]." where imgid='".$_POST['id']."'");
			echo "File deleted";
		}
	}else{
		unset($_SESSION[$_POST["page"]][$_POST["file"]]);
		if(file_exists(UPLOAD_PATH_ORG.$_POST["page"]."/".$_POST["file"])){
			unlink(UPLOAD_PATH_ORG.$_POST["page"]."/".$_POST["file"]);
		}
		if(file_exists(UPLOAD_PATH_ORG.$_POST["page"]."/th_".$_POST["file"])){
			unlink(UPLOAD_PATH_ORG.$_POST["page"]."/th_".$_POST["file"]);
		}
		echo "File deleted";
	}
?>