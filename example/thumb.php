<?php
ini_set('error_reporting', -1);
ini_set('display_errors', true);
ini_set('date.timezone', 'Asia/Shanghai');

include '../kernel/autoload.php';

$conf = [
    'save' => 0,//0：只显示，1：只保存，2：即显示也保存
    'cache' => true,
    'background' => '#FFD6EB',//v模式下缩图的背景色
    'alpha' => true,//v模式时若遇png，背景部分是否写成透明背景
    'pattern' => null,
    'tclip' => 0,//=true使用tclip生成x模式，但tclip时肯定会被保存，所以测试时不要用，否则会产生大量临时文件
];

\laocc\gds\Image::thumbs($conf);