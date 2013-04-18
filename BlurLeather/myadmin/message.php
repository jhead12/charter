<div id='error-data'<?php echo ((isset($_SESSION['ERRORTYPE'])) ? ' style="display:block"' : '');?>>
<?php if(isset($_SESSION['ERRORTYPE'])){
	echo '<div>'.$_SESSION['ERRORMSG']."</div>";
	echo "<script>$('#error-data').fadeIn(1000); setTimeout(\"$('#error-data').fadeOut(1000);\",10000);</script>";
}?>
</div>
<div class="clear"></div>