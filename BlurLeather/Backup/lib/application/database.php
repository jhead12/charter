<?php
  require("db_".RDBMS.".php");

  function db_error($query, $errno, $error) {
  if(ini_get('display_errors') == 1)
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br>'
  	  . $query . '<br>'
  	  . '<small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
  else
    die('');
  }

?>