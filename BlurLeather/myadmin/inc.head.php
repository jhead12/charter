<title><?php echo COMPANY_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
<script type="text/javascript" src="js/jquery.ajax.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="<?php echo WEBSITE_URL;?>prettybox/js/jquery.prettyPhoto.js" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo WEBSITE_URL;?>prettybox/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$(".prettybox").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:10000,social_tools:''});
});
function prettyclose(val){
	$("#paths").html("<p>"+val+"</p>");
	$.prettyPhoto.close();
}
</script>