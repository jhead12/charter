<?php
require_once("class.mydb.php");
class Pagination extends DBClass{
	private $Conn;
	var $RowsPerPage;
	var $LinksPerPage;
	var $CurrentPage;
	var $TotalRows;
	var $Offset;
	var $TotalPage;
	var $LinkStart;
	var $LinkEnd;
	var $SqlQuery;
	var $Debug;
	function __construct($sql_query, $current_page, $rows_perpage = 20, $links_perpage = 5){
		$this->Conn = new DBClass();
		$this->SqlQuery = $sql_query;
		$this->RowsPerPage = $rows_perpage;
		$this->LinksPerPage = $links_perpage;
		$this->CurrentPage = ($current_page!='')?$current_page:'1';
	}
	function GetSNo(){
		return $this->Offset + 1;
	}
	function SetDebug($val){
		$this->Debug = $val;
	}
	function Paging(){
		$this->TotalRows = $this->Conn->CountQuery($this->SqlQuery);
		$this->Offset = $this->RowsPerPage * ($this->CurrentPage - 1);
		$this->SqlQuery .= " limit " . $this->Offset . "," . $this->RowsPerPage;
		$this->TotalPage = ceil($this->TotalRows / $this->RowsPerPage);
		$this->LinkStart = $this->CurrentPage - floor($this->LinksPerPage / 2);
		$this->LinkEnd = $this->CurrentPage + floor($this->LinksPerPage / 2);
		
		if($this->LinkStart <= 0){
			$this->LinkStart = 1;
			if($this->LinksPerPage <= $this->TotalPage)
				$this->LinkEnd = $this->LinksPerPage;
		}
		if($this->LinkEnd > $this->TotalPage){
			$this->LinkEnd = $this->TotalPage;
			if($this->LinksPerPage<= $this->TotalPage)
				$this->LinkStart = $this->LinkEnd - $this->LinksPerPage + 1;
		}
		return $this->Conn->SelectQuery($this->SqlQuery);
	}
	function DisplayFirst($param = ''){
		if($param!=''){$param .= '&';}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage > 1){
				return '<a href="?'.$param.'page=1">First</a> ';
			}
			//return '<b>First</b>';
		}
		return '';
	}
	function DisplayPrev($param = ''){
		if($param!=''){$param .= '&';}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage > 1){
				return '<a href="?'.$param.'page='. ($this->CurrentPage - 1). '">Prev</a> ';
			}
			//return '<b>Prev</b>';
		}
		return '';
	}
	function DisplayNext($param = ''){
		if($param!=''){$param .= '&';}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage < $this->TotalPage){
				return '<a href="?'.$param.'page='.($this->CurrentPage + 1).'">Next</a> ';
			}
			//return '<b>Next</b>';
		}
		return '';
	}
	function DisplayLast($param = ''){
		if($param!=''){$param .= '&';}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage < $this->TotalPage){
				return '<a href="?'.$param.'page=' .$this->TotalPage. '">Last</a> ';
			}
			//return '<b>Last</b>';
		}
		return '';
	}
	function DisplayRandom($param = ''){
		$str = '';
		if($param!=''){$param .= '&';}
		if($this->LinkEnd > $this->LinkStart){
			for($i = $this->LinkStart; $i <= $this->LinkEnd; $i++){
				if($i == $this->CurrentPage){
					$str .= '<b>'.$i.'</b> ';
				}else{
					$str .= '<a href="?'.$param.'page='.$i.'">'. $i. '</a> ';
				}
			}
		}
		return $str;
	}
	function DisplayNextPrev($param = ''){
		return $this->DisplayFirst($param) . $this->DisplayPrev($param) . $this->DisplayNext($param) . $this->DisplayLast($param);
	}
	function DisplayAllPaging($param = ''){
		return $this->DisplayFirst($param) . $this->DisplayPrev($param) . $this->DisplayRandom($param) . $this->DisplayNext($param) . $this->DisplayLast($param);
	}
	function DisplayAjaxPaging($apage,$param,$rec){
		$str = '';
		if($param!=''){	$param .= '&';}
		
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage > 1){
				$str .= '<li class="prev"><a href="#page1" onclick="senddata(\''.$apage.'\',\''.$param.'page=1\',\''.$rec.'\');"></a></li>';
			}
		}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage > 1){
				$str .= '<li class="prev"><a href="#page'.($this->CurrentPage - 1).'" onclick="senddata(\''.$apage.'\',\''.$param.'page='.($this->CurrentPage - 1).'\',\''.$rec.'\');">‹</a></li>';
			}
		}
		if($this->LinkEnd > $this->LinkStart){
			for($i = $this->LinkStart; $i <= $this->LinkEnd; $i++){
				if($i == $this->CurrentPage){
					$str .= '<li class="current">'.$i.'</li> ';
				}else{
					$str .= '<li><a href="#page'.$i.'" onclick="senddata(\''.$apage.'\',\''.$param.'page='.$i.'\',\''.$rec.'\');">'. $i. '</a></li>';
				}
			}
		}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage < $this->TotalPage){
				$str .= '<li class="next"><a href="#page'.($this->CurrentPage + 1).'" onclick="senddata(\''.$apage.'\',\''.$param.'page='.($this->CurrentPage + 1).'\',\''.$rec.'\');">›</a><li>';
			}
		}
		if($this->LinkEnd > $this->LinkStart){
			if($this->CurrentPage < $this->TotalPage){
				$str .= '<li class="next"><a href="#page'.$this->TotalPage.'" onclick="senddata(\''.$apage.'\',\''.$param.'page='.$this->TotalPage.'\',\''.$rec.'\');"></a></li> ';
			}
		}
		return $str;
	}
}
?>