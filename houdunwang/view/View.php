<?php
//命名空间
namespace houdunwang\view;

class View
{
    /**
     * 当调用不存在的方法时候出发
     * @param $name			不存在方法名称
     * @param $arguments	方法参数
     *
     * @return mixed
     */
    //public类的内部、外部、子类都可以使用
    //这里设定了一个普同的不存在的方法
    public function __call($name, $arguments)
    {
        //调用自定义方法
        return self::parseAction($name,$arguments);
    }

    /**
     * 当静态调用不存在的方法时候出发
     * @param $name			不存在方法名称
     * @param $arguments	方法参数
     *
     * @return mixed
     */
    //public类的内部、外部、子类都可以使用
    //这里设定了一个静态的不存在方法
    public static function __callStatic($name, $arguments)
    {
        //调用自定义方法
        return self::parseAction($name,$arguments);
    }

    //public类的内部、外部、子类都可以使用
    //这里是设定一个静态的方法
    public static function parseAction($name,$arguments)
    {
        //实例化Base里的方法
        return call_user_func_array([new Base,$name],$arguments);
    }
}