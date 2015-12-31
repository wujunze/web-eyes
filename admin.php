<?php
$title='文件管理页面';
include("./includes/common.php");
navbar();
?>
<div class="container"><div class="hero-unit">
<?php
if($_GET['a']=='')
{main0();}
elseif($_GET['a']=='1')
{main1();}
elseif($_GET['a']=='api')
{api_about();}
function fileList()
{
global $DB;
$key=$_REQUEST['key'];
$ba=urlencode('查看列表');
$n=$DB->count("SELECT count(*) from udisk WHERE 1");
echo "<p>以下是本站全部已上传文件列表 共有{$n}个文件！(<a href=\"admin.php?a=1&act={$ba}&key={$key}\">刷新列表</a>)</p>";
echo '<table class="table">';
echo '<tr><td>序号</td><td>操作</td><td>文件名</td><td>文件大小</td><td>上传日期时间</td><td>文件格式</td><td>上传者IP</td></tr>';

Global $pagesize;

$numrows=$n;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);
$rs=$DB->query("select * from udisk where 1 order by datetime desc limit $offset,$pagesize");
$i=0;
while ($myrow = $DB->fetch($rs))
{
$i++;
$pagesl=$i+($page-1)*$pagesize;
$size=size($myrow['size']);

if($myrow['pwd']!=null){
	$pwd_ext1='&'.$myrow['pwd'];
	$pwd_ext2='&pwd='.$myrow['pwd'];
}

$type = $myrow['type'];
if ($type!=NULL){$type='.'.$type;}else{$type='未知';}
$ext='.'.$myrow['type'];
echo '<tr><td>'.$i.'</td><td><a href="down.php/'.$myrow['fileurl'].$ext.$pwd_ext1.'">下载</a> | <a href="admin.php?a=1&key='.$key.'&act=read&name='.$myrow['fileurl'].$pwd_ext2.'">查看</a> | <a href="admin.php?a=1&key='.$key.'&act=del1&name='.$myrow['fileurl'].'">删除</a></td><td>'.$myrow['filename'].'</td><td>'.$size.'</td><td>'.$myrow['datetime'].'</td><td>'.$type.'</td><td><a href="http://www.ip138.com/ips138.asp?ip='.$myrow['ip'].'" target="_blank">'.$myrow['ip'].'</a></td></tr>';
}
echo '</table>';
echo "共有".$pages."页(".$page."/".$pages.")<br>";
for ($i=1;$i<$page;$i++)
echo "<a href='admin.php?a=1&act=查看列表&key=".$key."&page=".$i."'>[".$i ."]</a> ";
echo "[".$page."]";
for ($i=$page+1;$i<=$pages;$i++)
echo "<a href='admin.php?a=1&act=查看列表&key=".$key."&page=".$i."'>[".$i ."]</a> ";
echo '<br>';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo "<a href='admin.php?a=1&act=查看列表&key=".$key."&page=".$first."'>首页</a>.";
echo "<a href='admin.php?a=1&act=查看列表&key=".$key."&page=".$prev."'>上一页</a>";
}
if ($page<$pages)
{
echo "<a href='admin.php?a=1&act=查看列表&key=".$key."&page=".$next."'>下一页</a>.";
echo "<a href='admin.php?a=1&act=查看列表&key=".$key."&page=".$last."'>尾页</a>";
}
}


function read()
{
$ba=urlencode('查看列表');
$key=$_REQUEST['key'];
echo "<a href=\"admin.php?a=1&act={$ba}&key={$key}\">返回文件管理列表</a><br/>----------<br/>";
$name=$_REQUEST['name'];
viewfiles($name);
}
function main0()
{
echo <<<INPUT
<form action="admin.php" method="GET">
输入管理密码：<br/>
<input name="key" size="15" type="password"/><br/><input name="a" type="hidden" value="1"/>
<input type="submit" name="act" value="查看列表"/></form>
<br/><br/>©Powered by <a href="http://blog.cccyun.cn/" target="_blank">彩虹</a>!
INPUT;
}
function main1()
{
Global $key0;
$act=$_REQUEST['act'];
$key=$_REQUEST['key'];
if($key==$key0)
{
if($act=='查看列表')
{
fileList();
}
elseif($act=='read')
{read();}
elseif($act=='del1')
{delete1();}
elseif($act=='del2')
{delete2();}
}
else{
echo '管理密码错误！';
}
}

function delete1()
{
global $DB;
$key=$_REQUEST['key'];
$name=$_REQUEST['name'];
$row=$DB->get_row("SELECT * FROM udisk WHERE fileurl='{$name}'");
$name2=$row['filename'];

$ba=urlencode('查看列表');
echo "确认删除“{$name2}”吗？<br/><a href=\"admin.php?a=1&key={$key}&act=del2&name={$name}\">确认删除</a>.<a href=\"admin.php?a=1&act={$ba}&key={$key}\">返回列表</a>";

}
function delete2()
{
global $DB;
$ba=urlencode('查看列表');
$name=$_REQUEST['name'];
$key=$_REQUEST['key'];
Global $stor;
$result = $stor->delete($name);
$sql = $DB->query("DELETE FROM udisk WHERE fileurl='{$name}' LIMIT 1");
if($result==true && $sql==true)
{echo '删除成功！<br/>';}
else{
echo '删除失败！<br/>';
}

echo "<a href=\"admin.php?a=1&act={$ba}&key={$key}\">返回列表</a>";
}

?>
</div></div></div></body></html>