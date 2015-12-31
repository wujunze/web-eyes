<?php
$title='远程文件上传';
$iswap=true;
include("../includes/common.php");

if(isset($_SESSION['verifycode']))$verify=$_SESSION['verifycode'];
$verifycode=rand(10001,99999);
$_SESSION['verifycode'] = $verifycode;
pageTop();

if(!$_GET['a']) {
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
<div class="content"><form action="urlupload.php?a=1" method="post">
输入文件URL地址：<br/>
<input name="url" size="15" value="http://"><br/>
输入保存文件名称：<br/>
<input name="name" size="15"/><br/>
<label><input type="checkbox" name="show" checked="checked" value="1">&nbsp;在首页文件列表显示</label><br/>
<label><input type="checkbox" name="ispwd" value="1" onclick="showdiv('pwd')">&nbsp;设定密码</label><br/>
<div id="pwd" style="display:none;">
<input name="pwd" size="50" placeholder="密码只能为小写字母和数字"/><br/>
</div>
<input type="hidden" name="verify" value="<?php echo $verifycode;?>">
<input type="submit" value="提交"/>
</form>
<?php
}
elseif($_GET['a']=='1') {

$key=$_REQUEST['key'];
$url=$_REQUEST['url'];
$name=daddslashes($_REQUEST['name']);
$verifycode=$_POST['verify'];
if(!isset($verifycode) || $verifycode!=$verify){
   	echo'<hr/><font color="red">文件上传失败！请不要重复提交！</font>';
	exit();
}

$name2=md5(time().rand());

$cache_file=$cachedir.$name2;
$con=curl_download($url,$cache_file);
if(!$con)
{echo '远程获取文件失败，请检查URL地址是否正确！';}
else{
$name2=md5_file($cache_file);
$row =$DB->get_row("SELECT * FROM udisk WHERE fileurl='{$name2}'");
if($row) {
	$extension=explode('.',$row['filename']);
	if (($length = count($extension)) > 1) {
	$ext = strtolower($extension[$length - 1]);
	}
	$exti='.'.$ext;
	echo '<font color="green">本站已存在该文件！</font><br/>文件名称：'.$row['filename'].'<br/>文件类型：'.$row['type'].'<br/>文件大小：'.size($row['size']).'<br/>下载地址：<a href="../down.php/'.$name2.$exti.'">'.$u.'down.php/'.$name2.$exti.'</a><br/>在线预览：<a href="list.php?act=view&name='.$name2.'" target="_blank">点击进入</a>';
} else {
$result = $stor->savefile($name2, $cache_file);
if(false==$result){
exit("文件上传失败");
}

$ip=real_ip();
$extension=explode('.',$name);
if (($length = count($extension)) > 1) {
$ext = strtolower($extension[$length - 1]);
}
$exti='.'.$ext;

$size=$stor->getsize($name2);
$type=$stor->gettype($name2);
if($type==null)$type=$ext;

$hide=($_POST['show']==1)?0:1;
$pwd=($_POST['ispwd']==1)?daddslashes($_POST['pwd']):null;
$realurl=($_POST['ispwd']==1)?'下载地址(无需密码)：<a href="../down.php/'.$name2.$exti.'&'.$pwd.'">'.$u.'down.php/'.$name2.$exti.'&'.$pwd.'</a><br/>':null;

$DB->query("INSERT INTO `udisk` (`filename`,`size`,`datetime`,`type`,`fileurl`,`ip`,`hide`,`pwd`) values ('{$name}','{$size}','{$date}','{$ext}','{$name2}','{$ip}','{$hide}','{$pwd}')");

echo '<font color="green">文件远程上传成功！</font><br/>文件名称：'.$name.'<br/>文件类型：'.$type.'<br/>文件大小：'.size($size).'<br/>下载地址：<a href="../down.php/'.$name2.$exti.'">'.$u.'down.php/'.$name2.$exti.'</a><br/>'.$realurl.'在线预览：<a href="list.php?act=view&name='.$name2.'" target="_blank">点击进入</a>';
}
}
}

jiyu();
echo '</div>';
foot();
?>
</body></html>