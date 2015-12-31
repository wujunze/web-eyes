<?php
$title='文件管理页面';
$iswap=true;
include("../includes/common.php");

pageTop();

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
echo "<div class='title'>文件列表（共有{$n}个文件）</div>";
echo "<a href=\"admin.php?a=1&act={$ba}&key={$key}\">刷新列表</a><br/>";
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
$ext='.'.$myrow['type'];

if($myrow['pwd']!=null){
	$pwd_ext1='&'.$myrow['pwd'];
	$pwd_ext2='&pwd='.$myrow['pwd'];
}

echo '<div class="content">'.$i.'.<a href="../down.php/'.$myrow['fileurl'].$ext.$pwd_ext1.'">'.$myrow['filename'].'</a>('.$size.')-';
echo '<a href="admin.php?a=1&key='.$key.'&act=read&name='.$myrow['fileurl'].$pwd_ext2.'">查看</a>.<a href="admin.php?a=1&key='.$key.'&act=del1&name='.$myrow['fileurl'].'">删除</a></div>';
}
echo '<div class="pages">共有'.$pages.'页('.$page.'/'.$pages.')';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo ' <a href="admin.php?a=1&act=查看列表&key='.$key.'&page='.$first.'">首页</a>.';
echo '<a href="admin.php?a=1&act=查看列表&key='.$key.'&page='.$prev.'">上一页</a>';
}
if ($page<$pages)
{
echo ' <a href="admin.php?a=1&act=查看列表&key='.$key.'&page='.$next.'">下一页</a>.';
echo '<a href="admin.php?a=1&act=查看列表&key='.$key.'&page='.$last.'">尾页</a>';
}
echo '</div>';
foot();
}

function read()
{
$ba=urlencode('查看列表');
$key=$_REQUEST['key'];
echo "<a href=\"admin.php?a=1&act={$ba}&key={$key}\">返回文件管理列表</a><br/>----------<br/>";
$name=$_REQUEST['name'];
viewfiles_wap($name);
foot();
}
function main0()
{
echo <<<INPUT
<div class="content"><form action="admin.php" method="GET">
输入管理密码：<br/>
<input name="key" size="15" type="password"/><br/><input name="a" type="hidden" value="1"/>
<input type="submit" name="act" value="查看列表"/></form>
<br/>©Powered by <a href="http://blog.cccyun.cn/" target="_blank">彩虹</a>!</div>
INPUT;
foot();
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
echo "<div class=\"content\">确认删除“{$name2}”吗？<br/><a href=\"admin.php?a=1&key={$key}&act=del2&name={$name}\">确认删除</a>.<a href=\"admin.php?a=1&act={$ba}&key={$key}\">返回列表</a></div>";

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
</html>