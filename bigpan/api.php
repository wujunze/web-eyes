<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="viewport" content="width=device-width">
<title>文件上传页面</title>
</head>
<body>
<?php
include("./includes/common.php");
if($openapi==0)exit('本站未开启API上传功能！');

$backurl = isset($_GET["backurl"])?base64_decode($_GET["backurl"]):exit('backurl undefined');
$referer = parse_url($_SERVER['HTTP_REFERER']);
$backurl_host = parse_url($backurl);
if($referer['host']!=$backurl_host['host'])
exit('Access Denied');

$name=daddslashes($_FILES['file']['name']);

$name2=md5_file($_FILES['file']['tmp_name']);
$row =$DB->get_row("SELECT * FROM udisk WHERE fileurl='{$name2}'");
if($row) {
	$extension=explode('.',$row['filename']);
	if (($length = count($extension)) > 1) {
	$ext = strtolower($extension[$length - 1]);
	}
	$exti='.'.$ext;
	echo '<font color="green">本站已存在该文件！</font><hr/>文件名称：'.$row['filename'].'<br/>文件类型：'.$_FILES['file']['type'].'<br/>文件大小：'.size($row['size']).'<br/>下载地址：<a href="down.php/'.$name2.$exti.'">'.$u.'down.php/'.$name2.$exti.'</a><hr/>';
} else {
$result = $stor->upload($name2, $_FILES['file']['tmp_name']);
if(false==$result){
exit("文件上传失败");
}
$size=$_FILES['file']['size'];
$ip=real_ip();

$extension=explode('.',$name);
if (($length = count($extension)) > 1) {
$ext = strtolower($extension[$length - 1]);
}
$exti='.'.$ext;

$DB->query("INSERT INTO `udisk` (`filename`,`size`,`datetime`,`type`,`fileurl`,`ip`,`hide`) values ('{$name}','{$size}','{$date}','{$ext}','{$name2}','{$ip}','0')");

echo '<font color="green">文件已成功上传！</font><hr/>文件名称：'.$name.'<br/>文件类型：'.$_FILES['file']['type'].'<br/>文件大小：'.size($size).'<br/>下载地址：<a href="down.php/'.$name2.$exti.'">'.$u.'down.php/'.$name2.$exti.'</a><hr/>';
}

$fileurl=base64_encode($u.'down.php/'.$name2.$exti);
echo <<<HTML
<form action="{$backurl}" method="post">
<input name="file" type="hidden" value="{$fileurl}" />
<input name="type" type="hidden" value="{$ext}" />
<input name="name" type="hidden" value="{$name}" />
<input name="submit" type="submit" value="下一步" />
</form>
HTML;
?>
</body>
</html>