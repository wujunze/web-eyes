<?php
function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function curl_download($remote, $local) {
     $cp = curl_init($remote);
     $fp = fopen($local, "w");
     
    curl_setopt($cp, CURLOPT_FILE, $fp);
    curl_setopt($cp, CURLOPT_HEADER, 0);
     
     $res=curl_exec($cp);
     curl_close($cp);
     fclose($fp);
	 return $res;
}

function size($size)
{
if($size<1024) $size.='B';
else {
$size/=1024;
if($size<1024) $size=round($size,2).'KB';
else {
$size/=1024;
if($size<1024) $size=round($size,2).'MB';
else {
$size/=1024;
if($size<1024) $size=round($size,2).'GB';
}
}
}
return $size;
}

function real_ip(){
static $realip = NULL; 
if ($realip !== NULL){
return $realip;
}
if (isset($_SERVER)){
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
foreach ($arr AS $ip){
$ip = trim($ip);
if ($ip != 'unknown'){
$realip = $ip;
break;
}
}
}
elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
$realip = $_SERVER['HTTP_CLIENT_IP'];
}
else{
if (isset($_SERVER['REMOTE_ADDR'])){
$realip = $_SERVER['REMOTE_ADDR'];
}
else{
$realip = '0.0.0.0';
}
}
}
else{
if (getenv('HTTP_X_FORWARDED_FOR')){
$realip = getenv('HTTP_X_FORWARDED_FOR');
}
elseif (getenv('HTTP_CLIENT_IP')){
$realip = getenv('HTTP_CLIENT_IP');
}
else{
$realip = getenv('REMOTE_ADDR');
}
} 
preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0'; 
return $realip;
}
?>