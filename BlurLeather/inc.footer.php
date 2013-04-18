<div id="footer">
<ul id="footernav" class="servicenav">
  <li><a href="company_info.php">Company Info</a></li>
  <li><a href="ajax_pages/contact_us.php" rel="superbox[iframe][930x550]">Contact us</a></li>
  <li><a href="privacy_policy.php">Future Product</a></li>
  <li><a href="privacy_policy.php">Privacy policy</a></li>
  <li><a href="sitemap.php">Sitemap</a></li>
</ul>
<?php if($social = $fn->SelectQuery("select * from social_links")){ ?>
  <ul class="share">
    <li class="icon facebook"><?php if($social[0]['facebook_link']!=''){?><a href="<?php echo $social[0]['facebook_link'];?>" target="_blank">Follow us on Facebook</a><?php } ?></li>
    <li class="icon youtube"><?php if($social[0]['youtube_link']!=''){?><a href="<?php echo $social[0]['youtube_link'];?>" target="_blank">Follow us on Youtube</a><?php } ?><</li>
    <li class="icon twitter"><?php if($social[0]['twitter_link']!=''){?><a href="<?php echo $social[0]['twitter_link'];?>" target="_blank">Follow us on Twitter</a><?php } ?><</li>
  </ul>
 <?php } ?> 
  <p class="copy">&copy; 2012 Blur Leather</p>
</div>
<script type="text/javascript" src="js/basic-min.js"></script> 
<script type="text/javascript" src="lightbox/js/jquery.superbox.js"></script>
<script type="text/javascript">
	$(function(){
		$.superbox.settings = {
			closeTxt: "Close",
			loadTxt: "",
			nextTxt: "Next",
			prevTxt: "Previous"
		};
		$.superbox();
	});
	function superopen(url,w,h){
		var iframe = '<iframe src="'+ url +'" name="" frameborder="0" scrolling="auto" width="'+ w +'" height="'+ h +'"></iframe>';
		$.superbox.open(iframe,{boxWidth:w,boxHeight:h});
	}
	function superclose(){
		$.superbox.close();
	}
</script>
<script type="text/javascript" src="js/jquery.ajax.js"></script>
<script type="text/javascript" src="js/jquery.preloader.js"></script>
<script type="text/javascript">
$(function(){
	$("body").preloader();
});
</script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="demo/PanZoom/jquery-panzoom.js"></script>
<script type="text/javascript">
	function initPanZoom() {
		$('#pan img').panZoom({
			'zoomIn'   	: 		$('#zoomin'),
			'zoomOut' 	: 		$('#zoomout'),
			'panUp'		  :		$('#panup'),
			'panDown'		:		$('#pandown'),
			'panLeft'		:		$('#panleft'),
			'panRight'	:		$('#panright'),
			'fit'       :   $('#fit'),
			'destroy'   :   $('#destroy'),
			'out_x1'    :   $('#x1'),
			'out_y1'    :   $('#y1'),
			'out_x2'    :   $('#x2'),
			'out_y2'    :   $('#y2'),
			'directedit':   true,
			'debug'     :   false
		  });
	}
	function zoom_fun(){
		initPanZoom();
		gallery_thumb();
	}
	function boxclose(s,d){
		$('body,html').animate({scrollTop:$('#'+d).offset().top-84},1000);
		setTimeout("$('#"+s+"').html('');",1000);
	}
</script>
<link href="css/slider.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="carouFredSel-5.6.4/jquery.carouFredSel-5.6.4-packed.js"></script>
<script type="text/javascript" language="javascript">
	function gallery_thumb(){
		//	Scrolled by user interaction
		$('#gallery_images').carouFredSel({
			prev: '#prev1',
			next: '#next1',
			pagination: "",
			scroll: 1,
			auto: false
		});
		$('#wear_it_with').carouFredSel({
			prev: '#prev2',
			next: '#next2',
			pagination: "",
			scroll: 1,
			auto: false
		});
	}
	function getsizes(s,d){
		var r = '';
		$(s).each(function(index, element) {
            r += $(this).val()+',';
        });
		r = r.substring(0,r.length-1);
		$(d).val(r);
	}
</script>

