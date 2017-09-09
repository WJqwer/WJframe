<?php
//命名空间
namespace houdunwang\core;

class Boot
{
    /**
     * 执行应用
     */
    //定义一个静态的方法
    public static function run()
    {
        //初始化框架
        self::init();
        //执行应用
        self::appRun();
    }

    /**
     * 执行应用
     */
    //定义一个静态的方法
    //判断get的变化
    public static function appRun()
    {
        //用if来判断使用哪个方法
        //判断get地址栏里是否有s这个参数
        if (isset($_GET['s'])){
            //将get地址栏里接受到的参数s拆分成数组，用‘/’来拆分
            $info = explode('/',$_GET['s']);
            //对象方法
            //当地址栏没有参数就默认一个类的方法，后面是这个类的具体路径，ucfirst将文件的首字母大写
            $class = "\app\\{$info[0]}\contrpller\\" . ucfirst($info[1]);
            //方法的名字
            //将对象名赋给$action
            $action = $info['2'];
            //定义常量
            define('MODULE',$info[0]);
            define('CONTROLLER',$info[1]);
            define('ACTION',$info[2]);
        }else{
            //对象方法
            //当地址栏没有参数就默认一个类的方法，后面是这个类的具体路径
            $class = "\app\home\contrpller\Entry";
            //方法的名字
            //将对象名赋给$action
            $action = 'index';
            //定义常量
            define('MODULE','home');
            define('CONTROLLER','entry');
            define('ACTION','index');
        }
        //来会调实例化对象方法、对象名
        echo call_user_func_array([new $class,$action],[]);
    }

    /**
     * 初始化框架
     */
    //定义一个静态的方法
    public static function init()
    {
        //声明变量
        //不加头部，浏览器输出就会出现乱码
        header('Content-type:text/html;charset=utf8');
        //设置时区
        //不设置时区，使用时时间就可能会不正确
        date_default_timezone_set('PRC');
        //开始session
        //使用session必须开启，session_id开启了则不再重复开启session
        session_id()|| session_start();
    }
}