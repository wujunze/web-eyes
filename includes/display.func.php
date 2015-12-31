<?php
function viewfiles($name)
{
Global $u,$DB;
$row =$DB->get_row("SELECT * FROM udisk WHERE fileurl='{$name}' limit 1");
if($row['pwd']!=null && $row['pwd']!=$_GET['pwd']){
echo <<<HTML
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<script type="text/javascript">
var pwd=prompt("请输入密码","")
if (pwd!=null && pwd!="")
{
	window.location.href='list.php?act=view&name={$name}&pwd='+pwd
}
</script>
请输入密码以查看内容。<br/>
[ <a href="javascript:history.back();">返回上一页</a> ]
HTML;
exit;
}
$type = strtolower(substr(strrchr($row['filename'],"."),1));
$name2 = $row['filename'];
if($type=='png'||$type=='jpg'||$type=='gif'||$type=='jpeg'||$type=='bmp')
{
	echo '<a href="view.php/'.$name.'.'.$type.'" title="点击查看原图"><img alt="loading" src="view.php/'.$name.'.'.$type.'" style="max-width:100%;"/></a><br/><br/>';
	echo'图片外链：<input type="text" size="50" id="input" value="'.$u.'view.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="50" id="input" value="[img]'.$u.'view.php/'.$name.'.'.$type.'[/img]"/><br/>Html代码：<input type="text" size="50" id="input" value="&lt;img src=&quot;'.$u.'view.php/'.$name.'.'.$type.'&quot;/&gt;"/>';
}
elseif($type=='mp3'||$type=='wav'||$type=='flac'||$type=='mid'||$type=='ape'||$type=='wma')
{
	echo '<b>音乐播放器——'.$name2.'</b><br/><audio src="'.$u.'view.php/'.$name.'.'.$type.'" controls="controls" autoplay=true>{抱歉,不支持在线播放，换个HTML5浏览器吧。}</audio><br/><br/>';
	echo'音乐外链：<input type="text" size="50" id="input" value="'.$u.'view.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="50" id="input" value="[audio=X]'.$u.'view.php/'.$name.'.'.$type.'[/audio]"/><br/>flash地址：<input type="text" size="50" id="input" value="'.$u.'dewplayer.swf?mp3='.$u.'view.php/'.$name.'.'.$type.'&autostart=1&autoreplay=1&volume=100"/>';
}
elseif($type=='mp4'||$type=='flv'||$type=='mov'||$type=='f4v'||$type=='rmvb'||$type=='rm'||$type=='3gp'||$type=='avi'||$type=='mpg')
{
	echo '<b>视频播放器——'.$name2.'</b><br/><video id="movies" onclick="if(this.paused) { this.play();}else{ this.pause();}" src="view.php/'.$name.'.'.$type.'" autobuffer="true" width="640px" controls="">{抱歉,不支持在线播放，换个HTML5浏览器吧。}</video><br/><br/>';
	echo'视频外链：<input type="text" size="50" id="input" value="'.$u.'view.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="50" id="input" value="[movie=320*180]'.$u.'view.php/'.$name.'.'.$type.'|图片地址[/movie]"/>';
}
else
{
	Global $stor;
	$con = $stor->get($name);
	$con=htmlentities($con,ENT_QUOTES);
	$con=nl2br($con);
	echo $con;
	if(!$con)echo '该格式不支持在线查看';
	echo'<br/><br/>文件外链：<input type="text" size="50" id="input" value="'.$u.'down.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="50" id="input" value="[url='.$u.'down.php/'.$name.'.'.$type.']'.$name2.'[/url]"/><br/>Html代码：<input type="text" size="50" id="input" value="&lt;a href=&quot;'.$u.'down.php/'.$name.'.'.$type.'&quot;/&gt;'.$name2.'&lt;a/&gt;"/>';
}
}

function viewfiles_wap($name)
{
Global $u,$DB;
$row =$DB->get_row("SELECT * FROM udisk WHERE fileurl='{$name}' limit 1");
if($row['pwd']!=null && $row['pwd']!=$_GET['pwd']){
echo <<<HTML
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<script type="text/javascript">
var pwd=prompt("请输入密码","")
if (pwd!=null && pwd!="")
{
	window.location.href='list.php?act=view&name={$name}&pwd='+pwd
}
</script>
请输入密码以查看内容。<br/>
[ <a href="javascript:history.back();">返回上一页</a> ]
HTML;
exit;
}
$type = strtolower(substr(strrchr($row['filename'],"."),1));
$name2 = $row['filename'];
if($type=='png'||$type=='jpg'||$type=='gif'||$type=='jpeg'||$type=='bmp')
{
	echo '<a href="../view.php/'.$name.'.'.$type.'" title="点击查看原图"><img alt="loading" src="../view.php/'.$name.'.'.$type.'" style="max-width:100%;"/></a><br/><br/>';
	echo'图片外链：<input type="text" size="30" id="input" value="'.$u.'view.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="30" id="input" value="[img]'.$u.'view.php/'.$name.'.'.$type.'[/img]"/><br/>Html代码：<input type="text" size="30" id="input" value="&lt;img src=&quot;'.$u.'view.php/'.$name.'.'.$type.'&quot;/&gt;"/>';
}
elseif($type=='mp3'||$type=='wav'||$type=='flac'||$type=='mid'||$type=='ape'||$type=='wma')
{
	echo '<b>音乐播放器——'.$name2.'</b><br/><audio src="'.$u.'view.php/'.$name.'.'.$type.'" controls="controls" autoplay=true>{抱歉,不支持在线播放，换个HTML5浏览器吧。}</audio><br/><br/>';
	echo'音乐外链：<input type="text" size="30" id="input" value="'.$u.'view.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="30" id="input" value="[audio=X]'.$u.'view.php/'.$name.'.'.$type.'[/audio]"/><br/>flash地址：<input type="text" size="30" id="input" value="'.$u.'dewplayer.swf?mp3='.$u.'view.php/'.$name.'.'.$type.'&autostart=1&autoreplay=1&volume=100"/>';
}
elseif($type=='mp4'||$type=='flv'||$type=='mov'||$type=='f4v'||$type=='rmvb'||$type=='rm'||$type=='3gp'||$type=='avi'||$type=='mpg')
{
	echo '<b>视频播放器——'.$name2.'</b><br/><video id="movies" onclick="if(this.paused) { this.play();}else{ this.pause();}" src="../view.php/'.$name.'.'.$type.'" autobuffer="true" width="320px" controls="">{抱歉,不支持在线播放，换个HTML5浏览器吧。}</video><br/><br/>';
	echo'视频外链：<input type="text" size="30" id="input" value="'.$u.'view.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="30" id="input" value="[movie=320*180]'.$u.'view.php/'.$name.'.'.$type.'|图片地址[/movie]"/>';
}
else
{
	Global $stor;
	$con = $stor->get($name);
	$con=htmlentities($con,ENT_QUOTES,'UTF-8');
	$con=nl2br($con);
	echo $con;
	if(!$con)echo '该格式不支持在线查看';
	echo'<br/><br/>文件外链：<input type="text" size="30" id="input" value="'.$u.'down.php/'.$name.'.'.$type.'"/><br/>UBB代码：<input type="text" size="30" id="input" value="[url='.$u.'down.php/'.$name.'.'.$type.']'.$name2.'[/url]"/><br/>Html代码：<input type="text" size="30" id="input" value="&lt;a href=&quot;'.$u.'down.php/'.$name.'.'.$type.'&quot;/&gt;'.$name2.'&lt;a/&gt;"/>';

}
}

function navbar()
{
	$file=basename($_SERVER['PHP_SELF']);
echo '
<div class="navbar"><div class="navbar-inner"><div class="container"><ul class="nav">
<li><a href="/">首页</a></li>
<li class="'.($file=='list.php'||$file=='index.php'?'active':null).'"><a href="list.php">文件列表</a></li>
<li class="'.($file=='upload.php'?'active':null).'"><a href="upload.php">本地上传</a></li>
<li class="'.($file=='urlupload.php'?'active':null).'"><a href="urlupload.php">远程上传</a></li>
<li class="'.($file=='admin.php'&&$_GET['a']!='api'?'active':null).'"><a href="admin.php">后台管理</a></li>
<li class="'.($_GET['a']=='api'?'active':null).'"><a href="admin.php?a=api">ＡＰＩ</a></li>
<!--li><a href="/mp3dish/">音乐外链</a></li>
<li><a href="http://kuai.sinaapp.com/">图床应用</a></li-->
<li><a href="wap">手机版</a></li>
</ul></div></div></div>
';
}

function pageTop()
{
echo <<<TOP
<a id="top"></a>
<div class="title2">
<a href="list.php">首页</a>.<a href="upload.php">本地上传</a>.<a href="urlupload.php">远程上传</a></div>
TOP;
}

function foot()
{
echo <<<HTML
<div class="footer">
<a id="bottom" href="#top">顶部</a>|<a href="admin.php">管理</a>|<a href="admin.php?a=api">API</a>|<a href="../list.php">电脑版>></a></div>
HTML;
}

function jiyu()
{
$maxfilesize=ini_get('upload_max_filesize');
$ip=real_ip();
echo '<hr/>';
echo '提示:<br/>**您的IP是'.$ip.'，请不要上传违规文件！<br/>**上传无格式限制，当前服务器单个文件上传最大支持'.$maxfilesize.'！<br/>';
}

function api_about()
{
	Global $u,$openapi;
	if($openapi==0)exit('本站未开启API上传功能！');
echo <<<HTML
<pre>﻿
API地址：
{$u}api.php
--------
API输入：
1.GET输入backurl，回调地址，用于用户上传文件后返回原网站，需进行base64加密
**上传时会对backurl和来源页面的域名进行校验，若不相同则无法上传。
2.POST输入file，上传的文件
--------
API输出格式：
以表单方式让用户POST相应数据到回调地址
1.POST输出submit，可用于验证用户是否传来数据
2.POST输出file，文件对应地址，需要先base64解密
3.POST输出name，文件名
4.POST输出type，文件后缀名
</pre>﻿
HTML;
}
?>