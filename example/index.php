<?php
ini_set('error_reporting', -1);
ini_set('display_errors', true);
ini_set('date.timezone', 'Asia/Shanghai');

include '../kernel/autoload.php';

//这个copy只是为了省得测试时总要改源文件名，实际使用不要这样
$resource = __DIR__ . '/img/test.png';
$file = __DIR__ . '/test.png';
copy($resource, $file);

$config = [
    'backup' => false,//备份，实际使用请打开，备份方法为复加后缀
    'img' => [
        'file' => __DIR__ . '/img/logo.png',
        'position' => 5,//位置，按九宫位
        'offset' => [0, 0],//计算位置后的偏移量
        'color' => '#ffffff',//要抽取的水印背景色，对PNG无效
        'alpha' => 60,//透明度，对PNG无效，PNG的透明度由其自身决定
    ],
    'txt----no' => [
        'text' => '测试文字水印' . date('Y-m-d H:i:s'),
        'size' => 10,
        'color' => '#f00',
        'alpha' => 100,
        'shade' => [2, 2],
        'shade_color' => '#555555',
        'position' => 8,//位置，按九宫位
        'offset' => [0, -30],
    ],
];

$create = \laocc\gds\Image::mark($file, $config);
var_dump($create);