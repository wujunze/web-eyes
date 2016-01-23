<?php
$title='彩虹共享资源列表';
$iswap=true;
include("../includes/common.php");

pageTop();

$act=$_GET['act'];
if(!$act)
{fileList();}
elseif($act=='view')
{view();}

function fileList()
{
global $DB;
$n=$DB->count("SELECT count(*) from udisk WHERE 1");

echo "<div class='title'>文件列表（共有{$n}个文件）</div>";

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
$ext='.'.$myrow['type'];

echo '<div class="content">'.$i.'.<a href="../down.php/'.$myrow['fileurl'].$ext.'">'.$myrow['filename'].'</a>('.$size.')-<a href="list.php?act=view&name='.$myrow['fileurl'].'">查看</a></div>';
}
echo '<div class="pages">共有'.$pages.'页('.$page.'/'.$pages.')';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo ' <a href="list.php?page='.$first.'">首页</a>.';
echo '<a href="list.php?page='.$prev.'">上一页</a>';
}
if ($page<$pages)
{
echo ' <a href="list.php?page='.$next.'">下一页</a>.';
echo '<a href="list.php?page='.$last.'">尾页</a>';
}
echo '</div>';
foot();
}

function view()
{
echo '<a href="list.php">返回文件列表</a><br/>----------<br/>';
$name=$_GET['name'];
viewfiles_wap($name);
foot();
}
?>
</body>
</html>