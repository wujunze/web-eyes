<?php
$title='彩虹共享资源列表';
include("./includes/common.php");
navbar();
?>

<div class="container"><div class="hero-unit">
<?php
$act=$_GET['act'];
if(!$act)
{fileList();}
elseif($act=='view')
{view();}

function fileList()
{
global $DB;
$n=$DB->count("SELECT count(*) from udisk WHERE 1");

echo "<p>以下是本站全部已上传文件列表 共有{$n}个文件！<br/>";
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
$rs=$DB->query("select * from udisk where hide=0 order by datetime desc limit $offset,$pagesize");
$i=0;
while ($myrow = $DB->fetch($rs))
{
$i++;
$pagesl=$i+($page-1)*$pagesize;
$size=size($myrow['size']);

$type = $myrow['type'];
if ($type!=NULL){$type='.'.$type;}else{$type='未知';}
$ext='.'.$myrow['type'];
$ip=preg_replace('/\d+$/','*',$myrow['ip']);
echo '<tr><td>'.$i.'</td><td><a href="down.php/'.$myrow['fileurl'].$ext.'">下载</a> | <a href="list.php?act=view&name='.$myrow['fileurl'].'">查看</a></td><td>'.$myrow['filename'].'</td><td>'.$size.'</td><td>'.$myrow['datetime'].'</td><td>'.$type.'</td><td>'.$ip.'</td></tr>';
}
echo '</table>';
echo "共有".$pages."页(".$page."/".$pages.")<br>";
for ($i=1;$i<$page;$i++)
echo "<a href='list.php?page=".$i."'>[".$i ."]</a> ";
echo "[".$page."]";
for ($i=$page+1;$i<=$pages;$i++)
echo "<a href='list.php?page=".$i."'>[".$i ."]</a> ";
echo '<br>';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo "<a href='list.php?page=".$first."'>首页</a>.";
echo "<a href='list.php?page=".$prev."'>上一页</a>";
}
if ($page<$pages)
{
echo "<a href='list.php?page=".$next."'>下一页</a>.";
echo "<a href='list.php?page=".$last."'>尾页</a>";
}

echo '<br/>';
if(!defined("SAE_ACCESSKEY"))include(ROOT."includes/rs.php");
include(ROOT."includes/runtime.php");
}

function view()
{
echo '<a href="list.php">返回文件列表</a><br/>----------<br/>';
$name=$_GET['name'];
viewfiles($name);
}
?>
</div></div></div></body></html>