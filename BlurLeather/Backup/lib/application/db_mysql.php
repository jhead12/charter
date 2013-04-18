<?php
  function db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE) {
	$link = mysql_connect($server, $username, $password) or db_error("Connect Error", mysql_errno(), mysql_error());
	if ($link) $db = mysql_select_db($database, $link) or db_error("Select Database", mysql_errno(), mysql_error());
    return $link;
  }

  function db_close($link = 'db_link') {
	mysql_close($link);
  }

  function db_query($query, $link = "link_db") {
    $res = mysql_query($query) or db_error($query, mysql_errno(), mysql_error());
    return $res;
  }

  function db_fetch_array($res) {
    $result = array();
    while($array = mysql_fetch_array($res, MYSQL_ASSOC)) {
        $result[count($result)] = $array;       
    }
    return $result;
  }
  
  function db_fetch_row($res) {                   
    $array = mysql_fetch_array($res, MYSQL_ASSOC);
    return $array;
  }
  
  function db_fetch_one($res) {                   
    $array = mysql_fetch_array($res, MYSQL_NUM);
    return $array[0];
  }

  function db_num_rows($res) {
	$num = mysql_num_rows($res);
    return $num;
  }
  
  function escape_string($str) {
    $str = addslashes($str);
    return $str;   
  }
  
  function db_last_insert_id() {
    $res = mysql_query("SELECT LAST_INSERT_ID()");
    $arr = mysql_fetch_array($res, MYSQL_NUM);
    return $arr[0];   
  }

?>