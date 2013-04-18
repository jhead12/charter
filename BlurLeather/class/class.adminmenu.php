<?php
require_once("class.mydb.php");
class Menu{
	function ShowMenu(){
		$str = '<ul class="topmenu">';
		$db = new DBClass();
		$data = $db->SelectQuery("select * from forms where ParentId=0 order By DisplayOrder");
        foreach ($data as $row){
			$str .= '<li><a>'.$row['FormName'].'</a>';
			$data2 = $db->SelectQuery("select * from forms where ParentId='".$row['FormId']."' order By DisplayOrder");
            if($data2){
				$str .= '<ul>';
				foreach ($data2 as $row){
	                $str .= '<li><a href="'.$row['FormCode'].'">'.$row['FormName'].'</a></li>';
				}
				$str .= '</ul>';
			}
			$str .= '</li>';
		}
        $str .='</ul>';
		return $str;
	}
} ?>