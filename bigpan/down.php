<?php
include("./includes/common.php");
$urlarr=explode('/',$_SERVER['PATH_INFO']);
if (($length = count($urlarr)) > 1) {
$url = $urlarr[$length-1];
}
$extension=explode('&',$url);
if (($length = count($extension)) > 1) {
$pwd = $extension[$length-1];
$url = $extension[0];
}

$file=substr($url,0,stripos($url,"."));
$row = $DB->get_row("SELECT * FROM udisk WHERE fileurl='{$file}' limit 1");
$name=$row['filename'];

if($row['pwd']!=null && $row['pwd']!=$pwd){
echo <<<HTML
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<script type="text/javascript">
var pwd=prompt("请输入密码","")
if (pwd!=null && pwd!="")
{
	window.location.href='{$url}&'+pwd
}
</script>
[ <a href="javascript:history.back();">返回上一页</a> ]
HTML;
exit;
}

if($stor->exists($file))
{
$file_size = $stor->getsize($file);

header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$name}");

$stor->downfile($file);
}
else{
echo 'Can\'t find this file';
}

?>