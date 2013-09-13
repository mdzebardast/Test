<?php
/*
 * FARHANG NOVIN CORPORATION
 * Copyright 2008 Farhang Novin Corporation.
 * All Rights Reserved
 */

class FN_Image{

	/**
	 * version of gd library;
	 * @var string
	 * @access private
	 */
	var $gdInfo;

	/**
	 * quality level (between 1 - 100)
         * Only for PRO version	 
	 * @var integer
	 * @access private
	 */
	var $qualityLevel;

	/**
	 * string for which the GD has no support;
	 * @var string
	 * @access private
	 */
	var $gdNoSupport;

	/**
	 * imgtype for GD manipulation (gif, jpg, png);
	 * @var string
	 * @access private
	 */
	var $imgType;

	/**
	 * Constructor. Set default values for some variables
	 * @access public
	 */
	function __construct() {
		$this->getVersionGd();
		$this->gdNoSupport = '';
		$this->qualityLevel = 80;
	}

	/**
	 * return the version of the GD;
	 * @return string return the version of the GD;
	 * @access public
	 */
	function getVersionGd()
	{
		ob_start();
		phpinfo(8);
		$phpinfo = ob_get_contents();
		ob_end_clean();
		$phpinfo = strip_tags($phpinfo);
		$phpinfo = stristr($phpinfo, "gd version");
		$phpinfo = stristr($phpinfo, "version");
		if ($phpinfo === false && function_exists('gd_info')) {
			$phpinfo = gd_info();
			$phpinfo = $phpinfo['GD Version'];
		}
		$end = strpos($phpinfo, ".");
		$phpinfo = substr($phpinfo, 0, $end);
		$length = strlen($phpinfo) - 1;
		$phpinfo = substr($phpinfo, $length);
		$this->gdInfo = $phpinfo;
		return $phpinfo;
	}

	/**
	 * makes an thumbnailout of an image using GD library;
	 * @param string $sourceFileName  path to the source file;
	 * @param string $folder path to the destination file (without filename);
	 * @param string $destinationFileName  name of the destination file;
	 * @param integer $newWidth  new width of the file
	 * @param integer $newHeight  new hight of the file;
	 * @param boolean $keepProportion if the proportion must be kept or not;
	 * @return nothing;
	 * @access private
	 */
	function Thumbnail($sourceFileName, $folder, $destinationFileName, $newWidth, $newHeight, $keepProportion){
		if(!file_exists($folder . $destinationFileName)){
			$newWidth = (int)$newWidth;
			$newHeight = (int)$newHeight;
			if (!$this->gdInfo >= 1 || !$this->checkGdFileType($sourceFileName)) {
				return false;
			}
			$img = &$this->getImg($sourceFileName);
			$srcWidth = ImageSX($img);
			$srcHeight = ImageSY($img);
	
			if ( $keepProportion && ($newWidth != 0 && $srcWidth<$newWidth) && ($newHeight!=0 && $srcHeight<$newHeight) ) {
				if ($sourceFileName != $folder . $destinationFileName) {
					@copy($sourceFileName, $folder . $destinationFileName);
				}
				return true;
			}
			
			if ($keepProportion == true) {
				if ($newWidth != 0 && $newHeight != 0) {
					$ratioWidth = $srcWidth/$newWidth;
					$ratioHeight = $srcHeight/$newHeight;
					if ($ratioWidth < $ratioHeight ) {
						$destWidth = $srcWidth/$ratioHeight;
						$destHeight = $newHeight;
					} else {
						$destWidth = $newWidth;
						$destHeight = $srcHeight/$ratioWidth;
					}
				} else {
					if ($newWidth != 0) {
						$ratioWidth = $srcWidth/$newWidth;
						$destWidth = $newWidth;
						$destHeight = $srcHeight/$ratioWidth;
					} else if ($newHeight != 0) {
						$ratioHeight = $srcHeight/$newHeight;
						$destHeight = $newHeight;
						$destWidth = $srcWidth/$ratioHeight;
					} else {
						$destWidth = $srcWidth;
						$destHeight = $srcHeight;
					}
				}
			} else {
				$destWidth = $newWidth; 
				$destHeight = $newHeight; 
			}
			$destWidth = round($destWidth);
			$destHeight = round($destHeight);
			if ($destWidth < 1) $destWidth = 1;
			if ($destHeight < 1) $destHeight = 1;
			
			$destImage = &$this->getImageCreate($destWidth, $destHeight); 
			
			$this->getImageCopyResampled($destImage, $img, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
			ImageDestroy($img);
			$img = &$destImage;
			$this->createNewImg($img, $folder . $destinationFileName, $this->qualityLevel);
			return true;
		} else {
			return;
		}
	}

	/**
	 * verify the rights on the giving folder;
	 * @param string $img image handle;
	 * @param string $file filename (including path), to save the;
	 * @param integer $qualityLevel quality level (used with jpg pictures);
	 * @return nothing;
	 * @access private
	 */
	function createNewImg(&$img, $file, $qualityLevel='')
	{
		touch($file);
		switch ($this->imgType) {
			case 'gif':
				imagegif($img, $file);
				break;
			case 'jpg':
				if ($qualityLevel>0) {
					imagejpeg($img, $file, $qualityLevel);
				} else {
					imagejpeg($img, $file);
				}
				break;
			case 'png':
				imagepng($img, $file);
				break;
		}	
		imagedestroy($img);
	}


	/**
	 * 	wrapper for ImageCopyResampled/ImageCopyResized;
	 * @param integer $destImage  image handle for destination image;
	 * @param integer $img  image handle of source image;
	 * @param integer $x1 x from top left for destinantion image;
	 * @param integer $y1 y from top left for destinantion image;
	 * @param integer $x2 x from top left for source image;
	 * @param integer $y2 y from top left for source image;
	 * @param integer $destWidth  width for destination file;
	 * @param integer $destHeight  height for destination file;
	 * @param integer $srcWidth width for source file;
	 * @param integer $srcHeight height for source file;
	 * @return nothing;
	 * @access private
	 */
	function getImageCopyResampled(&$destImage, &$img, $x1, $y1, $x2, $y2, $destWidth, $destHeight, $srcWidth, $srcHeight)
	{
		if (function_exists('imagecopyresampled') && $this->gdInfo>=2) {
			@ImageCopyResampled($destImage, $img, $x1, $y1, $x2, $y2, $destWidth, $destHeight, $srcWidth, $srcHeight);
		} else {
			@ImageCopyResized($destImage, $img, $x1, $y1, $x2, $y2, $destWidth, $destHeight, $srcWidth, $srcHeight);
		}	
	}



	/**
	 * return an image handle or set an error if not succeded;
	 * @param string $sourceFileName path to the source file;
	 * @return integer image handle to the image if succeded or set error;
	 * @access private
	 */
	function &getImg($sourceFileName)
	{
		$arr = getimagesize($sourceFileName);
		
		if (is_array($arr)) {
			switch ($arr[2]) {
				case 1:
					$img = imagecreatefromgif($sourceFileName);
					$this->imgType = 'gif';
					return $img;
					break;
				case 2:
					$img = imagecreatefromjpeg($sourceFileName);
					$this->imgType = 'jpg';
					return $img;
					break;
				case 3:
					$img = imagecreatefrompng($sourceFileName);
					$this->imgType = 'png';
					return $img;
					break;
			}
		}
	}


	/**
	 * wrapper for imagecreatetruecolor/imagecreate;
	 * @param integer $destWidth width of the file
	 * @param integer $destHeight  height of the  file;
	 * @return integer image handle;
	 * @access private
	 */
	function &getImageCreate($destWidth, $destHeight)
	{
		if (function_exists('imagecreatetruecolor') && $this->gdInfo>=2) {
			$image = imagecreatetruecolor($destWidth, $destHeight);
			imagecolorallocate($image, 0, 0, 0);
			$transparent = imagecolorallocate($image, 255, 0, 0);
			imagecolortransparent($image, $transparent);  
		} else {
			$image = imagecreate($destWidth, $destHeight);
		}
		return $image;
	} 


	/**
	 * check if GD support the type of picture;
	 * @param string $sourceFileName  path to the source file;
	 * @return boolean true if GD support the type of picture false if not;
	 * @access private
	 */
	function checkGdFileType($filename)
	{
		$this->gdNoSupport = '';
		$arr = @getimagesize($filename);
		$res = false;
		if (is_array($arr)) {
			switch ($arr[2]) {
				case 1:
					$this->gdNoSupport = 'GIF';
					if (function_exists('imagecreatefromgif') && function_exists('imagegif')) {
						$res = true;
					}
					break;
				case 2:
					$this->gdNoSupport = 'JPG';
					if (function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
						$res = true;
					}
					break;
				case 3:
					$this->gdNoSupport = 'PNG';
					if (function_exists('imagecreatefrompng') && function_exists('imagepng')) {
						$res = true;
					}
					break;
			}
		}
		return $res;
	}
	
	/**
	 *
	 */
	function __destruct(){
	}

}
?>