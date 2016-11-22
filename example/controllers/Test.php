<?php
namespace demo;

use laocc\gds\Code;
use laocc\gds\Code1;
use laocc\gds\Code2;
use laocc\gds\Icon;
use laocc\gds\Image;

class TestController
{

    /**
     * 显示验证码，包括验证
     */
    public function icon()
    {
        echo <<<HTML
        <form action="?action=icon" method="post" enctype="multipart/form-data" 
        style="display:block;width:400px;padding:10px;margin:10px;border: 1px solid #789;overflow: hidden;background: #ffe;">
        <ul style="margin:0;">
           <li><label for="value" style="float: left;">选择源文件：</label>
            <input type="file" id="file" name="file" style="float: left;">
            </li> 
            <li><label for="size" style="float: left;">选择ICO格式：</label>
            <select name="size" id="size" style="width:100px;height: 30px;float:left;">
                <option value="16">16x16</option>
                <option value="32" selected>32x32</option>
                <option value="48">48x48</option>
                <option value="64">64x64</option>
            </select>
            </li> 
            <li><label for="code" style="float: left;">输入验证码：</label>
            <input type="text" autocomplete="off" id="code" name="code" style="width:100px;height: 30px;float:left;">
            <img src="?action=code" onclick="this.src='?action=code&rand='+ Math.random();" style="padding:0;margin:0;border:0;width:100px;height: 30px;float:left;" alt="点击刷新">
            </li> 
            <li><input type="submit" value="提交表单" style="width:100px;height: 30px;float:left;"></li>
           </ul>
</form>
HTML;

        if (!empty($_POST)) {
            echo '<hr>';
            if ($chk = Code::check(isset($_POST['code']) ? $_POST['code'] : null)) {
                $this->create_icon($_FILES['file']['tmp_name'], $_POST['size']);
            } else {
                echo '<div style="font-size:16px;color:red;">验证码错误</div>';
            }
        }
    }

    private function create_icon($file, $size = 32)
    {
        $file_save = "/img/icon_{$size}.ico";
        if ($filename = Icon::create($file, $size, _ROOT . $file_save)) {
            echo "<img src='{$file_save}'>";
        }
        var_dump($filename);
    }


    /**
     * 显示验证码
     */
    public function code()
    {
        $conf = [
            'charset' => 'en',      //使用中文或英文验证码，cn=中文，en=英文，若create()指定了，则以指定的为准
            'length' => [3, 5],     //验证码长度范围
            'size' => [100, 30],    //宽度，高度
            'span' => [-15, -10],    //字间距随机范围
            'angle' => [-30, 30],   //角度范围，建议不要超过±45
            'line' => [4, 6],       //产生的线条数
            'point' => [80, 100],   //产生的雪花点数

            //分别是中英文字体，要确保这些文件真实存在
//            'en_font' => ['../fonts/arial.ttf' => 0, '../fonts/ariblk.ttf' => 1],
//            'cn_font' => ['../fonts/simkai.ttf' => 0, '../fonts/ygyxsziti2.0.ttf' => 1],

            //下面四种颜色均是指范围，0-255之间，值越大颜色越浅。
            'b_color' => [157, 255],     //背景色范围
            'p_color' => [200, 255],     //雪花点颜色范围
            'l_color' => [50, 200],      //干扰线颜色范围
            'c_color' => [10, 156],      //验证码字颜色范围

            'cookies' => [  //Cookies相关定义
                'key' => '__C__',   //Cookies键
                'attach' => 'D',    //附加固定字符串
                'date' => 'YmdH',   //附加时间标识用于date()函数，同时也是有效期
            ],
            'type' => 1,//式样1
        ];
        Code::create($conf);

    }


    /**
     * 生成二维码
     *
     * 二维码参数越多越耗时，特别是加图片，下面例程除二维码本身外，另加载了三个图片文件，所以运行起来有点耗时
     */
    public function code2()
    {
        $option = array();
        $option["text"] = "这是一个复杂的二维码 \n生成时间：" . date('Y-m-d H:i:s');   //二维码的内容
        $option["level"] = "Q";    //可选LMQH
        $option["size"] = 10;    //每条线像素点,一般不需要动，若要固定尺寸，用width限制
        $option["margin"] = 1;    //二维码外框空白，指1个size单位，不是指像素
        $option["save"] = 1;    //0：只显示，1：只保存，2：即显示也保存
        $option["width"] = 0;     //生成的二维码宽高，若不指定则以像素点计算

        $option["color"] = '#000000';   //二维码本色，也可以是图片
        $option["background"] = '#fffff5';  //二维码背景色
        $option["color"] = _ROOT . '/pic/sky.jpg';   //二维码本色，也可以是图片
//        $option["background"] = _ROOT . '/pic/background.jpg';  //二维码背景色
        //TODO 目前 主色和背景，最多只能一个是图片，以后可能改为可以同时图片

        $option["root"] = _ROOT;  //保存目录
        $option["path"] = 'img';        //目录里的文件夹
        $option["filename"] = 'code2.png';        //目录里的文件夹

        $option["logo"] = _ROOT . '/pic/logo.jpg';         //LOGO图片
        $option["border"] = '#def';  //LOGO外边框颜色

        $option["parent"] = _ROOT . '/pic/girl.jpg';//一个文件地址，将二维码贴在这个图片上
        $option["parent_x"] = 50;//若指定，则以指定为准
        $option["parent_y"] = 50;//为null时，居中

        $option["shadow"] = '#789';//阴影颜色，颜色色值，只有当parent存在时有效
        $option["shadow_x"] = 6;//阴影向右偏移，若为负数则向左
        $option["shadow_y"] = 6;//阴影向下偏移，若为负数则向上
        $option["shadow_alpha"] = 80;//透明度，百分数

        if ($file = Code2::create($option)) {
            echo "<img src='{$file['path']}{$file['filename']}'>";
        }
        var_dump($file);

    }

    /**
     * 生成二维码
     */
    public function code2s()
    {
        $option = array();
        $option["text"] = "这是一个简洁的二维码 \n生成时间：" . date('Y-m-d H:i:s');   //二维码的内容
        $option["level"] = "Q";    //可选LMQH
        $option["size"] = 10;    //每条线像素点,一般不需要动，若要固定尺寸，用width限制
        $option["margin"] = 1;    //二维码外框空白，指1个size单位，不是指像素
        $option["save"] = 1;    //0：只显示，1：只保存，2：即显示也保存
        $option["width"] = 0;     //生成的二维码宽高，若不指定则以像素点计算

        $option["root"] = _ROOT;  //保存目录
        $option["path"] = 'img';        //目录里的文件夹
        $option["filename"] = 'code2s.png';        //目录里的文件夹

        if ($file = Code2::create($option)) {
            echo "<img src='{$file['path']}{$file['filename']}'>";
        }
        var_dump($file);

    }


    /**
     * 条形码
     */
    public function code1()
    {
        $code = [];
        $code['code'] = mt_rand(1000000000, 9999999999);  //条码内容
        $code['font'] = null;       //字体，若不指定，则用PHP默认字体
        $code['size'] = 10;         //字体大小
        $code['split'] = 4;         //条码值分组，每组字符个数，=0不分，=null不显示条码值
        $code['pixel'] = 3;         //分辨率即每个点显示的像素，建议3-5
        $code['height'] = 20;       //条码部分高，实际像素为此值乘pixel
        $code['style'] = 'C';      //条码格式，可选：A,B,C,或null，若为null则等同于C
        $code['root'] = _ROOT;      //保存文件目录，不含在URL中部分
        $code['path'] = 'img';   //含在URL部分
        $code['filename'] = 'code1.jpg';      //不带此参，或此参为false值，则随机产生
        $code['save'] = 1;      //0：显示，1：保存，2：保存+显示

        if ($file = Code1::create($code)) {
            echo "<img src='{$file['path']}{$file['filename']}'>";
        }
        var_dump($file);
    }

    /**
     * 加水印
     */
    public function mark()
    {
        //这个copy只是为了省得测试时总要改源文件名，实际使用不要这样
        $resource = _ROOT . '/pic/test.png';
        $file = _ROOT . '/img/mak.png';
        copy($resource, $file);

        $config = [
            'backup' => false,//备份，实际使用请打开，备份方法为复加后缀
            'img' => [
                'file' => _ROOT . '/pic/logo.png',
                'position' => 5,//位置，按九宫位
                'offset' => [mt_rand(-100, 100), mt_rand(-100, 100)],//计算位置后的偏移量
                'color' => '#ffffff',//要抽取的水印背景色，对PNG无效
                'alpha' => 60,//透明度，对PNG无效，PNG的透明度由其自身决定
            ],
            'txt' => [
                'text' => '测试文字水印' . date('Y-m-d H:i:s'),
                'size' => 15,
                'color' => '#f00',
                'alpha' => 100,
                'shade' => [1, 1],
                'shade_color' => '#555555',
                'position' => 8,//位置，按九宫位
                'offset' => [0, mt_rand(-50, -10)],
            ],
        ];

        if ($create = Image::mark($file, $config)) {
            echo "处理文件：{$file}<br />", '<img src="/img/mak.png">';
        } else {
            var_dump($create);
        }
    }
}