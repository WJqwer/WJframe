<?php
//命名空间
namespace houdunwang\core;

class Boot
{
    /**
     * 执行应用
     */
    //public类的内部、外部、子类都可以使用
    // 这里是设定一个静态的方法
    public static function run()
    {
        //self::是引用类中的一个方法
        //这里是引用这个类库方法，也就是运行时抛出异常的设置
        self::handler();
        //self::是引用类中的一个方法
        //这里是引用初始化框架的方法
        self::init();
        //self::是引用类中的一个方法
        //这里是引用执行应用的方法
        //？s=home/entry/add
        self::appRun();
    }

    /**
     * 运行抛出异常
     */
    //private定义类的属性和方法，在类的内部使用
    //这里是设定了一个静态的方法
    private static function handler()
    {
        //这样的设置是当出现错误时可以用漂亮的错误页面来显示
        $whoops = new\Whoops\Run;
        $whoops->pushHandler(new\Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    /**
     * 执行应用
     */
    //public类的内部、外部、子类都可以使用
    //这里是设定一个静态的方法
    public static function appRun()
    {
        //isset检测变量是否设置，$_GET是用来接收值的
        //if判断$_GET接收的值是否为变量
        if (isset($_GET['s'])){
            //地址栏有s参数
            //home/entry/index:模块/控制器/方法
            //dd($_GET['s']);
            //explode（）使用一个字符串分割另一个字符串
            //这里是将组成路径的一个命名空间赋给$info
            $info = explode('/',$_GET['s']);
            //dd($info);
            //数组类型：
            //Array
            //(
                //[0] => home
                //[1] => entry
                //[2] => index
            //)
            //ucfirst把字符串中的首字符转换为大写
            //这个是将这个方法的方法名赋给$class
            $class = "\app\\{$info[0]}\controller\\". ucfirst ($info[1]);
            //dd($class);
            //将这个方法赋给$action
            $action = $info['2'];
            //定义常量
            define('MODULE',$info[0]);
            define('CONTROLLER',$info[1]);
            define('ACTION',$info[2]);
        }else{
            //地址栏没有s参数，需要给默认值
            //这个是将这个方法的方法名赋给$class
            $class = "\app\home\controller\Entry";
            //将这个方法赋给$action
            $action = 'index';
            //定义常量
            define('MODULE','home');
            define('CONTROLLER','entry');
            define('ACTION','index');
        }
        //call_user_func_array调用一个用户定义的函数，参数以('函数名','函数参数数组')的方式定义。
        //实例化$class，$action这些方法
        //这里是实例化一个类
        echo call_user_func_array([new $class,$action],[]);
    }

    /**
     * 初始化框架
     */
    //public类的内部、外部、子类都可以使用
    //是定一个静态的方法
    public static function init()
    {
        //声明头部
        //不加头部的话，浏览器输出就会出现乱码
        header('Content-type:text/html;charset=utf8');
        //设置时区
        //我们要根据我们所在的位置设置时区，就如北京时区
        //如果不是的话，使用时间的时候很有可能会出现时间不正确
        date_default_timezone_set('PRC');
        //开始session
        //开始时必须要开启session，不开启是没有办法出现我们想要的效果
        //如果里面有session_id就不必在开启session，没有还是要开启的
        session_id() || session_start();
    }
}