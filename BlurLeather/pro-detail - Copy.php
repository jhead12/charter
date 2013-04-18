<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/pro-style.css" media="screen,print">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://raw.github.com/brandonaaron/jquery-mousewheel/master/jquery.mousewheel.js"></script>
<script type="text/javascript" src="demo/PanZoom/jquery-panzoom.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="demo/PanZoom/example/style.css" />
<script type="text/javascript">
	$(document).ready(function () {
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
};

initPanZoom();
	// init the image switcher
	$('#images img').bind('click', function () {
		$('#pan img').attr('src', $(this).attr('src'));
	});

// init the init button (for testing destroy/recreate)
$('#reinit').bind('click', function (event) {
  if ($('#pan img').data('panZoom')) {
	alert('Click destroy before trying to re-initialise panZoom');
	return;
  }
  event.preventDefault();
  initPanZoom();
});

	});
</script>

</head>
<body class="resized">
<div id="container">
  <div class="content">
	<div class="col" style="width:48% !important; float:left; border-right:1px solid #000;">
    	
	<iframe src="demo/PanZoom/example/index.html" height="700" width="99%"></iframe>
	</div>
<div class="col" style="width:48% !important;float:left;">
<div class="pdinfo">
  <h2 class="h1" itemprop="name">Velvet Collar Overcoat</h2>
  <h3 class="h2">New Season</h3>
  <div class="price js_price" itemprop="offerDetails" itemscope="itemscope" itemtype="http://data-vocabulary.org/Offer"><span itemprop="price">£1,095.00</span></div>
  <div class="full">
  	<a href="" class="detail-menu">Description</a> 
    <a href="" class="detail-menu pad-left10">Delivery</a>
    <a href="" class="detail-menu pad-left10 last">Return Policy</a>
  </div>
  <div class="desc">
  Black crepe wool cropped trousers with front seams, concealed front fly zip closure, v-cut back and white cotton cuff detail at trouser hems.
  </div>
  <div class="desc">Need more help? <a href="#">Contact us</a></div>
  <div class="full">
  	<span class="color-div">Color</span>
    <a href="" class="clr-select"></a>
  </div>
  <div class="formrow"> 
  	<span class="label">Colour</span>
    <ul class="select color">
      <li class="selected"> <a href="#" class="swatch js_stack" style="background-image:url(imagers/swatch/QX571_1202_swatch.jpg);;">ANTHRACITE</a>
        <div class="pdtooltip">ANTHRACITE</div>
      </li>
    </ul>
  </div>
  <div class="formrow"> <span class="label">Size</span>
    <ul class="select size">
      <li selected="selected" class="selected" data-value="44" data-variantid="804838715" data-pricebest="£1,095.00"> 44 </li>
      <li class="unavailable" data-value="46" data-variantid="804838716" data-pricebest="£1,095.00"> 46 </li>
      <li class="" data-value="48" data-variantid="804838717" data-pricebest="£1,095.00"> 48 </li>
      <li class="" data-value="50" data-variantid="804838718" data-pricebest="£1,095.00"> 50 </li>
      <li class="" data-value="52" data-variantid="804838719" data-pricebest="£1,095.00"> 52 </li>
    </ul>
  </div>
  <div class="buttonbar"> <span class="button primary js_addtocart" data-available="Add to Bag" data-unavailable="Unavailable" data-instocksoon="Coming soon..." xtcltype="A" xtclib="Shopping-Bag-Add::804838715">Add to Bag</span> <span class="button secondary BlurLeather js_mymq_add" data-id="804838715" data-type="products" xtcltype="A" xtclib="BlurLeather::291379QX571">Add to BlurLeather</span> </div>
  <ul class="share">
    <li>
       <li class="icon facebook"> <a href="#" target="_blank" xtclib="Share::Twitter::804838715">Tweet this</a> </li>
    </li>
    <li class="icon twitter"> <a href="#" target="_blank" xtclib="Share::Twitter::804838715">Tweet this</a> </li>
    <li class="icon tumblr"><a href="#" title="Share on Tumblr" target="_blank">Share on Tumblr</a></li>
    <li class="icon fancy"><a href="#" target="_blank">Fancy it</a></li>
    <li class="icon mail js_open" data-href="#" xtclib="SendMail::804838715">Mail this</li>
  </ul>
  <h4 class="h3">Wear with</h4>
  <div class="carousel">
    <div class="frame">
      <ul class="js_list" style="width:100%;">
        <li> <a href="#"><img src="imgs/255023_QX565_1000_A_81x81.jpg" alt="Black Checked Wool Trousers" data-format="81x81" data-viewtype="A" height="81" width="81"></a> </li>
        <li> <a href="#"><img src="imgs/179605_QX660_1073_A_81x81.jpg" alt="Graphite Stripe Suiting Waistcoat" data-format="81x81" data-viewtype="A" height="81" width="81"></a> </li>
        <li> <a href="#"><img src="imgs/255023_QX565_1000_A_81x81.jpg" alt="Black Checked Wool Trousers" data-format="81x81" data-viewtype="A" height="81" width="81"></a> </li>
        <li> <a href="#"><img src="imgs/296981_QX686_3420_A_81x81.jpg" alt="Tonal Charcoal Embroidered Skull Polo-Shirt" data-format="81x81" data-viewtype="A" height="81" width="81"></a> </li>
      </ul>
    </div>
  </div>
</div>
</div>
<div class="logo">Blur Leather</div>
</div>
  <div class="promodrawer js_promodrawer">
      <h6><span class="js_scroll">More about this product</span></h6>
      <ul class="promos promo2">
        <li style="background-image:url(slider/f1.jpg);"> <a href="#" class="js_stack">
          <div> </div>
          </a> </li>
        <li style="background-image:url(slider/f2.jpg);"> <a href="#" class="js_stack">
          <div> </div>
          </a> </li>
      </ul>
    </div>
</div>
<link rel="stylesheet" href="lightbox/css/jquery.superbox.css" type="text/css" media="all" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="lightbox/js/jquery.superbox.js"></script>
<script type="text/javascript">
		$(function(){
			$.superbox.settings = {
				closeTxt: "Close",
				loadTxt: "Loading...",
				nextTxt: "Next",
				prevTxt: "Previous"
			};
			$.superbox();
		});
		function abc(){
			alert("sdfdsfs");
			$.hideAll();
			//$.superbox.hideAll();	
		}
	</script>
</body>
</html>