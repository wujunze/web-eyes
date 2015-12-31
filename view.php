<?php
include("./includes/common.php");
$url=$_SERVER['PATH_INFO'];
$name=preg_replace('![^a-zA-Z0-9( )._-]!s','',$url);
$type = strtolower(substr(strrchr($name,"."),1));
$file=substr($name,0,stripos($name,"."));
if(!$name)exit;

if($type=='png'||$type=='jpg'||$type=='gif'||$type=='jpeg'||$type=='bmp')
{
	header("Content-type: image/{$type}");
	$stor->downfile($file);
}
elseif($type=='mp3'||$type=='wav'||$type=='flac'||$type=='mid'||$type=='ape'||$type=='wma')
{
	header("Content-type: audio/{$type}");
	$stor->downfile($file);
}
elseif($type=='mp4'||$type=='flv'||$type=='mov'||$type=='f4v'||$type=='rmvb'||$type=='rm'||$type=='3gp'||$type=='avi'||$type=='mpg')
{
	header("Content-type: video/{$type}");
	$stor->downfile($file);
}
?>