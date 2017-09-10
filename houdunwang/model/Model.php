<?php
//命名空间
namespace houdunwang\model;

use houdunwang\model\Base;

class Model
{
    //public类的内部、外部、子类都可以使用
    //设定一个普通的不存在的方法
    public function __call($name, $arguments)
    {
        //调用自定义方法
        return self::parseAction($name,$arguments);
    }

    //public类的内部、外部、子类都可以使用
    //设定一个静态不存在的方法
    public static function __callStatic($name, $arguments)
    {
        //调用自定义的方法
        return self::parseAction($name,$arguments);
    }

    //public类的内部、外部、子类都可以使用
    //设定一个静态方法
    public static function parseAction($name,$arguments)
    {
        //get_called_class（）获取静态方法调用的类名
        //这里是将获取的静态方法类名赋给$class
        $class = get_called_class();
        //实例化Base里的方法


        return call_user_func_array([new Base($class),$name],$arguments);
    }
}