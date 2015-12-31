<?php
/**
 * 普通空间、ACE、SAE 三合一文件操作类
 * @author 消失的彩虹海
 * @QQ 1277180438
 * All Rights Reserved.
 */
if(ini_get('acl.app_id'))
{
class stor { //AceStorage
	var $Storage = null;
	function __construct($Storage) {
		$this->Storage = Alibaba::Storage($Storage);
		return true;
	}
	function exists($name) {
		return $this->Storage->fileExists($name);
	}
	function get($name) {
		return $this->Storage->get($name);
	}
	function downfile($name) {
		$res = $this->Storage->get($name);
		echo $res;
		return true;
	}
	function upload($name,$tmpfile) {
		return $this->Storage->saveFile($name, $tmpfile);
	}
	function savefile($name,$tmpfile) {
		return $this->upload($name,$tmpfile);
	}
	function getsize($name) {
		$res = $this->Storage->getMeta($name);
		return $res['content-length'];
	}
	function gettype($name) {
		$res = $this->Storage->getMeta($name);
		return $res['content-type'];
	}
	function delete($name) {
		return $this->Storage->delete($name);
	}
}
} elseif (defined('SAE_ACCESSKEY')) {
class stor { //SaeStorage
	var $Storage = null;
	function __construct($Storage) {
		$this->Storage = new SaeStorage();
		$this->domain = $Storage;
		$this->path = 'file/';
		return true;
	}
	function exists($name) {
		return $this->Storage->fileExists($this->domain, $this->path.$name);
	}
	function get($name) {
		return $this->Storage->read($this->domain, $this->path.$name);
	}
	function downfile($name) {
		$res = $this->Storage->read($this->domain, $this->path.$name);
		echo $res;
		return true;
	}
	function upload($name,$tmpfile) {
		return $this->Storage->upload($this->domain,$this->path.$name, $tmpfile);
	}
	function savefile($name,$tmpfile) {
		return $this->upload($name,$tmpfile);
	}
	function getsize($name) {
		$res = $this->Storage->getAttr($this->domain, $this->path.$name);
		return $res['length'];
	}
	function gettype($name) {
		$res = $this->Storage->getAttr($this->domain, $this->path.$name);
		return $res['content_type'];
	}
	function delete($name) {
		return $this->Storage->delete($this->domain, $this->path.$name);
	}
}
} else {
class stor {
	var $path = null;
	function __construct() {
		$this->path = ROOT.'file/';
		if(!is_dir($this->path))
			mkdir("file");
		if(!file_exists($this->path.".htaccess"))
			file_put_contents("file/.htaccess",'Error:Keep Out');
		return true;
	}
	function exists($name) {
		return file_exists($this->path.$name);
	}
	function get($name) {
		return file_get_contents($this->path.$name);
	}
	function downfile($name) {
		readfile($this->path.$name);
		return true;
	}
	function upload($name,$tmpfile) {
		return move_uploaded_file($tmpfile,$this->path.$name);
	}
	function savefile($name,$tmpfile) {
		return rename($tmpfile,$this->path.$name);
	}
	function getsize($name) {
		return filesize($this->path.$name);
	}
	function gettype($name) {
		if(function_exists("finfo_open")){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$type = finfo_file($finfo, $this->path.$name);
			finfo_close($finfo);
			return $type;
		} else {return null;}
	}
	function delete($name) {
		return unlink($this->path.$name);
	}
}
}