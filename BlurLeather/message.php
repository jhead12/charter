<div id="error-data" class="<?php echo ((isset($_SESSION['ERRORTYPE'])) ? $_SESSION['ERRORTYPE'] : 'error');?>">
<?php if(isset($_SESSION['ERRORTYPE'])){
    echo '<div>'.$_SESSION['ERRORMSG']."</div>";
    echo "<script>$('#error-data').fadeIn(1000); setTimeout(\"$('#error-data').fadeOut(1000);\",10000);</script>";
}?>
</div>
<?php if($_SERVER['REQUEST_METHOD']!='POST'){ unset($_SESSION['ERRORTYPE']);unset($_SESSION['ERRORMSG']);}?>