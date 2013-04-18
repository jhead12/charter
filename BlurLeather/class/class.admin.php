<?php
require_once("constants.php");
require_once("class.ImageResize.php");
require_once("class.mydb.php");
class Admin extends DBClass{
	function ReplaceSql($str){
		$str = trim(stripslashes($str));
		$str = str_replace("\\","",$str);
		$str = str_replace("'","\'",$str);
		return $str;
	}
	function ImgReplace($str){
		$str = trim(stripslashes($str));
		$str = str_replace("\\","",$str);
		$str = str_replace("'","\'",$str);
		$str = str_replace("#","-",$str);
		$str = str_replace(" ","-",$str);
		$str = str_replace("+","-",$str);
		return $str;
	}
	function MakeHTML($str){
		$str = $this->HTMLSql($str);
		$str = str_replace("\n","<br>",$str);
		return $str;
	}
	function HTMLSql($str){
		$str = trim(stripslashes($str));
		$str = str_replace("\\","",$str);
		$str = str_replace("'","\'",$str);
		$str = str_replace("<","&lt;",$str);
		$str = str_replace(">","&gt;",$str);
		return $str;
	}
	function Decrypt($string) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr(ENCRYPT_KEY, ($i % strlen(ENCRYPT_KEY))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
    }
    function Encrypt($string) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr(ENCRYPT_KEY, ($i % strlen(ENCRYPT_KEY))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
		return base64_encode($result);
    }
	function SetCurrentUrl(){
		$_SESSION['CURRENT_URL'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	function SetCurrentUrlAjaxPages(){
		$_SESSION['CURRENT_URL_AJAX'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	function ReturnReferer(){
		header("Location:".$_SESSION['CURRENT_URL']);
	}
	function ReturnRefererAjaxPages(){
		header("Location:".$_SESSION['CURRENT_URL_AJAX']);
	}
	function AlreadyLogin(){
		if($_SESSION['ADMIN_LOGIN']==TRUE){ 
			header("Location:main.php");
		}	
	}
	function RequireLogin($s=TRUE){
		if($_SESSION['ADMIN_LOGIN']){ 
				return true;
		}else{
			header("Location:index.php");
		}
	}
	function CheckShows($val){
		$query="select show_status from shows where show_status='".$val."'";
		if($data = $this->SelectQuery($query)){
			if($data[0]['show_status']=="Current"){
				return true;
			}else{
				return false;
			}
		}
		return false;
	}
	function LogOut(){
		unset($_SESSION['ADMIN_LOGIN']);
		unset($_SESSION['ADMIN_USER']);
		unset($_SESSION['GROUP_ID']);
		unset($_SESSION['ADMIN_USER_ID']);
		unset($_SESSION['ADMIN_NAME']);
		unset($_SESSION['PAGE_NAME']);
		unset($_SESSION['CURRENT_URL']);
		unset($_SESSION['CURRENT_URL_AJAX']);
		header("Location:index.php");
	}
	function PreCategoryValueExists($tablename,$column,$value,$columnid="",$requestid="",$precategory=""){
		if($value!=""){
			$query="select $column from $tablename where ".(($precategory!='') ? " pre_category_id=".$precategory." and ":'')." $column='".$value."'".(($columnid!='') ? " and " .  $columnid ."!='".$requestid."'":'');
			if($data = $this->SelectQuery($query)){
				return true;
			}else{
				return false;
			}
		} else {
			return false;
		}
	}
	
	function MultipleProductImages($session_tmp,$index,$pid,$cid){
		$path = UPLOAD_PATH_ORG."product_gallery/".$pid;
		if(!file_exists($path)){mkdir($path);}
		$path .= "/".$cid;
		if(!file_exists($path)){mkdir($path);}
		if(count($_SESSION[$session_tmp][$index])>0){
			foreach($_SESSION[$session_tmp][$index] as $key => $val){
				$arr = explode("|",$val);
				$key = $this->ImgReplace($key);
				if(file_exists(UPLOAD_PATH_ORG.$arr[0]."/".$key)==true){
					copy(UPLOAD_PATH_ORG.$arr[0]."/".$key, $path."/".$key);
					unlink(UPLOAD_PATH_ORG.$arr[0]."/".$key);
				}
				if(file_exists(UPLOAD_PATH_ORG.$arr[0]."/th_".$key)==true){
					copy(UPLOAD_PATH_ORG.$arr[0]."/th_".$key, $path."/th_".$key);
					unlink(UPLOAD_PATH_ORG.$arr[0]."/th_".$key);
				}
				$this->InsertQuery("insert into product_gallery set img='".$key."', product_id='".$pid."', color_id='".$cid."'");
			}
		}
		unset($_SESSION[$session_tmp][$index]);
	}
	function MultipleSessionImages($session_tmp,$dir_table,$field_nm,$table_id,$id,$options=""){
		$path = UPLOAD_PATH_ORG.$dir_table."/".$dir_table."_".$id;
		if(!file_exists($path)){mkdir($path);}
		if(count($_SESSION[$session_tmp])>0){
			foreach($_SESSION[$session_tmp] as $key => $val){
				$arr = explode("|",$val);
				$key = $this->ImgReplace($key);
				if(file_exists(UPLOAD_PATH_ORG.$arr[0]."/".$key)==true){
					copy(UPLOAD_PATH_ORG.$arr[0]."/".$key, $path."/".$key);
					unlink(UPLOAD_PATH_ORG.$arr[0]."/".$key);
				}
				if(file_exists(UPLOAD_PATH_ORG.$arr[0]."/th_".$key)==true){
					copy(UPLOAD_PATH_ORG.$arr[0]."/th_".$key, $path."/th_".$key);
					unlink(UPLOAD_PATH_ORG.$arr[0]."/th_".$key);
				}
				$this->InsertQuery("insert into ".$dir_table." set ".$field_nm."='".$key."', ".$table_id."='".$id."' ".$options);
			}
		}
		unset($_SESSION[$session_tmp]);
	}


	function ResizeUploadImage($file,$table_name,$dbcolumn,$where_column,$id,$width,$height,$th_width=0,$th_height=0,$thumb=false){
		$filename=str_replace(" ","-",trim($file['name']));
		$file_arr = explode(".",$filename);
		$ext = strtolower($file_arr[count($file_arr)-1]);
		if ($ext=="jpg" || $ext=="jpeg" || $ext=="png" || $ext=="gif"){
			$path = "../".$table_name."/";
			$newfilename = time()."-".rand(99,999).uniqid().".".$ext;
			$IM = new ImageResize();
			$IM->resizeToWidthHeight($file['tmp_name'],$path.$newfilename,$width,$height);
			if($thumb==true){
				$IM->fixToWidthHeight($file['tmp_name'],$path."th_".$newfilename,$th_width,$th_height);
			}
			$this->UpdateQuery("update ".$table_name." set ".$dbcolumn."='".$newfilename."' where ".$where_column."='".$id."'");
		}
	}
	
	function FixedUploadImage($file,$table_name,$dbcolumn,$where_column,$id,$width,$height,$th_width=0,$th_height=0,$thumb=false){
		$filename=str_replace(" ","-",trim($file['name']));
		$file_arr = explode(".",$filename);
		$ext = strtolower($file_arr[count($file_arr)-1]);
		if ($ext=="jpg" || $ext=="jpeg" || $ext=="png" || $ext=="gif"){
			$path = "../".$table_name."/";
			if(!file_exists($path)){mkdir($path);}
			$newfilename = time()."-".rand(99,999).uniqid().".".$ext;
			$IM = new ImageResize();
			$IM->fixToWidthHeight($file['tmp_name'],$path.$newfilename,$width,$height);
			if($thumb==true){
				$IM->fixToWidthHeight($file['tmp_name'],$path."th_".$newfilename,$th_width,$th_height);
			}
			$this->UpdateQuery("update ".$table_name." set ".$dbcolumn."='".$newfilename."' where ".$where_column."='".$id."'");
		}
	}
	function DeleteImage($dir,$img,$thumb=false){
		if($dir!='' && $img!=''){
			if(file_exists(UPLOAD_PATH_ORG.$dir."/".$img)===TRUE){
				unlink(UPLOAD_PATH_ORG.$dir."/".$img);
			}
			if($thumb==true){
				if(file_exists(UPLOAD_PATH_ORG.$dir."/th_".$img)===TRUE){
					unlink(UPLOAD_PATH_ORG.$dir."/th_".$img);
				}
			}
		}
	}
	function ImageExists($dir,$img,$width=50){
		if($dir!='' && $img!=''){
			if(file_exists(UPLOAD_PATH_ORG.$dir."/".$img)===TRUE){
				return '<img src="'.WEBSITE_URL.$dir.'/'.$img.'" alt="" width="'.$width.'"/>';
			}	
		}
		return 'No Image';
	}
	function MakeXMLTag($val){
		$val = strip_tags($val);
		$val = str_replace("&nbsp;"," ",$val);
		$val = str_replace("&","and",$val);
		return $val;
	}

	
	function SendEmail($emailto,$emailfrom,$namefrom,$body,$subject,$CC="",$BCC = ""){
		if(SEND_MAIL){
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From: '.$namefrom.'<'.$emailfrom.'>' . "\r\n";
			if($CC!=""){
				$headers .= 'Cc: '.$CC.'' . "\r\n";
			}
			if($BCC!=""){
				$headers .= 'Bcc: '.$BCC.'' . "\r\n";
			}
			@mail($emailto,$subject,$body,$headers);			
		}else{
			echo $body;
		}
	}
	
}
?>