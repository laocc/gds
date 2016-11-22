<?php
ini_set('error_reporting', -1);
ini_set('display_errors', true);
ini_set('date.timezone', 'Asia/Shanghai');

include '../kernel/autoload.php';

$file = __DIR__ . '/1.png';
copy(__DIR__ . '/img/0.jpg', $file);

$config = [
    'backup' => false,
    'img' => [
        'file' => __DIR__ . '/img/logo.png',
        'position' => 5,//位置，按九宫位
        'offset' => [0, 0],//计算位置后的偏移量
        'color' => '#ffffff',//要抽取的水印背景色，对PNG无效
        'alpha' => 60,//透明度，对PNG无效，PNG的透明度由其自身决定
    ],
    'txt' => [
        'text' => '测试文字水印' . date('Y-m-d H:i:s'),
//        'text' => 'abc',
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