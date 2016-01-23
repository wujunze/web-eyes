<?php
header('Content-type:text/html;charset=utf-8');

if($iswap==true)
{
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
}
else
{
echo '<!doctype html>
<html lang="zh-cn">';
}
echo <<<HTML
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{$title}</title>
<meta name="keywords" content="网盘,网络U盘,网络硬盘,免费网盘,网盘下载,网盘资源,图片外链,音乐外链,视频外链,云存储,离线下载" />
<meta name="description" content="本站为您提供文件的网络备份、同步和分享服务。空间大、速度快、安全稳固，支持手机端。可以生成文件外链、图片外链、音乐视频外链，还可支持文本、图片、音乐、视频在线预览" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
HTML;
?>