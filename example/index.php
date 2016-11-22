<?php
ini_set('error_reporting', -1);
ini_set('display_errors', true);
ini_set('date.timezone', 'Asia/Shanghai');

define('_ROOT', (__DIR__));
include '../kernel/autoload.php';
$action = isset($_GET['action']) ? $_GET['action'] : null;

if (in_array($action, ['mark', 'code', 'code1', 'code2', 'code2s', 'icon'])) {
    echo <<<HTML
    <style>
        html,body{width:100%;}
        a{color:#000;}
        ul,li{list-style: none;}
        ul{clear:both;display:block;width:100%;height:50px;}
        li{float:left;margin:10px;}
        img{margin:10px;padding:10px;border:1px solid #abc;}
    </style>
    <title>测试</title>
    <ul>
        <li><a href="?action=mark">加水印</a></li>
        <li><a href="?action=code">验证码</a></li>
        <li><a href="?action=code1">条形码</a></li>
        <li><a href="?action=code2">复杂二维码</a></li>
        <li><a href="?action=code2s">简洁二维码</a></li>
        <li><a href="?action=icon">生成ICO</a></li>
    </ul>
HTML;

    $obj = new \demo\TestController();
    $obj->{$action}();
} elseif (in_array($action, ['code_show'])) {
    $obj = new \demo\TestController();
    $obj->{$action}();
}

