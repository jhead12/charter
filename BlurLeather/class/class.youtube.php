<?php 
class YouTube{
	function VideoFromUrl($url){ 
		$embed='<iframe title="YouTube video player" width="100%" height="322" src="http://www.youtube.com/embed/'.$this->getVideoCode($url).'" frameborder="0" allowfullscreen></iframe>';
		return $embed;
	}
	function getVideoCode($url){ 
		$url = urldecode($url);
		$url = strstr($url,"?",0);
		$url = str_replace("?v=","",$url);
		if(strpos($url,"&")!=''){
			$url = strstr($url,"&",1);
		}
		return $url;
	}
	function getYoutubeImgurl($url){
		$ecode = $this->getVideoCode($url);
		return $url = "http://img.youtube.com/vi/".$ecode."/1.jpg";
	}
}
?>