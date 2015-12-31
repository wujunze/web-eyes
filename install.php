<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="viewport" content="width=device-width; initial-scale=1.0;  minimum-scale=1.0; maximum-scale=2.0"/>
<link rel="stylesheet" type="text/css" href="./wap/style.css">
<link rel="shortcut icon" href="favicon.ico">
<title>安装彩虹外链网盘</title>
</head>
<body>
<?php
error_reporting(0);
$do=isset($_GET['do'])?$_GET['do']:'0';


echo'<div class="title2">安装彩虹外链网盘</div><div class="content">';

if(file_exists("install.lock")) {
 	echo"<pre>";
	include("readme.txt");
	echo"</pre>";
	echo'<hr> ';
	echo'您已经安装过，如需重新安装请删除<font color=red> install.lock </font>文件后再安装!如果你不是管理员请自觉离开!';
} else {

if($do=='0') {
echo'<pre>';
include("readme.txt");
echo'</pre>';
if(extension_loaded("sqlite3"))
echo "<a href='{$_SERVER['PHP_SELF']}?do=1'>>>下一步</a>";
else
echo "<a href='{$_SERVER['PHP_SELF']}?do=2'>>>下一步</a>";
}

if($do=='1') {
echo <<<HTML
请选择要使用的数据库类型：<br><br>
【<a href="{$_SERVER['PHP_SELF']}?do=2">MySQL</a>】<br>
<font color="blue">功能全面，综合化，追求最大并发效率。</font><br><br>
【<a href="{$_SERVER['PHP_SELF']}?do=3&sqlite=1">SQLite</a>】<br>
<font color="blue">安装方便，小型化，追求最大磁盘效率。</font><br><br>
HTML;
}

if($do=='2') {
if(ini_get('acl.app_id'))
echo <<<HTML
检测到您使用的是ACE空间，请按照以下步骤安装。<br><br>
<font color="blue">ACE安装说明：<br>
1.依次进入ACE控制面板—扩展服务—存储（Storage），点击“创建存储空间”，存储空间名称任意。<br>
2.打开config.php修改网站配置、数据库参数、Storage名称（Storage名称就填写上一步创建的存储空间的名称）。<br>
3.使用SVN上传代码后访问install.php完成安装。<hr>
ACE数据库信息填写提示：<br>
进入ACE管理控制台－扩展服务－数据库(MySQL)，成功开通后就可以显示数据库所需配置信息。“外网地址”即为MYSQL主机，“账户名”即为MYSQL用户名，“数据库”即为数据库名，数据库密码填写开通MySQL服务时填写的密码（并非阿里云登录密码）。</font>
<br><br>
如果已填写好config.php相关配置，请点击 <a href="{$_SERVER['PHP_SELF']}?do=4">下一步</a>
HTML;
elseif(defined("SAE_ACCESSKEY"))
echo <<<HTML
检测到您使用的是SAE空间，请按照以下步骤安装。<br><br>
<font color="blue">SAE安装说明：<br>
1.进入应用管理->服务管理->mysql 初始化数据库。<br>
2.进入应用管理->服务管理->Storage 创建一个domain。<br>
3.打开config.php修改网站配置、Storage名称（Storage名称就填写上一步创建的domain）。数据库信息不用填写！<br>
4.进入应用管理->服务管理->代码管理。创建一个版本。<br>
5.上传压缩包，完毕后访问 install.php 就可以开始安装了。</font>
<br><br>
如果已填写好config.php相关配置，请点击 <a href="{$_SERVER['PHP_SELF']}?do=4">下一步</a>
HTML;
else
echo <<<HTML
<form action="{$_SERVER['PHP_SELF']}?do=3" method='post'>
<br>数据库地址:<br>
<input type='text' name='host' value='localhost'/>
<br>数据库端口:<br>
<input type='text' name='port' value='3306'/>
<br>数据库用户名:<br>
<input type='text' name='user' value=''/>
<br>数据库密码:<br>
<input type='text' name='pwd' value=''/>
<br>数据库名:<br>
<input type='text' name='db' value=''/>
<br>管理员密码:<br>
<input type='text' name='adminpass' value=''/><br/>
<input type='submit' value='保存'/>
</form><br/>
（如果已事先填写好config.php相关数据库配置，请 <a href="{$_SERVER['PHP_SELF']}?do=4">点击此处</a> 跳过这一步！）
HTML;
}

if($do=='3') {
if(isset($_GET['sqlite']))
{
	$db_file = md5(time().rand());
	$config = "<?php
\$key0='123456';//管理员密码

\$pagesize='15';//文件列表每页显示多少个文件，必须为整数

\$Storage = 'udisk';//Storage名称

\$openapi = 1;//是否开启API上传

/*数据库信息*/
define('SQLITE',true);
\$db_file='{$db_file}';
?>";
	$result1 = file_put_contents('config.php',$config);
	$result2 = rename('./includes/sqlite/default.db', './includes/sqlite/'.$db_file.'.db');
	if($result1 && $result2){
		@file_put_contents("install.lock",'install');
		echo '<font color="green">安装成功！</font><br/>默认管理密码是123456，请打开config.php进行修改。<br/><a href="./">>>网站首页</a>';
	} else
		echo '保存失败!';
}
else
{
	$hosti=isset($_POST['host'])?$_POST['host']:NULL;
	$porti=isset($_POST['port'])?$_POST['port']:NULL;
	$useri=isset($_POST['user'])?$_POST['user']:NULL;
	$pwdi=isset($_POST['pwd'])?$_POST['pwd']:NULL;
	$dbi=isset($_POST['db'])?$_POST['db']:NULL;
	$adminpass=isset($_POST['adminpass'])?$_POST['adminpass']:NULL;

	if($hosti==NULL or $useri==NULL or $pwdi==NULL or $dbi==NULL){
		echo '保存错误,请确保每项都不为空';
	} else {
		$config="<?php
\$key0='{$adminpass}';//管理员密码

\$pagesize='15';//文件列表每页显示多少个文件，必须为整数

\$Storage = 'udisk';//Storage名称

\$openapi = 1;//是否开启API上传

/*数据库信息*/
\$host = '{$hosti}'; //数据库服务器
\$port = {$porti}; //数据库端口
\$user = '{$useri}'; //数据库用户名
\$pwd = '{$pwdi}'; //数据库密码
\$dbname = '{$dbi}'; //数据库名称

?>";
		file_put_contents('config.php',$config);
		echo "保存成功!<br><a href='{$_SERVER['PHP_SELF']}?do=4'>下一步</a>";
	}
}
}

if($do=='4') {
require 'config.php';
if(defined("SAE_ACCESSKEY"))
{
	require 'includes/sae.php';
	//SaeStorage 文件存储检测
	$storage = new SaeStorage();
	$storage->write($Storage,'test.txt','ceshi') or die('开启SaeStorage失败，请检查SaeStorage设置状态以及config.php里的Storage参数');
	$storage->delete($Storage,'test.txt');
}
if(!defined("SAE_ACCESSKEY") && (!$user||!$pwd||!$dbname)) {
echo "请先填写好数据库并保存后再安装";
} else {
$sql = "CREATE TABLE udisk (\n"
    . " `id` int(11) NOT NULL auto_increment,\n"
    . " `filename` varchar(255) NOT NULL,\n"
    . " `size` varchar(14) NOT NULL,\n"
    . " `datetime` datetime NOT NULL,\n"
    . " `type` varchar(255) NOT NULL,\n"
    . " `fileurl` varchar(255) NOT NULL,\n"
    . " `ip` varchar(15) NOT NULL,\n"
	. " `hide` int(1) NOT NULL DEFAULT 0,\n"
	. " `pwd` varchar(255) NULL,\n"
    . " PRIMARY KEY (`id`)\n"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$cn = mysql_connect($host,$user,$pwd);
if (!$cn)
die('err:'.mysql_error());
mysql_select_db($dbname,$cn) or die('err:'.mysql_error());
mysql_query("set names utf8",$cn);

if(mysql_query($sql)) {
	@file_put_contents("install.lock",'install');
	echo '<font color="green">安装成功！</font><br/><a href="./">>>网站首页</a><br/><br/><font color="#FF0033">如果你的空间不支持本地文件读写，请自行建立 install.lock 文件！</font>';
} else {
	echo '<font color="red">安装失败！</font> '.mysql_error();
}

}
}


}

echo'</div><div class="footer">';
echo'© Copyright <a href="http://blog.cccyun.cn/" target="_blank">彩虹</a>';;
echo'</div></body></html>';
?>