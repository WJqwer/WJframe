<?php
//命名空间
namespace houdunwang\view;

class View
{
    /**
     * 当调用不存在的方法时触发
     * @param $name         不存在方法名称
     * @param $arguments    方法参数
     *
     * @return mixed
     */
    //public在类的内部、子类、外部都可以使用
    //设定一个普同调用不存在的方法
    public function _call($name,$arguments)
    {
        //返回一个静态的自定义方法
        return self::parseAction($name,$arguments);
    }

    /**
     * 当静态调用不存在的方法时触发
     * @param $name         不存在方法名称
     * @param $arguments    方法参数
     *
     * @return mixed
     */
    //public在类的内部、子类、外部都可以使用
    //设定一个普通的不存在的方法的方法名和参数
    public static function _callStatic ($name,$arguments)
    {
        //返回一个自定的静态方法找不到时就执行base的方法
        return self::parseAction($name,$arguments);
    }

    //public在类的内部、子类、外部都可以使用
    //设定一个静态的自定义方法
    public static function parseAction($name,$arguments)
    {
        //返回实例化方法的方法名和参数
        return call_user_func_array([new Base,$name],$arguments);
    }
}