<?php require_once("../class/class.admin.php");
require_once("../class/class.ImageResize.php");
if($_FILES['_img']['name']!=''){
	$IM = new ImageResize();
	$ret = '';
	for ($i=0; $i<count($_FILES['_img']['name']);$i++){
		$photo = array("name"=>$_FILES['_img']['name'][$i],"tmp_name"=>$_FILES['_img']['tmp_name'][$i]);
		$file_arr = explode(".",$photo['name']);
		$ext = strtolower($file_arr[count($file_arr)-1]);
		$new_name=time().rand(1000,9999).".".$ext;
		$IM->resizeToWidthHeight($photo['tmp_name'],"../".$_GET['type']."/".$new_name,600,600);
		$ret .= WEBSITE_URL."/".$_GET['type']."/".$new_name."<br>";
	}	
	echo "<script type='text/javascript'>window.parent.prettyclose('".$ret."');</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
<title>Admin Panel</title>
<script type="text/javascript" src="js/jquery.ajax.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#_img').change(function(){
		document.forms['brandform'].submit(); $('#mdiv').fadeOut(0);$('#pdiv').fadeIn(1000);
	});
});
</script>
</head>
<body>
<?php require_once("message.php");?>
	<form method="post" enctype="multipart/form-data" name="brandform" id="brandform">
        <table cellspacing="1" cellpadding="5" align="center">
            <tr>
				<td valign="top" width="100" align="right">Upload Image</td>
                <td width="200">
                	<div id="mdiv"><input type="file" name="_img[]" id="_img" /></div>
                    <div id="pdiv" style="display:none;background:url(images/fbloader.gif) left center no-repeat; padding:5px; width:100px; height:100px"></div>
                </td>
			</tr>
		</table>
   	</form>
<?php include "footer.php";?>
</body>
</html>