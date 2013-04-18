<?php 
require_once("constants.php");
class DBClass{
	var $DB_LINK;
	function DBClass(){
		$this->DB_LINK = mysql_connect(DB_SERVER_NAME,DB_USER_NAME,DB_USER_PASSWORD) or die("Could not connect to Database.");
		mysql_select_db(DB_DATABASE_NAME,$this->DB_LINK) or die(mysql_error());
	}
	function InsertQuery($query){
		mysql_query($query, $this->DB_LINK) or die(mysql_error());
		return mysql_insert_id();
	}
	function UpdateQuery($query){
		mysql_query($query, $this->DB_LINK) or die(mysql_error());
	}
	function SelectQuery($query){
		$data = array();
		$rs = mysql_query($query, $this->DB_LINK) or die(mysql_error());
		if(mysql_num_rows($rs)>0){
			while($results = mysql_fetch_assoc($rs)){
				$data[] = $results;
			}
			return $data;
		}
		return false;
	}
	function CountQuery($query){
		$data = array();
		$rs = mysql_query($query, $this->DB_LINK) or die(mysql_error());
		return mysql_num_rows($rs);
	}
	function ValueExists($tablename,$column,$value,$columnid="",$requestid=""){
		if($value!=""){			
			$q="select $column from $tablename where $column='".$value."'".(($columnid!='') ? " and " .  $columnid ."!='".$requestid."'":'');
			$q=mysql_query($q, $this->DB_LINK) or die(mysql_error());
			if ($row=mysql_fetch_assoc($q)){
				return true;
			}else{
				return false;
			}
		} else {
			return false;
		}
	}
	function GetValue($tablename,$column,$where=""){
		$q="select $column from $tablename ".(($where!='') ? " where " .  $where :"");
		$q=mysql_query($q, $this->DB_LINK) or die(mysql_error());
		if ($row=mysql_fetch_array($q)){
			return $row[0];
		}else{
			return false;
		}
	}
}
?>