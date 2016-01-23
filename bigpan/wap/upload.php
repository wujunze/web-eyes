<?php
$title='本地文件上传';
$iswap=true;
include("../includes/common.php");

if(isset($_SESSION['verifycode']))$verify=$_SESSION['verifycode'];
$verifycode=rand(10001,99999);
$_SESSION['verifycode'] = $verifycode;
pageTop();
?>
<script>
function showdiv(targetid){
	var target=document.getElementById(targetid);
	if (target.style.display=="block"){
		target.style.display="none";
	} else {
		target.style.display="block";
	}
}
</script>
<div class="content">
<form action="upload.php?a=1" method="post" enctype="multipart/form-data">
选择文件：<br/>
<input type="file" name="file"/><br/>
<label><input type="checkbox" name="show" checked="checked" value="1">&nbsp;在首页文件列表显示</label><br/>
<label><input type="checkbox" name="ispwd" value="1" onclick="showdiv('pwd')">&nbsp;设定密码</label><br/>
<div id="pwd" style="display:none;">
<input name="pwd" size="50" placeholder="密码只能为小写字母和数字"/><br/>
</div>
<?php
echo'<input type="hidden" name="verify" value="'.$verifycode.'">';
?>
<input type="submit" value="上传"/>
</form><br/>
<?php

if($_GET['a']=='1')
{
$name=daddslashes($_FILES['file']['name']);
$verifycode=$_POST['verify'];
if(!isset($verifycode) || $verifycode!=$verify){
   	echo'<hr/><font color="red">文件上传失败！请不要重复提交！</font>';
	exit();
}
$name2=md5_file($_FILES['file']['tmp_name']);
$row =$DB->get_row("SELECT * FROM udisk WHERE fileurl='{$name2}'");
if($row) {
	$extension=explode('.',$row['filename']);
	if (($length = count($extension)) > 1) {
	$ext = strtolower($extension[$length - 1]);
	}
	$exti='.'.$ext;
	echo '<hr/><font color="green">本站已存在该文件！</font><br/>文件名称：'.$row['filename'].'<br/>文件类型：'.$_FILES['file']['type'].'<br/>文件大小：'.size($row['size']).'<br/>下载地址：<a href="../down.php/'.$name2.$exti.'">'.$u.'down.php/'.$name2.$exti.'</a><br/>在线预览：<a href="list.php?act=view&name='.$name2.'" target="_blank">点击进入</a>';
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

$hide=($_POST['show']==1)?0:1;
$pwd=($_POST['ispwd']==1)?daddslashes($_POST['pwd']):null;
$realurl=($_POST['ispwd']==1)?'下载地址(无需密码)：<a href="../down.php/'.$name2.$exti.'&'.$pwd.'">'.$u.'down.php/'.$name2.$exti.'&'.$pwd.'</a><br/>':null;

$DB->query("INSERT INTO `udisk` (`filename`,`size`,`datetime`,`type`,`fileurl`,`ip`,`hide`,`pwd`) values ('{$name}','{$size}','{$date}','{$ext}','{$name2}','{$ip}','{$hide}','{$pwd}')");

echo '<hr/><font color="green">文件已成功上传！</font><br/>文件名称：'.$name.'<br/>文件类型：'.$_FILES['file']['type'].'<br/>文件大小：'.size($size).'<br/>下载地址：<a href="../down.php/'.$name2.$exti.'">'.$u.'down.php/'.$name2.$exti.'</a><br/>'.$realurl.'在线预览：<a href="list.php?act=view&name='.$name2.'" target="_blank">点击进入</a>';
}
}

jiyu();
echo '</div>';
foot();
?>
</body></html>