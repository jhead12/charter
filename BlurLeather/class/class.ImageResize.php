<?php
class ImageResize{
   var $image;
   var $image_type;
   function Ratio($reqW,$reqH){
		$W1=$this->getWidth();
		$H1=$this->getHeight();
        $r1 = $W1 / $H1;
        $r2 = $reqW / $reqH;
        if(($H1 > $reqH) && ($W1 > $reqW)){
            if ($r1 > $r2){
                $imgW1 = $reqW;
                $iW1 = $W1 - $reqW;
                $iW1 = ($iW1 / $W1) * 100;
                $iH1 = ($H1 / 100) * $iW1;
                $imgH1 = $H1 - $iH1;
			}elseif ($r1 < $r2){
				$imgH1 = $reqH;
                $iH1 = $H1 - $reqH;
                $iH1 = ($iH1 / $H1) * 100;
                $iW1 = ($W1 / 100) * $iH1;
                $imgW1 = $W1 - $iW1;
			}else{
				$imgH1 = $reqH;
                $imgW1 = $reqW;
			}
		}elseif (($H1 <= $reqH) && ($W1 > $reqW)){
			$imgW1 = $reqW;
			$iW1 = $W1 - $reqW;
			$iW1 = ($iW1 / $W1) * 100;
			$iH1 = ($H1 / 100) * $iW1;
			$imgH1 = $H1 - $iH1;
		}elseif(($H1 > $reqH) && ($W1 <= $reqW)){
			$imgH1 = $reqH;
			$iH1 = $H1 - $reqH;
			$iH1 = ($iH1 / $H1) * 100;
			$iW1 = ($W1 / 100) * $iH1;
			$imgW1 = $W1 - $iW1;
		}elseif(($H1 <= $reqH)&&($W1 <= $reqW)){
			$imgH1 = $H1;
			$imgW1 = $W1;
		}
		$arr = array($imgW1,$imgH1);
		return $arr;
   }
   function resizeToWidthHeight($oldfilename,$newfilename,$W,$H) {
   		$this->load($oldfilename);
		$newarr=$this->Ratio($W,$H);
		$this->resize($newarr[0],$newarr[1]);
		$this->save($newfilename);
   }
   function resizeToCropWidthHeight($oldfilename,$newfilename,$W,$H,$X,$Y,$scale) {
   		$this->load($oldfilename);
		$this->resizeCrop($W,$H,$X,$Y,$scale);
		$this->save($newfilename);
   }
   function fixToWidthHeight($oldfilename,$newfilename,$W,$H) {
   		$this->load($oldfilename);
		$this->resize($W,$H);
		$this->save($newfilename);
   }
   function resizeToHeight($oldfilename,$newfilename,$H) {
		$this->load($oldfilename);
		if($H>$this->getHeight())
			$H = $this->getHeight();
		$ratio = $H / $this->getHeight();
      	$width = (int)($this->getWidth() * $ratio);
      	$this->resize($width,$H);
		$this->save($newfilename);
   }
   function resizeToWidth($oldfilename,$newfilename,$W) {
		$this->load($oldfilename);
		if($W>$this->getWidth())
			$W = $this->getWidth();
		$ratio = $W / $this->getWidth();
		$height = (int) ($this->getheight() * $ratio);	
		$this->resize($W,$height);
		$this->save($newfilename);
   }
   function scale($oldfilename,$newfilename,$scale) {
   		$this->load($oldfilename);
		$width = (int)($this->getWidth() * ($scale)/100);
		$height = (int)($this->getheight() * ($scale)/100); 
		$this->resize($width,$height);
		$this->save($newfilename);
   }
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $compression=100, $permissions=null){
      if( $this->image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth(){
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resize($width,$height) {
	  if( $this->image_type == IMAGETYPE_PNG ) {
         $this->fixPNG($width,$height);
      }else{
		 $new_image = imagecreatetruecolor($width, $height);
	     imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
    	 $this->image = $new_image;
	  }
   }
   function fixPNG($width, $height){
		$resized_image = imagecreatetruecolor($width, $height);
		imagealphablending($resized_image, false); // Overwrite alpha
		imagesavealpha($resized_image, true);
		
		$alpha_image = imagecreatetruecolor($this->getWidth(), $this->getHeight());
		imagealphablending($alpha_image, false); // Overwrite alpha
		imagesavealpha($alpha_image, true);
		for ($x = 0; $x < $this->getWidth(); $x++) {
			for ($y = 0; $y < $this->getHeight(); $y++) {
				$alpha = (imagecolorat($this->image, $x, $y) >> 24) & 0xFF;
				$color = imagecolorallocatealpha($alpha_image, 0, 0, 0, $alpha);
				imagesetpixel($alpha_image, $x, $y, $color);
			}
		}
		imagegammacorrect($this->image, 2.0, 1.0);
		imagecopyresampled($resized_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		imagegammacorrect($resized_image, 1.0, 2.0);
		$alpha_resized_image = imagecreatetruecolor($width, $height);
		imagealphablending($alpha_resized_image, false);
		imagesavealpha($alpha_resized_image, true);
		imagecopyresampled($alpha_resized_image, $alpha_image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		for ($x = 0; $x < $width; $x++){
			for ($y = 0; $y < $height; $y++){
				$alpha = (imagecolorat($alpha_resized_image, $x, $y) >> 24) & 0xFF;
				$rgb = imagecolorat($resized_image, $x, $y);
				$r = ($rgb >> 16 ) & 0xFF;
				$g = ($rgb >> 8 ) & 0xFF;
				$b = $rgb & 0xFF;
				$color = imagecolorallocatealpha($resized_image, $r, $g, $b, $alpha);
				imagesetpixel($resized_image, $x, $y, $color);
			}
		}
		$this->image = $resized_image;
   	}
   function resizeCrop($width, $height, $X, $Y,$scale){
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$new_image = imagecreatetruecolor($newImageWidth,$newImageHeight);
		imagecopyresampled($new_image,$this->image,0,0,$X,$Y,$newImageWidth,$newImageHeight,$width,$height);
		$this->image = $new_image;
   }
}
?>