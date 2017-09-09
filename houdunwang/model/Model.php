<?php
//命名空间
namespace houdunwang\model;

class Model
{
    //public在类的内部、子类、外部都可以使用
    //设定一个普通的方法，对象名和参数
    public static function __callStatic($name, $arguments)
    {
        //返回一个静态的自定义方法
        return self::parseAction($name,$arguments);
    }

    //public在类的内部、子类、外部都可以使用
    //设定一个普通的不存在的方法的方法名和参数
    public function __call($name, $arguments)
    {
        //返回一个自定的静态方法找不到时就执行base的方法
        return self::parseAction($name,$arguments);
    }

    //public在类的内部、子类、外部都可以使用
    //设定一个静态的自定义方法
    public static function parseAction($name,$argument)
    {
        //获取静态绑定后的类名
        $class = get_called_class();
        return call_user_func_array([new Base($class),$name],$argument);
    }
}