<?php
error_reporting(0);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');

$u=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$siteurl=explode('/',$u);
if (($length = count($siteurl)) > 1) {
$u=str_ireplace('wap/','',$u);
$u='http://'.str_ireplace($siteurl[$length - 1],'',$u);
}
session_start();

require ROOT.'config.php';
if(defined("SAE_ACCESSKEY"))
require ROOT.'includes/sae.php';
if(!isset($port))$port='3306';

if(!defined('SQLITE') && (!$user||!$pwd||!$dbname))//检测安装
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="install.php">点此安装</a>';
exit();
}

include_once ROOT.'includes/db.class.php';
include_once ROOT.'includes/storage.class.php';
include_once ROOT.'includes/main.func.php';
include_once ROOT.'includes/display.func.php';

if(defined('SQLITE'))$DB=new DB($db_file);
else $DB=new DB($host,$user,$pwd,$dbname,$port);

date_default_timezone_set("PRC");
$date = date("Y-m-j H:i:s ");

if($DB->query("select * from udisk where 1")==FALSE && !preg_match('/\/install.php/i', $u))//检测安装
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="install.php">点此安装</a>';
exit();
}

//加载存储模块
$stor=new stor($Storage);

if(defined("SAE_ACCESSKEY"))
$cachedir=SAE_TMP_PATH;
else
$cachedir=ROOT.'cache/';

if(isset($title))include_once(ROOT."includes/head.php");
?>